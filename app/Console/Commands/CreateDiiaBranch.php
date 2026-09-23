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
            $reflection = new \ReflectionClass($diiaService);
            $method = $reflection->getMethod('getAccessToken');
            $method->setAccessible(true);
            $token = $method->invoke($diiaService);

            $baseUrl = rtrim(config('services.diia.base_url'), '/');
            $acquirerToken = config('services.diia.acquirer_token');

            // 1. Створення Бренчу
            $this->info('Створення нового Бренчу...');
            $branchResponse = Http::withToken($token)
                ->withHeaders(['X-Document-Execution-Graph-Acquirer-Token' => $acquirerToken])
                ->post("{$baseUrl}/api/v1/branches", [
                    'name' => 'Connect Cosmetology',
                    'email' => 'info@connect-cosmetology.com',
                    'phone' => '380000000000',
                    'location' => 'м. Київ',
                    'offerRequestType' => 'dynamic',
                ]);

            if (!$branchResponse->successful()) {
                $this->error('Помилка створення Бренчу: ' . $branchResponse->status());
                $this->line($branchResponse->body());
                return Command::FAILURE;
            }

            $branchData = $branchResponse->json();
            $branchId = $branchData['_id'] ?? $branchData['id'];
            $this->info("✓ Бренч створено! ID: {$branchId}");

            // 2. Створення Оферу для Дія.Підпис
            $this->info('Створення Оферу...');
            $offerResponse = Http::withToken($token)
                ->withHeaders(['X-Document-Execution-Graph-Acquirer-Token' => $acquirerToken])
                ->post("{$baseUrl}/api/v1/branches/{$branchId}/offers", [
                    'name' => 'Згода на використання фотоматеріалів',
                    'returnLink' => config('app.url') . '/diia-sign/callback',
                    'scopes' => [
                        'diia-id' => [
                            'hashedFiles'
                        ]
                    ]
                ]);

            if (!$offerResponse->successful()) {
                $this->error('Помилка створення Оферу: ' . $offerResponse->status());
                $this->line($offerResponse->body());
                return Command::FAILURE;
            }

            $offerData = $offerResponse->json();
            $offerId = $offerData['_id'] ?? $offerData['id'];
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
}