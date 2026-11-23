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

    public $passportFile;    // Тимчасовий файл паспорта
    public $passportPhoto;   // Шлях до збереженого фото з бази даних

    public function mount()
    {
        $this->passportPhoto = Auth::user()->doctor?->passport ?? null;
    }

    public function updatedPassportFile()
    {
        $this->validate(
            [
                'passportFile' => 'file|mimes:jpg,jpeg,png,webp|max:4096',
            ],
            [
                'passportFile.file'  => __('Некоректний файл.'),
                'passportFile.mimes' => __('Дозволені формати: JPG, JPEG, PNG, WEBP, PDF.'),
                'passportFile.max'   => __('Максимальний розмір файлу — 4 МБ.'),
            ]
        );

        $this->savePassport();
        $this->reset('passportFile');
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

        // Оновлюємо колонку 'passport'
        $doctor->update(['passport' => $path]);

        $this->passportPhoto = $path;
        $this->passportFile = null;

        session()->flash('message', 'Селфі з документом успішно оновлено!');
    }

    // Новий метод для видалення фото
    public function deletePassport()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor || !$doctor->passport) {
            return;
        }

        // Видаляємо файл з диска
        if (Storage::disk('public_uploads')->exists($doctor->passport)) {
            Storage::disk('public_uploads')->delete($doctor->passport);
        }

        // Очищаємо поле у базі даних
        $doctor->update(['passport' => null]);

        // Скидаємо стан у компоненті
        $this->passportPhoto = null;
        $this->passportFile = null;

        session()->flash('message', 'Фото успішно видалено!');
    }

    public function render()
    {
        return view('livewire.doctor.passport');
    }
}