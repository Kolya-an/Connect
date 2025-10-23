<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\User;
//use App\Models\Appointment;

class BookAppointment extends Component
{
    public $doctors;
    public $selectedDoctor;
    public $appointmentDate;
    public $symptoms;
    public $availableSlots = [];

    public function mount()
    {
        $this->doctors = User::where('role', 'doctor')->get();
        $this->generateAvailableSlots();
    }

    public function generateAvailableSlots()
    {
        // Генерация доступных временных слотов
        $slots = [];
        $startTime = strtotime('09:00');
        $endTime = strtotime('17:00');

        for ($time = $startTime; $time <= $endTime; $time += 1800) { // 30 минут
            $slots[] = date('H:i', $time);
        }

        $this->availableSlots = $slots;
    }

    public function bookAppointment()
    {
        $this->validate([
            'selectedDoctor' => 'required|exists:users,id',
            'appointmentDate' => 'required|date|after:today',
            'symptoms' => 'required|min:10'
        ]);

        /*Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $this->selectedDoctor,
            'appointment_date' => $this->appointmentDate,
            'symptoms' => $this->symptoms,
            'status' => 'scheduled'
        ]);*/

        $this->reset(['selectedDoctor', 'appointmentDate', 'symptoms']);
        session()->flash('message', 'Appointment booked successfully!');
    }

    public function render()
    {
        return view('livewire.patient.book-appointment')
            ->layout('layouts.patient');
    }
}
