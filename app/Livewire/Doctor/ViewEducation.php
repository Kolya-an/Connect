<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
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

    public function mount($id)
    {
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
        return view('livewire.doctor.view-education');
    }
}
