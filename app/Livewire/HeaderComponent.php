<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Pacient;

class HeaderComponent extends Component
{
    public bool $isDoctor;
    public $doctor = null;
    public $patient = null;
    public $userPhotoUrl = null;
    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            $this->isDoctor = $user->role === 'doctor';

            if ($this->isDoctor) {
                // Завантажуємо доктора. Припускаємо, що поле 'photo' містить шлях.
                $this->doctor = $user->doctor; // Припускаємо, що зв'язок вже є
                $this->userPhotoUrl = $this->doctor->photo ?? asset('image/cabimg.png');

            } else {
                // Завантажуємо пацієнта. Припускаємо, що поле 'avatar' (або інше) містить шлях.
                $this->patient = $user->patient; // Припускаємо, що зв'язок вже є
                $this->userPhotoUrl = $this->patient->photo ?? asset('image/cabimg.png');
            }
        } else {
            $this->isDoctor = false;
        }
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
