<?php

namespace App\Livewire\Patient;

use App\Models\PhotoConsent;
use App\Services\DiiaSignService;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PhotoConsentSign extends Component
{
    public string $token;
    public ?PhotoConsent $consent = null;

    public ?string $qrCodeUrl = null;
    public ?string $deepLink = null;
    public string $signStatus = 'pending';

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

        // Формуємо сесію та QR-код одразу при завантаженні сторінки
        $this->initiateDiiaSession($diiaService);
    }

    private function initiateDiiaSession(DiiaSignService $diiaService)
    {
        try {
            // Формуємо SHA-256 хеш документа
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

            $this->qrCodeUrl = $sessionData['qrCodeUrl'] ?? null;
            $this->deepLink  = $sessionData['deepLink'] ?? null;

        } catch (\Throwable $e) {
            logger()->error('Diia Session Creation Error: ' . $e->getMessage());
        }
    }

    public function checkDiiaStatus()
    {
        if ($this->signStatus === 'signed') {
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

    private function generatePdfDocument()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.photo-consent', [
            'consent' => $this->consent,
        ]);

        $filename = 'consents/consent_' . $this->consent->id . '_' . time() . '.pdf';
        Storage::disk('public_uploads')->put($filename, $pdf->output());

        $this->consent->update([
            'pdf_path' => $filename,
        ]);
    }

    #[Layout('layouts.base')]
    public function render()
    {
        return view('livewire.patient.photo-consent-sign');
    }
}