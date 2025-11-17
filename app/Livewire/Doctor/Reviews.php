<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class Reviews extends Component
{
    public $doctor;
    public $doctorId;

    use WithPagination;

    public function mount($id)
    {
        $this->doctorId = $id;
        $this->doctor = Doctor::findOrFail($id);
    }

    public function getReviewsProperty()
    {
        return Review::with([
            'appointment.user',
            'appointment.user.patient',
        ])
            ->whereHas('appointment', function ($q) {
                $q->where('doctor_id', $this->doctorId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
    public function getMedicalAvgProperty()
    {
        return Review::whereHas('appointment', function ($q) {
            $q->where('doctor_id', $this->doctorId);
        })
            ->avg('medical');
    }
    public function getServiceAvgProperty()
    {
        return Review::whereHas('appointment', function ($q) {
            $q->where('doctor_id', $this->doctorId);
        })
            ->avg('service');
    }
    public function render()
    {
        return view('livewire.doctor.reviews', [
            'reviews' => $this->reviews,
            'medicalAvg' => $this->medicalAvg,
            'serviceAvg' => $this->serviceAvg,
        ]);
    }
}
