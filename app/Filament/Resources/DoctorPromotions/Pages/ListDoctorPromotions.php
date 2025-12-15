<?php

namespace App\Filament\Resources\DoctorPromotions\Pages;

use App\Filament\Resources\DoctorPromotions\DoctorPromotionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDoctorPromotions extends ListRecords
{
    protected static string $resource = DoctorPromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

}
