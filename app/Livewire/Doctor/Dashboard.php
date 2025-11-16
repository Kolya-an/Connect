<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;


class Dashboard extends Component
{
    public $step = 1;
    public $doctorId;

    // Общие данные
    public $phone;

    public function mount()
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();
        if ($doctor) {
            $this->doctorId = $doctor->id;
            $this->phone = $doctor->phone;
        }
    }

    public function saveStep($data)
    {
        // Обновляем свойства родителя
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        $doctor = Doctor::updateOrCreate(
            //['id' => $this->doctorId],
            [
                'user_id' => Auth::id(),
                //'phone' => $this->phone,
            ]
        );

        $this->doctorId = $doctor->id;
    }

    public function setStep($stepNumber)
    {
        $this->step = $stepNumber;
        if ($this->step === 3) {
            $this->dispatch('reinit-swipers');
        }
    }


    public function render()
    {

        try {
            return view('livewire.doctor.dashboard')
                ->layout('doctor.index');
        } catch (\Exception $e) {
            \Log::error('Livewire Doctor Dashboard Error: ' . $e->getMessage());
            return view('home.index');
        }

    }
}
