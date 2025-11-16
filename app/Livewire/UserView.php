<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use App\Models\Appointment;
use Livewire\WithPagination;

class UserView extends Component
{
    use WithPagination;

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
       /* $appointments = Appointment::where('user_id', $this->user_id)
            ->where('status', 'booking')
            ->with(['doctor.user'])
            ->orderBy('date')
            ->orderBy('hour')
            ->paginate(2); */// Пагинация здесь

        return view('livewire.user-view')->layout('patient.view');
    }
}
