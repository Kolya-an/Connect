<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\User;

class PatientList extends Component
{
    public $patients;
    public $search = '';

    protected $queryString = ['search'];

    public function mount()
    {
        $this->loadPatients();
    }

    public function loadPatients()
    {
        $query = User::where('role', 'patient');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $this->patients = $query->get();
    }

    public function updatedSearch()
    {
        $this->loadPatients();
    }

    public function render()
    {
        return view('livewire.doctor.patient-list')
            ->layout('layouts.doctor');
    }
}
