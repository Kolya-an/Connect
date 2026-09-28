<?php

namespace App\Filament\Resources\PhotoConsents\Pages;

use App\Filament\Resources\PhotoConsents\PhotoConsentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPhotoConsent extends EditRecord
{
    protected static string $resource = PhotoConsentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
