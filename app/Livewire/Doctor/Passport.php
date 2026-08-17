<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Passport extends Component
{
    use WithFileUploads;

    public $passportFile;    // Тимчасовий файл паспорта (окремо від основного $photo)
    public $passportPhoto;   // Шлях до збереженого фото з бази даних

    public function mount()
    {
        $this->passportPhoto = Auth::user()->doctor?->passport ?? null;
    }

    // Хук, який спрацьовує при виборі файлу в $passportFile
    public function updatedPassportFile()
    {
        $this->validate([
            'passportFile' => 'image|max:4096', // максимум 4 МБ
        ]);

        $this->savePassport();
    }

    private function savePassport()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor || !$this->passportFile) return;

        // Видаляємо старе фото паспорта з диска
        if ($doctor->passport && Storage::disk('public_uploads')->exists($doctor->passport)) {
            Storage::disk('public_uploads')->delete($doctor->passport);
        }

        // Зберігаємо нове фото
        $filename = Str::uuid() . '.' . $this->passportFile->getClientOriginalExtension();
        $path = $this->passportFile->storeAs('', $filename, 'public_uploads');

        // Оновлюємо саме колонку 'passport' у таблиці doctors
        $doctor->update(['passport' => $path]);

        $this->passportPhoto = $path;
        $this->passportFile = null;

        session()->flash('message', 'Селфі з документом успішно оновлено!');
    }

    public function render()
    {
        return view('livewire.doctor.passport');
    }
}