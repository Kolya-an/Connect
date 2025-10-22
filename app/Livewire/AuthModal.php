<?php

namespace App\Livewire;

use Livewire\Component;

class AuthModal extends Component
{
    public $showModal = false;

    protected $listeners = ['openRegisterModal' => 'open'];

    public function open()
    {
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
    }
    public function render()
    {
        return view('livewire.auth-modal');
    }
}
