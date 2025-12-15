<?php

namespace App\Filament\Resources\DoctorPromotions\Pages;

use App\Filament\Resources\DoctorPromotions\DoctorPromotionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDoctorPromotion extends ViewRecord
{
    protected static string $resource = DoctorPromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
