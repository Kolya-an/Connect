<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorResource;
use App\Models\Doctor;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateDoctor extends CreateRecord
{
    protected static string $resource = DoctorResource::class;
    protected static ?string $title = 'Додати лікаря';

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Створюємо користувача
        $user = User::create([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'password' => Hash::make($data['user']['password']),
            'role' => 'doctor',
            'active' => true,
        ]);

        // Створюємо доктора
        $doctorData = $data;
        unset($doctorData['user']);
        $doctorData['user_id'] = $user->id;

        return Doctor::create($doctorData);
    }
}
