<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;

class HeaderService extends Component
{
    public $services;

    public function mount()
    {
        $this->services = Service::where('header', true)->get();
    }
    public function render()
    {
        return view('livewire.header-service');
    }
}
