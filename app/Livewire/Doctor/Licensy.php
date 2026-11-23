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
                'licensyFile' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
            ],
            [
                'licensyFile.file'  => __('Некоректний файл.'),
                'licensyFile.mimes' => __('Дозволені формати: JPG, JPEG, PNG, WEBP, PDF.'),
                'licensyFile.max'   => __('Максимальний розмір файлу — 4 МБ.'),
            ]);

        $this->saveLicensy();
        $this->reset('licensyFile');
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

    // Новий метод для видалення фото
    public function deleteLicensy()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor || !$doctor->licensy) {
            return;
        }

        // Видаляємо файл з диска
        if (Storage::disk('public_uploads')->exists($doctor->licensy)) {
            Storage::disk('public_uploads')->delete($doctor->licensy);
        }

        // Очищаємо поле у базі даних
        $doctor->update(['licensy' => null]);

        // Скидаємо стан у компоненті
        $this->licensyPhoto = null;
        $this->licensyFile = null;

        session()->flash('message', 'Фото успішно видалено!');
    }

    public function render()
    {
        return view('livewire.doctor.licensy');
    }
}