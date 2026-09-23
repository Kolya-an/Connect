<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DiiaSignService;
use Illuminate\Support\Facades\Http;

class GetDiiaOffer extends Command
{
    protected $signature = 'diia:get-offer';
    protected $description = 'Отримати або створити офер для Дії';

    public function handle(DiiaSignService $diiaService)
    {
        $branchId = config('services.diia.branch_id');
        $sessionToken = $diiaService->getSessionToken();

        // 1. Пробуємо отримати список існуючих оферів
        $response = Http::withToken($sessionToken)
            ->get("https://api2s.diia.gov.ua/api/v1/acquirers/branch/{$branchId}/offers");

        $offers = $response->json('offers', []);

        if (!empty($offers)) {
            $this->info("Знайдено існуючий Offer ID: " . $offers[0]['_id']);
            return;
        }

        // 2. Якщо немає — створюємо новий
        $createResponse = Http::withToken($sessionToken)
            ->post("https://api2s.diia.gov.ua/api/v1/acquirers/branch/{$branchId}/offer", [
                'name' => 'Підписання згоди на фото',
                'scopes' => [
                    'diiaId' => ['hashedFilesSigning']
                ]
            ]);

        if ($createResponse->successful()) {
            $this->info("Успішно створено новий Offer ID: " . $createResponse->json('_id'));
        } else {
            $this->error("Помилка створення: " . $createResponse->body());
        }
    }
}