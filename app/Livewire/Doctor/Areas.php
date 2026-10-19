<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Areas extends Component
{
    public $areaStep = 1;
    public $user;
    public $area;   // выбранное значение
    public $search = ''; // текст из поля
    public $showAreaModal = false;

    public $allAreas = [
        'Голосіївський', 'Дарницький', 'Деснянський', 'Дніпровський', 'Оболонський',
        'Святошинський', 'Солом’янський', 'Подільський', 'Печерський', 'Шевченківський'
    ];

    public $allMetros = [
        'Академмістечко', 'Житомирська', 'Святошин', 'Нивки', 'Берестейська', 'Шулявська',
        'Політехнічний інститут', 'Вокзальна', 'Університет', 'Театральна', 'Хрещатик', 'Арсенальна',
        'Дніпро', 'Лівобережна', 'Чернігівська', 'Дарниця', 'Християнська', 'Лісова',
        'Героїв Дніпра', 'Мінська', 'Оболонь', 'Почайна', 'Тараса Шевченка', 'Контрактова площа',
        'Майдан Незалежності', 'Площа Льва Толстого', 'Олімпійська', 'Палац Україна', 'Либідська',
        'Деміївська', 'Голосіївська', 'Васильківська', 'Виставковий центр', 'Іподром', 'Теремки',
        'Сирець', 'Дорогожичі', 'Лук’янівська', 'Золоті ворота', 'Театральна', 'Кловська', 'Печерська',
        'Дружби народів', 'Видубичі', 'Славутич', 'Осокорки', 'Позняки', 'Харківська', 'Вирлиця', 'Бортничі'
    ];

    public function mount()
    {
        $this->user = Auth::user();

        if ($this->user->doctor) {
            $this->area = $this->user->doctor->area;
        }
    }

    public function selectArea($areaName)
    {
        $this->area = $areaName;
        $this->search = '';
        $this->showAreaModal = false;
        $this->saveToDatabase($areaName);
    }

    // Зберігаємо вибране або введене значення
    public function save()
    {
        $areaToSave = $this->search ?: $this->area;

        if (!empty($areaToSave)) {
            $this->saveToDatabase($areaToSave);
        }
    }

    private function saveToDatabase($value)
    {
        $user = Auth::user();
        $data = ['area' => $value];

        if ($user->doctor) {
            $user->doctor->update($data);
        } else {
            $user->doctor()->create($data);
        }

        $this->area = $value;
        $this->search = '';
        $this->showAreaModal = false;

        session()->flash('message', 'Інформацію оновлено!');
    }

    public function setAreaStep($areaStepNumber)
    {
        $this->areaStep = $areaStepNumber;
    }

    public function resetArea()
    {
        $this->area = '';
        $this->search = '';
        $this->saveToDatabase('');
    }

    public function render()
    {
        // Нормалізуємо пошуковий запит (нижній регістр + прибираємо пробіли)
        $search = mb_strtolower(trim($this->search));

        $filteredAreas = collect($this->allAreas)
            ->filter(function ($item) use ($search) {
                if (empty($search)) {
                    return true; // Показуємо всі, якщо пошук пустий
                }
                return mb_strpos(mb_strtolower($item), $search) !== false;
            })
            ->values()
            ->take(5);

        $filteredMetros = collect($this->allMetros)
            ->filter(function ($item) use ($search) {
                if (empty($search)) {
                    return true; // Показуємо всі, якщо пошук пустий
                }
                return mb_strpos(mb_strtolower($item), $search) !== false;
            })
            ->values()
            ->take(5);

        return view('livewire.doctor.areas', [
            'filteredAreas' => $filteredAreas,
            'filteredMetros' => $filteredMetros,
        ]);
    }
}