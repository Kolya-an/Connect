<?php

namespace App\Livewire\Patient;

use App\Models\PhotoConsent;
use App\Services\DiiaSignService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PhotoConsentSign extends Component
{
    public string $token;

    public ?PhotoConsent $consent = null;

    public ?string $qrCodeUrl = null;

    public ?string $deepLink = null;

    public string $signStatus = 'pending'; // pending, signed, expired

    // Час закінчення дії сесії (3 хвилини)
    public ?int $expiresAt = null;

    public bool $isSigned = false;

    public function mount(string $token, DiiaSignService $diiaService)
    {
        $this->token = $token;

        $this->consent = PhotoConsent::with([
            'doctorPhoto.doctor.user',
            'userSignature',
        ])
            ->where('token', $token)
            ->firstOrFail();

        if ($this->consent->status === 'signed') {
            $this->signStatus = 'signed';

            return;
        }

        // Встановлюємо таймаут сесії на 3 хвилини
        $this->expiresAt = now()->addMinutes(3)->timestamp;

        $this->initiateDiiaSession($diiaService);
    }

    private function initiateDiiaSession(DiiaSignService $diiaService)
    {
        try {
            $branchId = config('services.diia.branch_id');
            $offerId = config('services.diia.offer_id');

            if (empty($branchId) || empty($offerId)) {
                logger()->error(
                    'DIIA_BRANCH_ID або DIIA_OFFER_ID відсутні у конфігурації.'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | 1. Формуємо Base64 для фото
            |--------------------------------------------------------------------------
            */

            $photoBase64 = null;

            $photoPath = $this->consent->doctorPhoto?->path;

            if (
                $photoPath
                && Storage::disk('public')->exists($photoPath)
            ) {
                $photoBase64 = base64_encode(
                    Storage::disk('public')->get($photoPath)
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Формуємо PDF
            |--------------------------------------------------------------------------
            |
            | PDF необхідно сформувати ДО підпису, оскільки саме його hash
            | передається у Дію.
            |
            | Але цей PDF до підпису НЕ є фінальним документом consent.
            | Він зберігається тільки тимчасово у storage/app/diia-pending.
            |
            */

            $pdf = Pdf::loadView(
                'pdf.photo-consent',
                [
                    'consent' => $this->consent,
                    'photoBase64' => $photoBase64,
                    'signerInfo' => [
                        'name' => 'Очікує підпису',
                        'drfo' => '',
                        'signed_at' => null,
                    ],
                ]
            );

            // Отримуємо точні байти PDF
            $pdfOutput = $pdf->output();

            /*
            |--------------------------------------------------------------------------
            | 3. Генеруємо унікальний requestId
            |--------------------------------------------------------------------------
            |
            | До БД його НЕ записуємо.
            | Він буде використовуватися для тимчасового зв'язку
            | між сесією Дія та PhotoConsent через Cache.
            |
            */

            $requestId = (string) Str::uuid();

            /*
            |--------------------------------------------------------------------------
            | 4. Тимчасово зберігаємо PDF
            |--------------------------------------------------------------------------
            |
            | Файл НЕ потрапляє у public/storage/consents.
            |
            | Він зберігається тут:
            |
            | storage/app/diia-pending/{requestId}.pdf
            |
            */

            $temporaryPdfPath = 'diia-pending/' . $requestId . '.pdf';

            if (
                !Storage::disk('local')->put(
                    $temporaryPdfPath,
                    $pdfOutput
                )
            ) {
                throw new \RuntimeException(
                    "Не вдалося зберегти тимчасовий PDF: {$temporaryPdfPath}"
                );
            }

            if (!Storage::disk('local')->exists($temporaryPdfPath)) {
                throw new \RuntimeException(
                    "Тимчасовий PDF не знайдений: {$temporaryPdfPath}"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 5. Рахуємо SHA-256 саме збереженого temporary PDF
            |--------------------------------------------------------------------------
            */

            $pdfBytes = Storage::disk('local')->get($temporaryPdfPath);

            $fileHash = base64_encode(
                hash('sha256', $pdfBytes, true)
            );

            /*
            |--------------------------------------------------------------------------
            | 6. Зберігаємо технічні дані сесії у Cache
            |--------------------------------------------------------------------------
            |
            | ВАЖЛИВО:
            | тут немає signed/status/pdf_path у PhotoConsent.
            |
            | Дані потрібні webhook після завершення підпису.
            |
            */

            Cache::put(
                'diia_consent:' . $requestId,
                [
                    'consent_id' => $this->consent->id,
                    'token' => $this->consent->token,
                    'temporary_pdf_path' => $temporaryPdfPath,
                    'file_name' => "Zgoda_na_pidpys_{$this->consent->id}.pdf",
                    'file_hash' => $fileHash,
                ],
                now()->addMinutes(10)
            );

            /*
            |--------------------------------------------------------------------------
            | 7. Формуємо payload для Дії
            |--------------------------------------------------------------------------
            */

            $payload = [
                'requestId' => $requestId,

                'returnLink' => route('consent.success', [
                    'token' => $this->token,
                ]),

                'hashedFiles' => [
                    [
                        'fileName' => "Zgoda_na_pidpys_{$this->consent->id}.pdf",
                        'fileHash' => $fileHash,
                    ],
                ],
            ];

            /*
            |--------------------------------------------------------------------------
            | 8. Робимо запит до Дії
            |--------------------------------------------------------------------------
            */

            $sessionData = $diiaService->createHashedFilesSession(
                $branchId,
                $offerId,
                $payload
            );

            /*
            |--------------------------------------------------------------------------
            | 9. Обробка отриманого deepLink
            |--------------------------------------------------------------------------
            */

            $rawDeepLink =
                $sessionData['deeplink']
                ?? $sessionData['deepLink']
                ?? null;

            if (
                is_string($rawDeepLink)
                && $this->isValidDiiaDeepLink($rawDeepLink)
            ) {
                $this->deepLink = $rawDeepLink;
            } else {
                logger()->warning(
                    "Отримано некоректний deepLink від API Дії " .
                    "для Consent #{$this->consent->id}:",
                    [
                        'received_value' => $rawDeepLink,
                    ]
                );

                $this->deepLink = null;
            }

            /*
            |--------------------------------------------------------------------------
            | 10. Обробка QR-коду
            |--------------------------------------------------------------------------
            */

            if (
                !empty($sessionData['qrCodeUrl'])
                && $sessionData['qrCodeUrl'] !== '...'
            ) {
                $this->qrCodeUrl = $sessionData['qrCodeUrl'];
            } elseif ($this->deepLink) {
                if (class_exists(QrCode::class)) {
                    $this->qrCodeUrl =
                        'data:image/svg+xml;base64,' .
                        base64_encode(
                            QrCode::format('svg')
                                ->size(224)
                                ->margin(1)
                                ->generate($this->deepLink)
                        );
                } else {
                    $this->qrCodeUrl =
                        'https://quickchart.io/qr?size=224&margin=1&text=' .
                        urlencode($this->deepLink);
                }
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $errorBody = $e->response
                ? $e->response->body()
                : $e->getMessage();

            logger()->error(
                'Diia API Request Exception: ' . $errorBody
            );

            session()->flash(
                'error',
                'Помилка API Дії: ' . $errorBody
            );
        } catch (\Throwable $e) {
            logger()->error(
                'Diia Session Creation Error: ' . $e->getMessage(),
                [
                    'trace' => $e->getTraceAsString(),
                ]
            );

            session()->flash(
                'error',
                'Сталася помилка: ' . $e->getMessage()
            );
        }
    }

    /**
     * Перевірка, чи є рядок валідним DeepLink від Дії
     */
    private function isValidDiiaDeepLink(string $url): bool
    {
        if (
            !filter_var($url, FILTER_VALIDATE_URL)
            && !str_starts_with($url, 'diia://')
        ) {
            return false;
        }

        return (bool) preg_match(
            '/^(https:\/\/(?:[a-z0-9-]+\.)?(?:diia\.app|diia\.gov\.ua)\/|diia:\/\/)/i',
            $url
        );
    }

    public function checkDiiaStatus()
    {
        if ($this->signStatus !== 'pending') {
            return;
        }

        if ($this->expiresAt !== null && now()->timestamp > $this->expiresAt) {
            $this->signStatus = 'expired';
            return;
        }

        $this->consent->refresh();

        if ($this->consent->status === 'signed') {
            $this->signStatus = 'signed';
            $this->isSigned = true;
        }
    }

    public function retrySign(DiiaSignService $diiaService)
    {
        $this->signStatus = 'pending';

        $this->expiresAt = now()->addMinutes(3)->timestamp;

        $this->qrCodeUrl = null;
        $this->deepLink = null;

        $this->initiateDiiaSession($diiaService);
    }

    public function render()
    {
        return view('livewire.patient.photo-consent-sign');
    }
}