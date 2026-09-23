<?php

namespace App\Console\Commands;

use App\Services\DiiaSignService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateDiiaOffer extends Command
{
    /**
     * Назва та сигнатура консольної команди.
     */
    protected $signature = 'diia:create-offer 
                            {--name= : Назва оферу} 
                            {--branch= : ID філії (за замовчуванням береться з DIIA_BRANCH_ID)}';

    /**
     * Опис консольної команди.
     */
    protected $description = 'Створює новий Offer у Дії та записує DIIA_OFFER_ID у файл .env';

    /**
     * Виконати консольну команду.
     */
    public function handle(DiiaSignService $diiaService): int
    {
        $branchId = $this->option('branch') ?: config('services.diia.branch_id');

        if (empty($branchId)) {
            $this->error('❌ Branch ID відсутній! Переконайтеся, що DIIA_BRANCH_ID прописано в .env або передайте параметр --branch=ID');
            return Command::FAILURE;
        }

        $name = $this->option('name') ?: 'Згода на обробку та використання фотоматеріалів';

        $this->info("⏳ Створення Offer \"{$name}\" для Branch ID: {$branchId}...");

        try {
            // Створення оферу через сервіс
            $offerId = $diiaService->createOffer($branchId, [
                'name' => $name,
            ]);

            $this->info("✅ Offer успішно створено!");
            $this->line("🔑 Offer ID: <comment>{$offerId}</comment>");

            // Запис у .env файл
            $this->updateEnvFile('DIIA_OFFER_ID', $offerId);

            $this->info('📝 Значення DIIA_OFFER_ID успішно збережено у .env файл.');

            // Очищення кешу конфігурації
            $this->call('config:clear');

            return Command::SUCCESS;

        } catch (\Throwable $e) {
            $this->error("❌ Помилка створення Offer: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Оновлення або додавання змінної у файл .env
     */
    protected function updateEnvFile(string $key, string $value): void
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            return;
        }

        $envContent = File::get($envPath);

        if (preg_match("/^{$key}=.*/m", $envContent)) {
            // Заміна існуючого значення
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        } else {
            // Додавання нового значення в кінець файлу
            $envContent .= "\n{$key}={$value}\n";
        }

        File::put($envPath, $envContent);
    }
}