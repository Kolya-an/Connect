<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class DoctorProfile extends Component
{
    public $doctor;

    public function mount($id)
    {
        // Загружаем доктора с информацией из связанной таблицы
        $this->doctor = User::with('doctor') // предполагается связь user->doctor
        ->where('id', $id)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.doctor-profile');
    }
}
