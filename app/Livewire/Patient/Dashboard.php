<?php

namespace App\Livewire\Patient;

use Livewire\Component;
//use App\Models\Appointment;

class Dashboard extends Component
{
    public $upcomingAppointments;
    public $medicalHistory;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
       /* $this->upcomingAppointments = Appointment::where('patient_id', auth()->id())
            ->with('doctor')
            ->where('status', 'scheduled')
            ->orderBy('appointment_date')
            ->get();

        $this->medicalHistory = Appointment::where('patient_id', auth()->id())
            ->with('doctor')
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();*/
    }

    public function cancelAppointment($appointmentId)
    {
        /*$appointment = Appointment::find($appointmentId);
        $appointment->update(['status' => 'cancelled']);

        $this->loadData();
        $this->dispatchBrowserEvent('appointment-cancelled');*/
    }

    public function render()
    {
        /*return view('livewire.patient.dashboard')
            ->layout('patient.index');*/
        try {
            return view('livewire.patient.dashboard')
                ->layout('patient.index');
        } catch (\Exception $e) {
            \Log::error('Livewire Doctor Dashboard Error: ' . $e->getMessage());
            return view('home.index');
        }
    }
}
