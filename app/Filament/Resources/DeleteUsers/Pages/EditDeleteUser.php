<?php

namespace App\Filament\Resources\DeleteUsers\Pages;

use App\Filament\Resources\DeleteUsers\DeleteUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeleteUser extends EditRecord
{
    protected static string $resource = DeleteUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
