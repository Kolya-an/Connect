<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiiaService
{
    protected string $baseUrl;
    protected string $acquirerToken;
    protected string $authAcquirerToken;

    public function __construct()
    {
        $this->baseUrl           = config('services.diia.base_url');
        $this->acquirerToken     = config('services.diia.acquirer_token');
        $this->authAcquirerToken = config('services.diia.auth_acquirer_token');
    }

    /**
     * 1. Отримання сесійного токена (Session Token)
     */
    public function getSessionToken(): ?string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->authAcquirerToken,
        ])->get("{$this->baseUrl}/api/v1/auth/acquirer");

        if ($response->failed()) {
            Log::error('Diia Auth Error: ' . $response->body());
            return null;
        }

        return $response->json('token');
    }

    /**
     * 2. Генерація DeepLink / QR-коду для підписання хекс-хешу або документа
     */
    public function createSignatureSession(string $requestId, array $hashedFiles): ?array
    {
        $sessionToken = $this->getSessionToken();

        if (!$sessionToken) {
            return null;
        }

        $response = Http::withHeaders([
            'Authorization'                              => "Bearer {$sessionToken}",
            'X-Document-Execution-Graph-Acquirer-Token' => $this->acquirerToken,
        ])->post("{$this->baseUrl}/api/v2/acquisition/deep-link", [
            'requestId' => $requestId,
            'hashedFiles' => $hashedFiles,
        ]);

        if ($response->failed()) {
            Log::error('Diia Create DeepLink Error: ' . $response->body());
            return null;
        }

        return $response->json(); // Повертає ['deepLink' => '...', 'requestId' => '...']
    }

    /**
     * 3. Перевірка статусу підписання та отримання декодованого підпису
     */
    public function getSignatureStatus(string $requestId): ?array
    {
        $sessionToken = $this->getSessionToken();

        if (!$sessionToken) {
            return null;
        }

        $response = Http::withHeaders([
            'Authorization'                              => "Bearer {$sessionToken}",
            'X-Document-Execution-Graph-Acquirer-Token' => $this->acquirerToken,
        ])->get("{$this->baseUrl}/api/v2/acquisition/status/{$requestId}");

        return $response->json();
    }
}