<?php

namespace App\Livewire\Patient;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use App\Models\Appointment;
use Livewire\WithPagination;

class Reception extends Component
{
    use WithPagination;

    public $user = [];
    public $user_id;
    public $patient;

    public $modalVisible = false;

    public $selectedAppointmentId;
    public $cancelReason = '';
    public $selectedReason = '';
    public $isCanceling = false;
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
        $this->cancelReason = '';
        $this->selectedReason = '';
    }

    public function setReason($reason)
    {
        $this->selectedReason = $reason;
        $this->cancelReason = $reason;
    }

    public function cancelAppointment()
    {


        // Валидация
        if (empty($this->cancelReason)) {
            session()->flash('error', 'Будь ласка, оберіть причину скасування');
            return;
        }

        if (empty($this->selectedAppointmentId)) {
            session()->flash('error', 'ID запису не знайдено');
            return;
        }

        try {
            // Находим запись
            $appointment = Appointment::where('id', $this->selectedAppointmentId)
                ->where('user_id', $this->user_id)
                ->first();

            if (!$appointment) {
                session()->flash('error', 'Запис не знайдено');
                return;
            }



            // Обновляем запись
            $appointment->update([
                'status' => 'canceled',
                'cause' => $this->cancelReason
            ]);

            session()->flash('success', 'Візит успішно скасовано');

            // Закрываем модальное окно
            $this->closeModal();

        } catch (\Exception $e) {

        }
    }

    public function closeModal()
    {
        $this->modalVisible = false;
        $this->selectedAppointmentId = null;
        $this->cancelReason = '';
        $this->selectedReason = '';
        $this->isCanceling = false;

        // Очищаем flash сообщения при закрытии модального окна
        session()->forget(['success', 'error']);
    }
    public function render()
    {
        $appointments = Appointment::where('user_id', $this->user_id)
            ->where('status', 'booking')
            ->with(['doctor.user'])
            ->orderBy('date')
            ->orderBy('hour')
            ->paginate(5);

        return view('livewire.patient.reception', [
            'appointments' => $appointments
        ]);
    }
}
