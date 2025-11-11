<?php

namespace App\Livewire;

use App\Models\About;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AboutPage extends Component
{
    public $about;

    public function mount()
    {
        $slug = 'about'; // страница по умолчанию

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->isDoctor()) {
                $slug = 'about-doctor';
            } elseif ($user->isPatient()) {
                $slug = 'about-user';
            }
        }

        // 👇 Сохраняем результат в свойство компонента
        $this->about = About::where('slug', $slug)->firstOrFail();
    }
    public function render()
    {
        return view('livewire.about-page')->layout('livewire.pages.about');
    }
}
