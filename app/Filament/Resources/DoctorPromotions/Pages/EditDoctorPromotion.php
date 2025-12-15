<?php

namespace App\Filament\Resources\DoctorPromotions\Pages;

use App\Filament\Resources\DoctorPromotions\DoctorPromotionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDoctorPromotion extends EditRecord
{
    protected static string $resource = DoctorPromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
