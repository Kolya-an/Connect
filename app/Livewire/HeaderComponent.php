<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class HeaderComponent extends Component
{

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    /*public function role()
    {
        $role = session('social_role', 'patient');
        return $role;
    }*/

    public function render()
    {
        return view('livewire.header-component');
    }
}
