<?php

namespace App\Livewire;

use Livewire\Component;

class LoginModal extends Component
{
    public $showModal = false;

    protected $listeners = ['openLoginModal' => 'open'];

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
        return view('livewire.login-modal');
    }
}
