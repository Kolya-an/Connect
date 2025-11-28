<?php

namespace App\Livewire\Patient;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use App\Models\Appointment;
use Livewire\WithPagination;

class Messages extends Component
{
    use WithPagination;

    public $user = [];
    public $user_id;
    public $patient;
    public $appointment_id;
    public function mount(User $id)
    {
        $this->user = $id;
        $this->user_id = $id->id;
        if (Auth::id() != $this->user_id) {
            abort(403, 'Доступ запрещен');
        }
        $this->patient = $this->user->patient;


    }
    public function render()
    {
        $messages = Message::where('user_id', $this->user_id)
           // ->where('status', ['canceled', 'completed'])
            ->with(['doctor.user'])
            ->orderBy('created_at')
            ->paginate(5);
        return view('livewire.patient.messages', [
            'messages' => $messages
        ]);
    }
}
