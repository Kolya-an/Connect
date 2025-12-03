<?php

namespace App\Livewire;

use Livewire\Component;

class LoginModal extends Component
{
    public $modal = null; // login | register | null

    public function showLogin()    { $this->modal = 'login'; }
    public function showRegister() { $this->modal = 'register'; }

    public function render()
    {
        return view('livewire.login-modal');
    }
}
