<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Services\DiiaSignService;

class CreateDiiaBranch extends Command
{
    protected $signature = 'diia:create-branch';
    protected $description = 'Створити Branch та Offer в Дії для підписання документів';

    public function handle(DiiaSignService $diiaService): int
    {
        $this->info('Отримання Access Token від Дії...');

        try {
            $token = $this->resolveAccessToken($diiaService);

            if (!$token) {
                $this->error('Не вдалося отримати Access Token. Перевірте налаштування авторизації Дії.');
                return Command::FAILURE;
            }

            $baseUrl = rtrim(config('services.diia.base_url', 'https://api2s.diia.gov.ua'), '/');
            $acquirerToken = config('services.diia.acquirer_token');

            $headers = [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ];

            if ($acquirerToken) {
                $headers['X-Document-Execution-Graph-Acquirer-Token'] = $acquirerToken;
            }

            // 1. Створення Бренчу
            $this->info('Створення нового Бренчу...');
            $branchResponse = Http::withToken($token)
                ->withHeaders($headers)
                ->post("{$baseUrl}/api/v2/acquirers/branch", [
                    'name'              => 'Connect Cosmetology',
                    'email'             => 'info@connect-cosmetology.com',
                    'phone'             => '380000000000',
                    'region'            => 'м. Київ',
                    'district'          => 'м. Київ',
                    'location'          => 'м. Київ',
                    'street'            => 'вул. Народного Ополчення',
                    'house'             => '19',
                    'customFullName'    => 'Товариство з обмеженою відповідальністю "Інститут Гіалуаль"',
                    'customFullAddress' => 'вул. Народного Ополчення, буд. 19, м. Київ, 03151',
                    'deliveryTypes'     => ['api'],
                    'offerRequestType'  => 'dynamic',
                    'scopes'            => [
                        'diiaId' => ['hashedFilesSigning']
                    ]
                ]);

            if (!$branchResponse->successful()) {
                $this->error('Помилка створення Бренчу: ' . $branchResponse->status());
                $this->line($branchResponse->body());
                return Command::FAILURE;
            }

            $branchData = $branchResponse->json();
            $branchId = $branchData['_id'] ?? $branchData['id'] ?? null;
            $this->info("✓ Бренч створено! ID: {$branchId}");

            // 2. Створення Оферу (Точний шлях з документації: /api/v1/acquirers/branch/{branch_id}/offer)
            $this->info('Створення Оферу...');
            $offerResponse = Http::withToken($token)
                ->withHeaders($headers)
                ->post("{$baseUrl}/api/v1/acquirers/branch/{$branchId}/offer", [
                    'name'       => 'Згода на використання фотоматеріалів',
                    'returnLink' => config('app.url') . '/diia-sign/callback',
                    'scopes'     => [
                        'diiaId' => [
                            'hashedFilesSigning'
                        ]
                    ]
                ]);

            if (!$offerResponse->successful()) {
                $this->error('Помилка створення Оферу: ' . $offerResponse->status());
                $this->line($offerResponse->body());
                return Command::FAILURE;
            }

            $offerData = $offerResponse->json();
            $offerId = $offerData['_id'] ?? $offerData['id'] ?? null;
            $this->info("✓ Офер створено! ID: {$offerId}");

            $this->warn("\nДодайте ці значення в свій .env файл:");
            $this->line("DIIA_BRANCH_ID=\"{$branchId}\"");
            $this->line("DIIA_OFFER_ID=\"{$offerId}\"");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Виникла помилка: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function resolveAccessToken(DiiaSignService $diiaService): ?string
    {
        $reflection = new \ReflectionClass($diiaService);
        $possibleMethods = ['getAccessToken', 'getToken', 'getAuthToken', 'authenticate', 'getSessionToken', 'token'];

        foreach ($possibleMethods as $methodName) {
            if ($reflection->hasMethod($methodName)) {
                $method = $reflection->getMethod($methodName);
                $method->setAccessible(true);
                return $method->invoke($diiaService);
            }
        }

        return config('services.diia.token') ?? env('DIIA_AUTH_TOKEN');
    }
}