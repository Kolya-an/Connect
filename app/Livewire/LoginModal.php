<?php

namespace App\Livewire;

use Livewire\Component;

class LoginModal extends Component
{
    public $modal = null; // login | register | null

    protected $listeners = [
        'openLoginModal' => 'showLogin',
        'openRegisterModal' => 'showRegister',
    ];

    public function showLogin()    { $this->modal = 'login'; }
    public function showRegister() { $this->modal = 'register'; }

    public function render()
    {
        return view('livewire.login-modal');
    }
}
