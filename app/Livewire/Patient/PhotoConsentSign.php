<?php

namespace App\Livewire\Patient;

use App\Models\PhotoConsent;
use Livewire\Component;
use Livewire\Attributes\Layout;

class PhotoConsentSign extends Component
{
    public string $token;
    public ?PhotoConsent $consent = null;

    public function mount(string $token)
    {
        $this->token = $token;
        
        // Шукаємо згоду за токеном разом з фото та лікарем
        $this->consent = PhotoConsent::with(['photo.doctor.user'])
            ->where('token', $token)
            ->firstOrFail();
    }

    public function handleSignatureSuccess(array $signatureData)
    {
        // 1. Оновлюємо статус згоди
        $this->consent->update([
            'status' => 'signed',
            'signed_at' => now(),
            'signer_info' => [
                'name' => $signatureData['signer_name'] ?? 'Пацієнт',
                'drfo' => $signatureData['signer_drfo'] ?? null,
                'hash' => $signatureData['hash'] ?? null,
            ],
        ]);

        // 2. АКТИВУЄМО ФОТО на сайті!
        $this->consent->photo->update([
            'is_published' => true,
        ]);

        // 3. (Опціонально) Зберігаємо сформований PDF-документ згоду у storage
        $this->generatePdfDocument();
    }


    public function render()
    {
        return view('livewire.patient.photo-consent-sign')
            ->layout('layouts.base');
    }
}
