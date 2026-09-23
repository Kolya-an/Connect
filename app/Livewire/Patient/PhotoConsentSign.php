<?php

namespace App\Livewire\Patient;

use App\Models\PhotoConsent;
use App\Services\DiiaSignService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PhotoConsentSign extends Component
{
    public string $token;

    public ?PhotoConsent $consent = null;

    public ?string $qrCodeUrl = null;

    public ?string $deepLink = null;

    public string $signStatus = 'pending'; // 'pending', 'signed', 'expired'

    // Час закінчення дії сесії (3 хвилини від моменту ініціалізації)
    public ?int $expiresAt = null;

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

        // Встановлюємо таймаут сесії на 3 хвилини (180 секунд)
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
            | ЦЕЙ PDF є оригінальним документом, hash якого буде
            | переданий у Дію.
            |
            | Після цього PDF більше НЕ повинен генеруватися повторно.
            |
            */

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
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
            | 3. Зберігаємо ОРИГІНАЛЬНИЙ PDF
            |--------------------------------------------------------------------------
            |
            | Важливо:
            | саме ці байти використовуються для SHA-256.
            |
            */

          $pdfPath = 'storage/consents/consent_' .
    $this->consent->token .
    '.pdf';

$fullPdfPath = public_path($pdfPath);

$directory = public_path('storage/consents');

if (!is_dir($directory)) {
    if (!mkdir($directory, 0775, true) && !is_dir($directory)) {
        throw new \RuntimeException(
            "Не вдалося створити каталог: {$directory}"
        );
    }
}

if (file_put_contents($fullPdfPath, $pdfOutput) === false) {
    throw new \RuntimeException(
        "Не вдалося зберегти PDF: {$fullPdfPath}"
    );
}

/*
|--------------------------------------------------------------------------
| 4. Перевіряємо, що файл реально збережений
|--------------------------------------------------------------------------
*/

if (
    !file_exists($fullPdfPath) ||
    filesize($fullPdfPath) === 0
) {
    throw new \RuntimeException(
        "Збережений PDF не знайдений або порожній: {$fullPdfPath}"
    );
}

            /*
            |--------------------------------------------------------------------------
            | 5. Рахуємо SHA-256 саме збереженого PDF
            |--------------------------------------------------------------------------
            */

            $fileHash = base64_encode(
                hash('sha256', $pdfOutput, true)
            );

            Log::info('DIIA PDF DEBUG', [
                'consent_id' => $this->consent->id,
                'pdf_path' => $pdfPath,
                'pdf_size' => strlen($pdfOutput),
                'pdf_sha256_hex' => hash('sha256', $pdfOutput),
                'pdf_sha256_base64' => $fileHash,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 6. Зберігаємо шлях до PDF у PhotoConsent
            |--------------------------------------------------------------------------
            */

            $this->consent->pdf_path = $pdfPath;
            $this->consent->save();

            /*
            |--------------------------------------------------------------------------
            | 7. Генеруємо унікальний requestId
            |--------------------------------------------------------------------------
            */

            $requestId = (string) Str::uuid();

            $this->consent->diia_session_id = $requestId;
            $this->consent->save();

            $this->consent->refresh();

            Log::info('DIIA SESSION ID SAVE DEBUG', [
                'consent_id' => $this->consent->id,
                'requestId' => $requestId,
                'saved_diia_session_id' => $this->consent->diia_session_id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 8. Перевіряємо значення напряму з БД
            |--------------------------------------------------------------------------
            */

            $check = PhotoConsent::find($this->consent->id);

            Log::info('DIIA DB DIRECT CHECK', [
                'consent_id' => $this->consent->id,
                'requestId' => $requestId,
                'db_diia_session_id' => $check?->diia_session_id,
                'db_pdf_path' => $check?->pdf_path,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 9. Формуємо payload для Дії
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

            Log::info('DIIA HASH DEBUG', [
                'requestId' => $requestId,
                'fileHash' => $fileHash,
                'pdf_path' => $pdfPath,
            ]);

            Log::info('DIIA OFFER REQUEST BODY', [
                'payload' => $payload,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 10. Робимо запит до Дії
            |--------------------------------------------------------------------------
            */

            $sessionData = $diiaService->createHashedFilesSession(
                $branchId,
                $offerId,
                $payload
            );

            /*
            |--------------------------------------------------------------------------
            | 11. Обробка отриманого deepLink
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
            | 12. Обробка QR-коду
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

        // Перевіряємо, чи не вичерпано ліміт у 3 хвилини
        if (
            $this->expiresAt !== null
            && now()->timestamp > $this->expiresAt
        ) {
            $this->signStatus = 'expired';

            return;
        }

        $this->consent->refresh();

        if ($this->consent->status === 'signed') {
            $this->signStatus = 'signed';

            if (
                $this->consent->doctorPhoto
                && !$this->consent->doctorPhoto->is_published
            ) {
                $this->consent->doctorPhoto->update([
                    'is_published' => true,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | PDF більше НЕ генеруємо тут.
            |--------------------------------------------------------------------------
            |
            | Він уже був створений до підписання,
            | його hash переданий Дії,
            | і саме цей файл зберігається у pdf_path.
            |
            */
        }
    }

    public function retrySign(DiiaSignService $diiaService)
    {
        $this->signStatus = 'pending';

        $this->expiresAt = now()->addMinutes(3)->timestamp;

        $this->initiateDiiaSession($diiaService);
    }

    public function render()
    {
        return view('livewire.patient.photo-consent-sign');
    }
}