<?php

namespace App\Livewire\Doctor;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use App\Models\Appointment;
use Livewire\WithPagination;

class MyAppointments extends Component
{
    use WithPagination;

    public $doctorId;
    public $modalVisible = false;
    public $selectedAppointmentId;
    public $cancelReason = '';
    public $selectedReason = '';

    public $service;
    public $services = [];
    public $selectedServiceId;
    public $searchPatient = '';
    public $patients = [];
    public $showSuggestions = false;
    public $selectedPatientId = null;
    public $selectedPatientName = '';


    public function mount($doctorId)
    {
        //dd ($doctorId);
        $this->doctorId = $doctorId;
    }


    public function updatedSearchPatient($value)
    {
        // Сбрасываем выбранного пациента при изменении текста
        $this->selectedPatientId = null;

        if (strlen($value) >= 2) {
            $this->patients = User::where('role', 'patient')
                ->with('patient')
                ->where(function($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->orWhereHas('patient', function($q) use ($value) {
                            $q->where('second_name', 'like', '%' . $value . '%')
                                ->orWhere('phone', 'like', '%' . $value . '%');
                        });
                })
                ->limit(10)
                ->get();

            // ПРОСТО И ПОНЯТНО - если есть результаты, показываем
            $this->showSuggestions = count($this->patients) > 0;

        } else {
            $this->patients = [];
            $this->showSuggestions = false;
        }
    }

    // Выбор пациента из списка
    public function selectPatient($patientId, $patientName, $patientSecondName = '')
    {
        $fullName = trim($patientName . ' ' . $patientSecondName);
        $this->selectedPatientId = $patientId;
        $this->searchPatient = $fullName;
        $this->showSuggestions = false;
        $this->patients = [];

        // Автоматически выполняем поиск записей при выборе пациента
        $this->performSearch();
    }

    // Поиск записей
    public function performSearch()
    {
        $this->resetPage();
        $this->showSuggestions = false;
    }

    // Очистка поиска
    public function clearSearch()
    {
        $this->searchPatient = '';
        $this->selectedPatientId = null;
        $this->patients = [];
        $this->showSuggestions = false;
        $this->resetPage();
    }

    // Обработка фокуса
    public function onFocus()
    {
        if ($this->searchPatient && strlen($this->searchPatient) >= 2) {
            $this->performSearchOnFocus();
        }
    }
    public function performSearchOnFocus()
    {
        $this->patients = User::where('role', 'patient')
            ->with('patient')
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->searchPatient . '%')
                    ->orWhere('email', 'like', '%' . $this->searchPatient . '%')
                    ->orWhereHas('patient', function($q) {
                        $q->where('second_name', 'like', '%' . $this->searchPatient . '%')
                            ->orWhere('phone', 'like', '%' . $this->searchPatient . '%');
                    });
            })
            ->limit(10)
            ->get();

        // Показываем подсказки если есть результаты
        $this->showSuggestions = $this->patients->count() > 0;
    }

    // Обработка потери фокуса
    public function onBlur()
    {
        // Задержка для обработки клика по подсказке
        usleep(200000);
        $this->showSuggestions = false;
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
        if (empty($this->cancelReason)) {
            session()->flash('error', 'Будь ласка, оберіть причину скасування');
            return;
        }

        $appointment = Appointment::where('id', $this->selectedAppointmentId)
            ->where('doctor_id', $this->doctorId)
            ->first();

        if (!$appointment) {
            session()->flash('error', 'Запис не знайдено');
            return;
        }

        $appointment->update([
            'status' => 'canceled',
            'cause' => $this->cancelReason
        ]);

        Message::create([
            'doctor_id'      => $appointment->doctor_id,
            'user_id'        => $appointment->user_id,
            'appointment_id' => $appointment->id,
            'status'         => 'canceled',
        ]);
        //session()->flash('success', 'Візит успішно скасовано');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->modalVisible = false;
        $this->selectedAppointmentId = null;
        $this->cancelReason = '';
        $this->selectedReason = '';
        session()->forget(['success', 'error']);
    }
    public function bookingAppointment($id)
    {
        $appointment = Appointment::where('id', $id)
           // ->where('doctor_id', $this->doctorId)
            ->first();

        $appointment->update([
            'status' => 'confirmed',
        ]);
        Message::create([
            'doctor_id'      => $appointment->doctor_id,
            'user_id'        => $appointment->user_id,
            'appointment_id' => $appointment->id,
            'status'         => 'confirmed',
        ]);
    }


    public function render()
    {
        $query = Appointment::where('doctor_id', $this->doctorId)
            ->whereIn('status', ['booking', 'confirmed'])
            ->with(['doctor.user', 'user', 'service:id,name']);

        // Фильтрация по выбранному пациенту
        if ($this->selectedPatientId) {
            $query->where('user_id', $this->selectedPatientId);
        }

        $appointments = $query->orderBy('date')
            ->orderBy('hour')
            ->paginate(5);

        return view('livewire.doctor.my-appointments', compact('appointments'));
    }
}
