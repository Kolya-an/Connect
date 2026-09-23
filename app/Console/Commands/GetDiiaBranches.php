<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Services\DiiaSignService;

class GetDiiaBranches extends Command
{
    /**
     * Назва та синтаксис команди для термінала
     */
    protected $signature = 'diia:get-branches';

    /**
     * Опис команди
     */
    protected $description = 'Отримати список активних Branch та Offer з API Дії';

    /**
     * Виконання команди
     */
    public function handle(DiiaSignService $diiaService): int
    {
        $this->info('Отримання Access Token від Дії...');

        try {
            // Отримуємо токен через ваш сервіс за допомогою Reflection або public-методу
            $reflection = new \ReflectionClass($diiaService);
            $method = $reflection->getMethod('getAccessToken');
            $method->setAccessible(true);
            $token = $method->invoke($diiaService);

            $baseUrl = rtrim(config('services.diia.base_url'), '/');
            $acquirerToken = config('services.diia.acquirer_token');

            $this->info('Запит списку Бренчів (Branches)...');

            // 1. Отримуємо список Бренчів
            $response = Http::withToken($token)
                ->withHeaders([
                    'X-Document-Execution-Graph-Acquirer-Token' => $acquirerToken,
                    'Accept' => 'application/json',
                ])
                ->get("{$baseUrl}/api/v1/branches");

            if (!$response->successful()) {
                $this->error('Помилка при отриманні бренчів: ' . $response->status());
                $this->line($response->body());
                return Command::FAILURE;
            }

            $branches = $response->json('branches') ?? $response->json() ?? [];

            if (empty($branches)) {
                $this->warn('Жодного Branch не знайдено в обліковому записі.');
                return Command::SUCCESS;
            }

            $tableData = [];

            // 2. Для кожного Бренчу запитуємо його Офери (Offers)
            foreach ($branches as $branch) {
                $branchId = $branch['_id'] ?? $branch['id'] ?? 'Н/Д';
                $branchName = $branch['name'] ?? 'Без назви';

                $offersResponse = Http::withToken($token)
                    ->withHeaders([
                        'X-Document-Execution-Graph-Acquirer-Token' => $acquirerToken,
                        'Accept' => 'application/json',
                    ])
                    ->get("{$baseUrl}/api/v1/branches/{$branchId}/offers");

                $offers = $offersResponse->json('offers') ?? $offersResponse->json() ?? [];

                if (!empty($offers)) {
                    foreach ($offers as $offer) {
                        $tableData[] = [
                            'Branch Name' => $branchName,
                            'Branch ID'   => $branchId,
                            'Offer Name'  => $offer['name'] ?? 'Без назви',
                            'Offer ID'    => $offer['_id'] ?? $offer['id'] ?? 'Н/Д',
                        ];
                    }
                } else {
                    $tableData[] = [
                        'Branch Name' => $branchName,
                        'Branch ID'   => $branchId,
                        'Offer Name'  => '— (Оферів немає)',
                        'Offer ID'    => '—',
                    ];
                }
            }

            // Виводимо красиву таблицю в консоль
            $this->table(['Branch Name', 'Branch ID', 'Offer Name', 'Offer ID'], $tableData);

            $this->info('Скопіюйте потрібні ID та додайте їх у ваш .env файл:');
            $this->line('DIIA_BRANCH_ID="<вибраний_branch_id>"');
            $this->line('DIIA_OFFER_ID="<вибраний_offer_id>"');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Виникла помилка: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}