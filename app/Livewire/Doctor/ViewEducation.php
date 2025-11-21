<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\DoctorPhoto;
use App\Models\Education;
use App\Models\Extra;
use Livewire\Component;

class ViewEducation extends Component
{
    public $doctor;
    public $educations;
    public $extras =[];
    public $description;
    public $education_images =[];
    public $extra_images =[];
    public $photoId;

    public function mount($id)
    {
        $this->photoId = $id;
        $this->doctor = Doctor::findOrFail($id);
        $this->educations = Education::where('doctor_id', $id)->get();
        $this->extras = Extra::where('doctor_id', $id)->get();
        $images = $this->doctor->education_images;
        $this->education_images = is_array($images) ? $images : [];
        $extras_images = $this->doctor->extra_images;
        $this->extra_images = is_array($extras_images) ? $extras_images : [];
    }

    public function render()
    {
        $photos = DoctorPhoto::where('doctor_id', $this->photoId)
            ->orderByDesc('created_at')
            ->paginate(2);
        return view('livewire.doctor.view-education', [
            'photos' => $photos,
        ]);
    }
}
