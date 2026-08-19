<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;


class Dashboard extends Component
{
    public $step = 1;
    public $doctorId;
    public $agreeModalVisible = false;
    public $doctor_history_agree;
    public $modalAgree = false;
    public $doc_agree = false;
    // Общие данные
    public $phone;

    public function mount()
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();
        if ($doctor) {
            $this->doctorId = $doctor->id;
            $this->phone = $doctor->phone;
            $this->doctor_history_agree = $doctor->doctor_history_agree;
            $this->modalAgree = $doctor->agree;
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
        if ($stepNumber=== 5 && empty($this->doctor_history_agree)) {
            $this->agreeModalVisible = true; // Відкриваємо модалку згоди
            return; // Перериваємо перехід
        }
        $this->step = $stepNumber;
        if ($this->step === 3) {
            $this->dispatch('reinit-swipers');
        }
    }
    public function agreeDoctorHistory()
    {
        $user = Auth::user();

        if ($user->doctor) {
            $user->doctor->update([
                'doctor_history_agree' => now(),
            ]);
        } 

        $this->doctor_history_agree = now();
        $this->agreeModalVisible = false;

        // Автоматично відкриваємо "Історію візитів" після підтвердження
        $this->step = 5;

        session()->flash('message', 'Згоду на обробку даних успішно надано!');
    }

    public function closeAgreeModal()
    {
        $this->agreeModalVisible = false;
    }
    public function saveAgree()
    {
        $user = Auth::user();

        if ($user->doctor) {
            $user->doctor->update([
                'agree' => now(),
            ]);
        } 

        $this->modalAgree = true;

      

        session()->flash('message', 'Згоду на обробку даних успішно надано!');
    }

    public function closeAgree()
    {
        $this->modalAgree = true;
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
