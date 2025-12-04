<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use App\Jobs\SendNewsMailings; // Импорт Job для рассылки
use App\Models\News; // Импорт модели News
use Filament\Resources\Pages\CreateRecord;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;
    protected static ?string $title = 'Додати новину';

    /**
     * Вызывается после успешного создания записи.
     * Запускает асинхронную рассылку в зависимости от категории.
     */
    protected function afterCreate(): void
    {
        // Получаем только что созданную запись
        /** @var News $newsRecord */
        $newsRecord = $this->getRecord();

        // Проверяем, нужна ли рассылка для данной категории
        // category_id = 2: Новини (Рассылка всем)
        // category_id = 4: Для лікарів (Рассылка только patient)
        $categoriesWithMailing = [2, 4];

        if (in_array($newsRecord->category_id, $categoriesWithMailing)) {
            // Диспетчеризация Job для асинхронного выполнения.
            // Это предотвращает задержки в UI Filament.
            SendNewsMailings::dispatch($newsRecord);
        }
    }
}
