<?php

namespace App\Filament\Resources\Pacients\Pages;

use App\Filament\Resources\Pacients\PacientResource;
use App\Models\Pacient;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreatePacient extends CreateRecord
{
    protected static string $resource = PacientResource::class;
    protected static ?string $title = 'Додати пацієнта';
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Створюємо користувача
        $user = User::create([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'password' => Hash::make($data['user']['password']),
            'role' => 'patient',
            'active' => true,
        ]);


        $patientData = $data;
        unset($patientData['user']);
        $patientData['user_id'] = $user->id;

        return Pacient::create($patientData);
    }
}
