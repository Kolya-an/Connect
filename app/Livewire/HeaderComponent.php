<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class HeaderComponent extends Component
{
    public bool $isDoctor;
    public function mount()
    {
        $this->isDoctor = Auth::check() && Auth::user()->role === 'doctor';
    }
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }



    public function render()
    {
        return view('livewire.header-component');
    }
}
