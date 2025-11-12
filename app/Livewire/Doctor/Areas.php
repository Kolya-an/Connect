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
    }

    // Сохраняем то, что в поле
    public function save()
    {
        $user = Auth::user();

        // Если поле не пустое, сохраняем его; иначе выбранную область
        $areaToSave = $this->search ?: $this->area;

        if (!$areaToSave) return;

        $data = ['area' => $areaToSave];

        if ($user->doctor) {
            $user->doctor->update($data);
        } else {
            $user->doctor()->create($data);
        }

        $this->area = $areaToSave; // сохраняем выбранное значение
        $this->search = ''; // очищаем поле поиска
        $this->showAreaModal = false;

        session()->flash('message', 'Інформацію оновлено!');
    }
    public function setAreaStep($areaStepNumber)
    {
        $this->areaStep = $areaStepNumber;
    }

    public function render()
    {
        $filteredAreas = collect($this->allAreas)
            ->filter(fn($area) => stripos($area, $this->search) !== false)
            ->values()
            ->take(5);

        $filteredMetros = collect($this->allMetros)
            ->filter(fn($metro) => stripos($metro, $this->search) !== false)
            ->values()
            ->take(5);

        return view('livewire.doctor.areas', [
            'filteredAreas' => $filteredAreas,
            'filteredMetros' => $filteredMetros,
        ]);
    }
}
