<?php

namespace App\Livewire\Doctor;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Type extends Component
{
    public $user;
    public $types = [];
    public $newType = '';
    public function mount()
    {
        $this->user = Auth::user();

        if ($this->user->doctor) {
            $this->types = $this->user->doctor->services ?? [];
        }
    }
    public function addType()
    {
        $type = trim($this->newType);

        if ($type === '' || in_array($type, $this->types, true)) {
            $this->newType = '';
            return;
        }

        // добавляем в массив
        $this->types[] = $type;

        $this->updateDoctorServices();

        // очищаем поле
        $this->newType = '';
    }

    public function deleteType($index)
    {
        unset($this->types[$index]);
        $this->types = array_values($this->types); // переиндексация

        $this->updateDoctorServices();
    }

    protected function updateDoctorServices()
    {
        if ($this->user && $this->user->doctor) {
            $this->user->doctor->update([
                'services' => $this->types,
            ]);
        }
    }
    public function render()
    {
        return view('livewire.doctor.type');
    }
}
