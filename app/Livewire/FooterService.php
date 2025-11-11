<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;

class FooterService extends Component
{
    public $services;

    public function mount()
    {
        $this->services = Service::where('footer', true)->get();
    }
    public function render()
    {
        return view('livewire.footer-service');
    }
}
