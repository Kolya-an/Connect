<?php

namespace App\Filament\Resources\Pacients\Pages;

use App\Filament\Resources\Pacients\PacientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPacient extends EditRecord
{
    protected static string $resource = PacientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['user']) && $this->record->user) {
            $userData = [];

            if (isset($data['user']['name'])) {
                $userData['name'] = $data['user']['name'];
            }

            if (isset($data['user']['email'])) {
                $userData['email'] = $data['user']['email'];
            }

            // Добавьте другие поля по необходимости

            if (!empty($userData)) {
                $this->record->user->update($userData);
            }
        }

        unset($data['user']);
        return $data;
    }
}
