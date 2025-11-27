<?php

namespace App\Livewire\Doctor;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Share extends Component
{
    public $user;
    public $share;
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();

        if ($user->doctor) {
            $this->share = $user->doctor->share;
        }
    }
    public function save()
    {
        $user = Auth::user();

        $data = [
            'share' => $this->share,
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
        return view('livewire.doctor.share');
    }
}
