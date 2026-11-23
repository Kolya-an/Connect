<?php

namespace App\Livewire\Doctor;

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
        $this->userPhoto = Auth::user()->doctor?->photo ?? null;
    }

    public function updatedPhoto()
    {
        $this->validate(
            [
                'photo' => 'file|mimes:jpg,jpeg,png,webp|max:4096',
            ],
            [
                'photo.file'  => __('Некоректний файл.'),
                'photo.mimes' => __('Дозволені формати: JPG, JPEG, PNG, WEBP.'),
                'photo.max'   => __('Максимальний розмір файлу — 4 МБ.'),
            ]
        );

        $this->savePhoto();
        $this->reset('photo');
    }

    private function savePhoto()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor) return;

        // Удаляем старое фото
        if ($doctor->photo && Storage::disk('public_uploads')->exists($doctor->photo)) {
            Storage::disk('public_uploads')->delete($doctor->photo);
        }

        // Сохраняем новое фото
        $filename = Str::uuid() . '.' . $this->photo->getClientOriginalExtension();
        $path = $this->photo->storeAs('', $filename, 'public_uploads');

        // Обновляем поле в базе
        $doctor->update(['photo' => $path]);

        $this->userPhoto = $path;
        $this->photo = null;

        session()->flash('message', 'Фото успішно оновлено!');
    }
    public function render()
    {
        return view('livewire.doctor.avatar-upload');
    }
}
