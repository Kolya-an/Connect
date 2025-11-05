<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\DoctorPromotion;
use Livewire\WithPagination;

class ViewPromotions extends Component
{
    public $doctor;
    public $doctorId;

    use WithPagination;

    public function mount($id)
    {
        $this->doctorId = $id;
        $this->doctor = Doctor::findOrFail($id);
    }

    public function render()
    {
        $promotions = DoctorPromotion::where('doctor_id', $this->doctorId)
        ->orderByDesc('created_at')
        ->paginate(5);

        return view('livewire.doctor.view-promotions', [
            'promotions' => $promotions,
        ]);
    }
}
