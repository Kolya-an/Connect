<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class DoctorProfile extends Component
{
    public $user = [];
    public $doctor;
    public $step = 1;

    public function mount(User $id)
    {
        $this->user = $id;
        $this->doctor = $this->user->doctor;

    }
    public function setStep($stepNumber)
    {
        $this->step = $stepNumber;
    }
    public function render()
    {
        return view('livewire.doctor-profile')->layout('doctor.view');

    }
}
