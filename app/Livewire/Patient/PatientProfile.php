<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PatientProfile extends Component
{
    public $user;
    public $city;
    public $sex;
    public $notification = false;
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

        if ($user->patient) {
            $this->city = $user->patient->city;
            $this->sex = $user->patient->sex;
            $this->notification = (bool) $user->patient->notification;
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
    }
    public function clearCity()
    {
        $this->city = '';
        $this->search = '';
    }
    public function save()
    {
        $user = Auth::user();

        $data = [
            'city' => $this->city,
            'sex' => $this->sex,
            'notification' => $this->notification,
        ];

        if ($user->patient) {
            $user->patient->update($data);
        } else {
            $user->patient()->create($data);
        }

        session()->flash('message', 'Інформацію оновлено!');
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
        return view('livewire.patient.patient-profile', [
            'filteredCities' => $filteredCities,
        ]);
    }
}
