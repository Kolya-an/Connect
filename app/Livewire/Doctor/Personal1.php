<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Personal1 extends Component
{
    public $user;
    public $city;

    public $showCityModal = false;

    public $allCities = [
        'Авдіївка', 'Алмазна', 'Амвросіївка', 'Ананьїв', 'Андрушівка',
        'Баранівка', 'Бахмут', 'Бердянськ', 'Біла Церква', 'Вінниця', 'Київ', 'Львів'
    ];
    public $search = '';
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();

        if ($user->doctor) {
            $this->city = $user->doctor->city;
        }
    }
    public function updatedSearch()
    {
        // Этот метод заставляет Livewire перерендерить компонент при каждом изменении поля поиска
    }
    public function selectCity($cityName)
    {
        $this->city = $cityName;
        $this->showCityModal = false;
        $this->search = '';
        $this->saveCity();
    }


    public function clearCity()
    {
        $this->city = '';
        $this->search = '';
    }

    public function saveCity()
    {
        $user = Auth::user();

        $data = [
            'city' => $this->city,
        ];

        if ($user->doctor) {
            $user->doctor->update($data);
        } else {
            $user->doctor()->create($data);
        }

    }


    public function resetCity()
    {
        $this->city = '';
        $this->showCityModal = true; // открываем модалку, если нужно
    }

    public function render()
    {
        $filteredCities = collect($this->allCities)
            ->filter(function ($city) {
                return stripos($city, $this->search) !== false;
            })
            ->values();

        return view('livewire.doctor.personal1', [
            'filteredCities' => $filteredCities,
        ]);
    }
}
