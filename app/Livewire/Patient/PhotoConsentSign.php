<?php

namespace App\Livewire\Patient;

use App\Models\PhotoConsent;
use App\Services\DiiaSignService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $this->consent = PhotoConsent::with(['doctorPhoto.doctor.user', 'userSignature'])
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
            $documentHash = hash('sha256', "PhotoConsent #{$this->consent->id} Token: {$this->token}");

            $sessionData = $diiaService->createSignSession([
                'requestId' => (string) $this->consent->id,
                'hashedFiles' => [
                    [
                        'fileName' => "consent_{$this->consent->id}.pdf",
                        'fileHash' => $documentHash,
                    ]
                ],
            ]);

            $this->deepLink = $sessionData['deepLink'] ?? null;

            if (!empty($sessionData['qrCodeUrl']) && $sessionData['qrCodeUrl'] !== '...') {
                $this->qrCodeUrl = $sessionData['qrCodeUrl'];
            } elseif ($this->deepLink) {
                if (class_exists(QrCode::class)) {
                    $this->qrCodeUrl = 'data:image/svg+xml;base64,' . base64_encode(
                        QrCode::format('svg')->size(224)->margin(1)->generate($this->deepLink)
                    );
                } else {
                    $this->qrCodeUrl = 'https://quickchart.io/qr?size=224&margin=1&text=' . urlencode($this->deepLink);
                }
            }

        } catch (\Throwable $e) {
            logger()->error('Diia Session Creation Error: ' . $e->getMessage());
        }
    }

    public function checkDiiaStatus()
    {
        if ($this->signStatus !== 'pending') {
            return;
        }

        // Перевіряємо, чи не вичерпано ліміт у 3 хвилини
        if (now()->timestamp > $this->expiresAt) {
            $this->signStatus = 'expired';
            return;
        }

        $this->consent->refresh();

        if ($this->consent->status === 'signed') {
            $this->signStatus = 'signed';

            if ($this->consent->doctorPhoto) {
                $this->consent->doctorPhoto->update([
                    'is_published' => true,
                ]);
            }

            $this->generatePdfDocument();
        }
    }

    public function retrySign(DiiaSignService $diiaService)
    {
        // Перезапуск сесії за запитом користувача
        $this->signStatus = 'pending';
        $this->expiresAt = now()->addMinutes(3)->timestamp;
        $this->initiateDiiaSession($diiaService);
    }

    private function generatePdfDocument()
    {
        $photoBase64 = null;
        $photoPath = $this->consent->doctorPhoto?->path;

        if ($photoPath && Storage::disk('public')->exists($photoPath)) {
            $photoBase64 = base64_encode(Storage::disk('public')->get($photoPath));
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.photo-consent', [
            'consent' => $this->consent,
            'photoBase64' => $photoBase64,
            'signerInfo' => $this->consent->signer_info ?? [],
        ]);

        $filename = 'consents/consent_' . $this->consent->id . '_' . time() . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        $this->consent->update([
            'pdf_path' => $filename,
        ]);
    }

    public function render()
    {
        return view('livewire.patient.photo-consent-sign');
    }
}