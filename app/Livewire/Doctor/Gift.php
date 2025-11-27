<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Gift extends Component
{
    public $user;
    public $doctor;
    public $gift = false;
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();

        if ($user->doctor) {

            $this->gift = $user->doctor->gift;
        }
    }
    public function updatedGift($value)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if ($doctor) {
            $doctor->update([
                'gift' => $value
            ]);
        }
    }
    public function render()
    {
        return view('livewire.doctor.gift');
    }
}
