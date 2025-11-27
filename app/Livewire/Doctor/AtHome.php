<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AtHome extends Component
{
    public $user;
    public $doctor;
    public $at_home = false;
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();

        if ($user->doctor) {

            $this->at_home = $user->doctor->at_home;
        }
    }
    public function updatedAtHome($value)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if ($doctor) {
            $doctor->update([
                'at_home' => $value
            ]);
        }
    }
    public function render()
    {
        return view('livewire.doctor.at-home');
    }
}
