<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Areas extends Component
{
    public $areaStep = 1;

    public $user;
    public $area;

    public $showAreaModal = false;
    public $allAreas = [
        'Голосiївський', 'Дарницький', 'Деснянський', 'Днiпровський', 'Оболонський'
    ];
    public $allMetros = [
        'Арсенальна', 'Політех', 'Хрещатик', 'Олімпійський', 'Славутич'
    ];
    public $search = '';
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();

        if ($user->doctor) {
            $this->area = $user->doctor->area;
        }
    }
    public function updatedSearch()
    {
        // Этот метод заставляет Livewire перерендерить компонент при каждом изменении поля поиска
    }
    public function selectArea($areaName)
    {
        $this->area = $areaName;
        $this->showAreaModal = false;
        $this->search = '';
        $this->save();
    }
    public function clearArea()
    {
        $this->area = '';
        $this->search = '';
    }
    public function save()
    {
        $user = Auth::user();

        $data = [
            'area' => $this->area,
        ];

        if ($user->doctor) {
            $user->doctor->update($data);
        } else {
            $user->doctor()->create($data);
        }

        session()->flash('message', 'Інформацію оновлено!');
    }
    public function resetArea()
    {
        $this->area = '';
        $this->showAreaModal = true; // открываем модалку, если нужно
    }
    public function setAreaStep($areaStepNumber)
    {
        $this->areaStep = $areaStepNumber;
    }
    public function render()
    {
        $filteredAreas = collect($this->allAreas)
            ->filter(function ($areas) {
                return stripos($areas, $this->search) !== false;
            })
            ->values();
        $filteredMetros = collect($this->allMetros)
            ->filter(function ($metros) {
                return stripos($metros, $this->search) !== false;
            })
            ->values();
        return view('livewire.doctor.areas', [
            'filteredAreas' => $filteredAreas,
            'filteredMetros' => $filteredMetros,
        ]);
    }
}
