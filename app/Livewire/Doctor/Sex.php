<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sex extends Component
{
    public $user;
    public $sex;
    public $name;
    public $second_name;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'second_name' => 'nullable|string|max:255',
    ];
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();
        $this->name = $user->name;
        if ($user->doctor) {
            $this->sex = $user->doctor->sex;
            $this->second_name = $user->doctor->second_name;
        } else {
            $this->second_name = '';
        }
    }
    public function updatedName($value)
    {
        // Валідація лише для поля 'name'
        $this->validateOnly('name');

        // Оновлення name в таблиці users
        $this->user->update(['name' => $value]);

        // Опціонально: вивести повідомлення про успіх
        //session()->flash('name_message', 'Ім\'я оновлено успішно.');
    }

    // Метод оновлення для second_name (викликається після зміни поля)
    public function updatedSecondName($value)
    {
        // Валідація лише для поля 'second_name'
        $this->validateOnly('second_name');

        $user = $this->user; // Використовуємо властивість $this->user

        if ($user->doctor) {
            // Оновлення second_name в таблиці doctors
            $user->doctor->update(['second_name' => $value]);
        } else {
            // Створення запису doctor та встановлення second_name
            $user->doctor()->create(['second_name' => $value, 'sex' => $this->sex ?? 'male']); // Встановлюємо sex за замовчуванням, якщо він ще не обраний
        }

        // Опціонально: вивести повідомлення про успіх
        //session()->flash('second_name_message', 'Прізвище оновлено успішно.');
    }
    public function updateSex($value)
    {
        $this->sex = $value;

        $user = Auth::user();

        if ($user->doctor) {
            $user->doctor->update(['sex' => $value]);
        } else {
            $user->doctor()->create(['sex' => $value]);
        }


    }


    public function render()
    {
        return view('livewire.doctor.sex');
    }
}
