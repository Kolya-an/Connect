<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use Livewire\WithPagination;
use Livewire\Component;

class ViewTypes extends Component
{
    public $user_id;
    public $doctor;
    use WithPagination;
    public function mount($id)
    {
        $this->user_id = $id;
        $this->doctor = Doctor::findOrFail($id);
    }
    public function render()
    {
        $services = $this->doctor
            ->services()
            ->orderBy('name') // можно по любому полю
            ->paginate(1); // 👈 количество на страницу

        return view('livewire.doctor.view-types', [
            'services' => $services,
        ]);
    }
}
