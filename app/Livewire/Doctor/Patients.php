<?php

namespace App\Livewire\Doctor;

use App\Models\User;
use Livewire\Component;
use App\Models\Appointment;
use App\Models\DoctorPatients;
use Livewire\WithPagination;

class Patients extends Component
{
    use WithPagination;

    public $doctorId;
    public $modalVisible = false;
    public $historyVisible = false;
    public $modalHistory = false;
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
    public $doctorPatientText = '';
    public $doctorPatientRelation = null;
    public $patientInformation = '';
    public $information = '';
    public $editingPatientId = null;

    public function mount($doctorId)
    {
        $this->doctorId = $doctorId;
    }

    public function updatedSearchPatient($value)
    {
        $this->selectedPatientId = null;

        if (strlen($value) >= 2) {
            $patientIds = Appointment::where('doctor_id', $this->doctorId)
                ->pluck('user_id')
                ->unique()
                ->toArray();

            $this->patients = User::whereIn('id', $patientIds)
                ->with('patient')
                ->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->orWhereHas('patient', function ($q) use ($value) {
                            $q->where('second_name', 'like', '%' . $value . '%')
                                ->orWhere('phone', 'like', '%' . $value . '%');
                        });
                })
                ->limit(10)
                ->get();

            $this->showSuggestions = count($this->patients) > 0;
        } else {
            $this->patients = [];
            $this->showSuggestions = false;
        }
    }

    public function selectPatient($patientId)
    {
        try {
            $this->resetPage();

            $this->selectedPatientId = (int) $patientId;

            if (empty($this->doctorId) || empty($this->selectedPatientId)) {
                $this->doctorPatientText = '';
                return;
            }

            $user = User::with('patient')->find($this->selectedPatientId);
            $this->searchPatient = $user ? trim($user->name . ' ' . ($user->patient->second_name ?? '')) : '';

             $this->doctorPatientRelation = DoctorPatients::where('doctor_id', $this->doctorId)
                 ->where('patient_id', $this->selectedPatientId)
                 ->first();

            $this->doctorPatientText = $this->doctorPatientRelation->text ?? '';

            $this->showSuggestions = false;
            $this->patients = [];

        } catch (\Throwable $e) {
            session()->flash('error', 'Произошла ошибка при выборе пациента. Смотри логи.');
        }
    }

    public function performSearch()
    {
        $this->resetPage();
        $this->showSuggestions = false;
    }

    public function clearSearch()
    {
        $this->searchPatient = '';
        $this->selectedPatientId = null;
        $this->patients = [];
        $this->showSuggestions = false;
        $this->resetPage();
        $this->doctorPatientText = '';
        $this->doctorPatientRelation = null;
    }

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

        $this->showSuggestions = $this->patients->count() > 0;
    }

    public function onBlur()
    {
        usleep(200000);
        $this->showSuggestions = false;
    }

    public function showModal($patientId)
    {
        try {
            $this->editingPatientId = $patientId;

            // Проверяем существование таблицы
            if (\Schema::hasTable('doctor_patients')) {
                $relation = DoctorPatients::where('doctor_id', $this->doctorId)
                    ->where('patient_id', $patientId)
                    ->first();

                $this->patientInformation = $relation ? ($relation->text ?? '') : '';
            } else {
                $this->patientInformation = '';
            }

            $this->modalVisible = true;
        } catch (\Exception $e) {
            $this->patientInformation = '';
            $this->modalVisible = true;
        }
    }
    public function savePatientInformation()
    {
        try {
            if ($this->editingPatientId) {
                // Обновляем или создаем запись
                DoctorPatients::updateOrCreate(
                    [
                        'doctor_id' => $this->doctorId,
                        'user_id' => $this->editingPatientId,
                    ],
                    [
                        'text' => $this->patientInformation,
                        // Добавьте другие поля если нужно
                    ]
                );

                // Обновляем текст в компоненте
                $this->doctorPatientText = $this->patientInformation;

                session()->flash('message', 'Інформацію успішно збережено.');
            }

            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Помилка при збереженні: ' . $e->getMessage());
        }
    }
    public function closeModal()
    {
        $this->modalVisible = false;
        $this->editingPatientId = null;
        $this->patientInformation = '';
    }
    public function showModalHistory($appointmentId)
    {
        $this->selectedAppointmentId = $appointmentId;
        $this->modalHistory = true;
        $this->information = '';
    }
    public function completedAppointment()
    {
       // dd($this->selectedAppointmentId);
        $this->modalHistory = true;
        $appointment = Appointment::where('id', $this->selectedAppointmentId)
            // ->where('doctor_id', $this->doctorId)
            ->first();

        $appointment->update([
            'status' => 'completed',
            'information' => $this->information
        ]);
        $this->closeModalHistory();
    }
    public function closeModalHistory()
    {
        $this->modalHistory = false;
        $this->selectedAppointmentId = null;
        $this->information = '';
    }

    public function canceledAppointment($id)
    {
        //dd($id);
        $appointment = Appointment::where('id', $id)
            // ->where('doctor_id', $this->doctorId)
            ->first();

        $appointment->update([
            'status' => 'completed',
            'information' => 'Пацієнт не прийшов',
        ]);
    }

    public function render()
    {
        // Упрощаем логику - используем один запрос для всех случаев
        $patientIds = Appointment::where('doctor_id', $this->doctorId)
            ->pluck('user_id')
            ->unique()
            ->toArray();

        $doctorPatientsQuery = User::whereIn('id', $patientIds)
            ->with('patient')
            ->orderBy('name');

        // Фильтруем только если выбран конкретный пациент
        if ($this->selectedPatientId) {
            $doctorPatientsQuery->where('id', $this->selectedPatientId);
        }

        $doctorPatients = $doctorPatientsQuery->paginate(5);

        // Записи для выбранного пациента
        $appointmentsQuery = Appointment::where('doctor_id', $this->doctorId);

        if ($this->selectedPatientId) {
            $appointmentsQuery->where('user_id', $this->selectedPatientId);
        }

        $appointments = $appointmentsQuery
            ->with(['doctor.user', 'user'])
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderBy('date')
            ->orderBy('hour')
            ->paginate(5);

        $appointmentsByPatient = $appointments->groupBy('user_id');

        return view('livewire.doctor.patients', [
            'appointments' => $appointments,
            'doctorPatients' => $doctorPatients,
            'appointmentsByPatient' => $appointmentsByPatient,
        ]);
    }
}
