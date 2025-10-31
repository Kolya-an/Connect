<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sex extends Component
{
    public $user;
    public $sex;
    public $search = '';
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();

        if ($user->doctor) {
            $this->sex = $user->doctor->sex;
        }
    }
    public function updateSex($value)
    {
        $this->sex = $value;

        $user = Auth::user();

        if ($user->doctor) {
            $user->doctor->update(['sex' => $value]);
        } else {
            $user->doctor()->create(['sex' => $value]);
        }


    }


    public function render()
    {
        return view('livewire.doctor.sex');
    }
}
