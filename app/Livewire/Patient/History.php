<?php

namespace App\Livewire\Patient;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use App\Models\Appointment;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;

    public $user = [];
    public $user_id;
    public $patient;

    public $modalVisible = false;
    public $selectedUserId;
    public $selectedAppointmentId;
    public $isCanceling = false;
    public $text = '';
    public $medical = 5;
    public $service = 5;
    public $appointment_id;

    public $infoModalVisible = false;
    public $agreeModalVisible = false;
    public $selectedInfoAppointmentId;
    public $pac_his_confirmation = false;

    public function mount(User $id)
    {
        $this->user = $id;
        $this->user_id = $id->id;
        if (Auth::id() != $this->user_id) {
            abort(403, 'Доступ запрещен');
        }
        $this->patient = $this->user->patient;

    }

    public function showModal($appointmentId)
    {
        $this->selectedAppointmentId = $appointmentId;
        $this->modalVisible = true;
    }

    public function showInfoModal($appointmentId)
    {
        $this->selectedInfoAppointmentId = $appointmentId;
        $this->infoModalVisible = true;
    }
    public function agreeModalVisible()
    {
        $this->agreeModalVisible = true;
    }

    public function closeInfoModal()
    {
        $this->infoModalVisible = false;
        $this->selectedInfoAppointmentId = null;
    }



    public function cancelAppointment()
    {
        //dd($this->text);
        Review::create([
            'appointment_id' => $this->selectedAppointmentId,
            'text' => $this->text,
            'medical' => $this->medical,
            'service' => $this->service,
        ]);

        if ($this->selectedAppointmentId) {
            Appointment::where('id', $this->selectedAppointmentId)->update([
                'patient_rel' => now(),
            ]);
        }

            // Закрываем модалку
        $this->closeModal();

    }

    public function closeModal()
    {
        $this->modalVisible = false;
        $this->text = '';
        $this->medical = 5;
        $this->service = 5;
        $this->selectedAppointmentId = null;
        $this->pac_his_confirmation = false;
        $this->agreeModalVisible = false;

        // Очищаем flash сообщения при закрытии модального окна
        session()->forget(['success', 'error']);
    }
    public function setMedical($value)
    {
        $this->medical = $value;
    }

    public function setService($value)
    {
        $this->service = $value;
    }
    public function render()
    {
        $appointments = Appointment::where('user_id', $this->user_id)
            ->whereIn('status', ['canceled', 'completed'])
            ->with(['doctor.user', 'service'])
            ->orderBy('date')
            ->orderBy('hour')
            ->paginate(5); // Пагинация здесь

        return view('livewire.patient.history', [
            'appointments' => $appointments
        ]);
    }
}
