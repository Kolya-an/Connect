<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DiiaSignService
{
    protected string $baseUrl;
    protected string $appKey;

    public function __construct()
    {
        $this->baseUrl = config('services.diia.base_url', 'https://api2.diia.gov.ua');
        $this->appKey = config('services.diia.app_key', '');
    }

    /**
     * Запит на створення сесії підпису та отримання посилання для QR-коду
     */
    public function createSignSession(array $payload): array
    {
        // Приклад обробки масиву або виклику API Дії
        // $response = Http::withToken($this->getAccessToken())...

        return [
            'qrCodeUrl' => '...',
            'deepLink'  => '...',
        ];
    }

    /**
     * Отримання результату підпису за sessionId
     */
    public function getSignatureResult(string $sessionId): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->appKey,
        ])->get("{$this->baseUrl}/api/v1/auth/sign/result/{$sessionId}");

        return $response->json();
    }
}