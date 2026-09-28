<?php

namespace App\Filament\Resources\PhotoConsents\Pages;

use App\Filament\Resources\PhotoConsents\PhotoConsentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPhotoConsents extends ListRecords
{
    protected static string $resource = PhotoConsentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
