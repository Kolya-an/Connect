<?php

namespace App\Livewire\Doctor;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Description extends Component
{
    public $user;
    public $desc;
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();

        if ($user->doctor) {
            $this->desc = $user->doctor->desc;
        }
    }
    public function save()
    {
        $user = Auth::user();

        $data = [
            'desc' => $this->desc,
        ];

        if ($user->doctor) {
            $user->doctor->update($data);
        } else {
            $user->doctor()->create($data);
        }

        //session()->flash('message', 'Інформацію оновлено!');
    }

    public function render()
    {
        return view('livewire.doctor.description');
    }
}
