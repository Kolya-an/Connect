<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class UserView extends Component
{
    public $user = [];
    public $user_id;
    public $patient;
    public $step = 1;
    public function mount(User $id)
    {
        $this->user = $id;
        $this->user_id = $id->id;
        if (Auth::id() != $this->user_id) {
            abort(403, 'Доступ запрещен');
        }
        $this->patient = $this->user->patient;

    }
    public function setStep($stepNumber)
    {
        $this->step = $stepNumber;
    }
    public function render()
    {
        return view('livewire.user-view')->layout('patient.view');
    }
}
