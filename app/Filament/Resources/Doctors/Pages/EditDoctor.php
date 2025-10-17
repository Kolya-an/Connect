<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDoctor extends EditRecord
{
    protected static string $resource = DoctorResource::class;

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
