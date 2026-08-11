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
    public $agreeModalVisible = false;
    public $patient_history_agree;


    public function mount(User $id)
    {
        $this->user = $id;
        $this->user_id = $id->id;
        if (Auth::id() != $this->user_id) {
            abort(403, 'Доступ запрещен');
        }
        $this->patient = $this->user->patient;
        $this->patient_history_agree = $this->user->patient->patient_history_agree;
    }
    public function setStep($stepNumber)
    {
        if ($stepNumber=== 2 && empty($this->patient_history_agree)) {
            $this->agreeModalVisible = true; // Відкриваємо модалку згоди
            return; // Перериваємо перехід
        }
        $this->step = $stepNumber;
    }
    public function agreePatientHistory()
    {
        $user = Auth::user();

        if ($user->patient) {
            $user->patient->update([
                'patient_history_agree' => now(),
            ]);
        } 

        $this->patient_history_agree = now();
        $this->agreeModalVisible = false;

        // Автоматично відкриваємо "Історію візитів" після підтвердження
        $this->step = 2;

        session()->flash('message', 'Згоду на обробку даних успішно надано!');
    }

    public function closeAgreeModal()
    {
        $this->agreeModalVisible = false;
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
