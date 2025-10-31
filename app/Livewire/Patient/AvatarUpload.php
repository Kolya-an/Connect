<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AvatarUpload extends Component
{
    use WithFileUploads;

    public $photo;       // временный файл
    public $userPhoto;   // путь к текущему фото

    public function mount()
    {
        $this->userPhoto = Auth::user()->patient?->photo ?? null;
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:4096', // максимум 4 МБ
        ]);

        $this->savePhoto();
    }

    private function savePhoto()
    {
        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) return;

        // Удаляем старое фото
        if ($patient->photo && Storage::disk('public_uploads')->exists($patient->photo)) {
            Storage::disk('public_uploads')->delete($patient->photo);
        }

        // Сохраняем новое фото
        $filename = Str::uuid() . '.' . $this->photo->getClientOriginalExtension();
        $path = $this->photo->storeAs('', $filename, 'public_uploads');

        // Обновляем поле в базе
        $patient->update(['photo' => $path]);

        $this->userPhoto = $path;
        $this->photo = null;

        session()->flash('message', 'Фото успішно оновлено!');
    }

    public function render()
    {
        return view('livewire.patient.avatar-upload');
    }
}
