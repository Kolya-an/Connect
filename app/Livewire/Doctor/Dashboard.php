<?php

namespace App\Livewire\Doctor;

use Livewire\Component;


class Dashboard extends Component
{
//public $appointments;
//public $todayAppointments;

public function mount()
{
//$this->loadAppointments();
}

public function loadAppointments()
{
/*$this->appointments = Appointment::where('doctor_id', auth()->id())
->with('patient')
->orderBy('appointment_date', 'desc')
->take(5)
->get();

$this->todayAppointments = Appointment::where('doctor_id', auth()->id())
->whereDate('appointment_date', today())
->with('patient')
->get();*/
}

public function completeAppointment($appointmentId)
{
/*$appointment = Appointment::find($appointmentId);
$appointment->update(['status' => 'completed']);

$this->loadAppointments();
$this->dispatchBrowserEvent('appointment-completed');*/
}

public function render()
{
return view('livewire.doctor.dashboard')
->layout('doctor.index');
}
}
