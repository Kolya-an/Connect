<?php

namespace App\Livewire\Doctor;

use App\Models\DoctorPhoto;
use Livewire\Component;
use App\Models\Doctor;
use Livewire\WithPagination;

class ViewPhoto extends Component
{
    public $doctor;
    public $photoId;
    use WithPagination;
    public function mount($id)
    {
        $this->photoId = $id;
        $this->doctor = Doctor::findOrFail($id);
        //$this->photos = DoctorPhoto::where('doctor_id', $id)->get();
    }
    public function render()
    {
        $photos = DoctorPhoto::where('doctor_id', $this->photoId)
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        return view('livewire.doctor.view-photo', [
            'photos' => $photos,
        ]);
    }
}
