<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Licensy extends Component
{
    use WithFileUploads;

    public $licensyFile;    // Тимчасовий файл ліцензії (окремо від основного $photo)
    public $licensyPhoto;   // Шлях до збереженого фото з бази даних

    public function mount()
    {
        $this->licensyPhoto = Auth::user()->doctor?->licensy ?? null;
    }

    // Хук, який спрацьовує при виборі файлу в $licensyFile
    public function updatedLicensyFile()
    {
        $this->validate([
            'licensyFile' => 'image|max:4096', // максимум 4 МБ
        ]);

        $this->saveLicensy();
    }

    private function saveLicensy()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor || !$this->licensyFile) return;

        // Видаляємо старе фото ліцензії з диска
        if ($doctor->licensy && Storage::disk('public_uploads')->exists($doctor->licensy)) {
            Storage::disk('public_uploads')->delete($doctor->licensy);
        }

        // Зберігаємо нове фото
        $filename = Str::uuid() . '.' . $this->licensyFile->getClientOriginalExtension();
        $path = $this->licensyFile->storeAs('', $filename, 'public_uploads');

        // Оновлюємо саме колонку 'licensy' у таблиці doctors
        $doctor->update(['licensy' => $path]);

        $this->licensyPhoto = $path;
        $this->licensyFile = null;

        session()->flash('message', 'Селфі з документом успішно оновлено!');
    }

    public function render()
    {
        return view('livewire.doctor.licensy');
    }
}