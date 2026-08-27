<?php

namespace App\Filament\Resources\DeleteUsers\Pages;

use App\Filament\Resources\DeleteUsers\DeleteUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeleteUsers extends ListRecords
{
    protected static string $resource = DeleteUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
