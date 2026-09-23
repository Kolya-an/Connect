<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DiiaSignService;

class TestDiiaBranches extends Command
{
    protected $signature = 'diia:test-v2';
    protected $description = 'Тестування авторизації та створення Offer за специфікацією Дії v2';

    public function handle(DiiaSignService $diiaService): int
    {
        $this->info('1. Отримання session_token...');
        try {
            $token = $diiaService->getSessionToken();
            $this->info("✓ Токен отримано: " . substr($token, 0, 15) . '...');
        } catch (\Exception $e) {
            $this->error("Помилка авторизації: " . $e->getMessage());
            return Command::FAILURE;
        }

        $this->info('2. Перевірка бранчів...');
        try {
            $branchesData = $diiaService->getBranches();
            $branches = $branchesData['branches'] ?? [];

            if (empty($branches)) {
                $this->warn('Бранчі відсутні, створюємо новий...');
                $branchId = $diiaService->createBranch();
                $this->info("✓ Бранч створено! ID: {$branchId}");
            } else {
                $branchId = $branches[0]['_id'];
                $this->info("✓ Використовуємо існуючий бранч ID: {$branchId}");
            }
        } catch (\Exception $e) {
            $this->error("Помилка бранчу: " . $e->getMessage());
            return Command::FAILURE;
        }

        $this->info("3. Створення Оферу для Бранчу {$branchId}...");
        try {
            $offerId = $diiaService->createOffer($branchId);
            $this->info("✓ Офер успішно створено! ID: {$offerId}");
            $this->warn("\nЗапишіть у .env:");
            $this->line("DIIA_BRANCH_ID=\"{$branchId}\"");
            $this->line("DIIA_OFFER_ID=\"{$offerId}\"");
        } catch (\Exception $e) {
            $this->error("Помилка створення Оферу: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}