<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Address extends Component
{
    public $user;
    public $address;
    public $showAddressModal = false;
    public $allAddresses = [
        'Голосiївський', 'Дарницький', 'Деснянський', 'Днiпровський', 'Оболонський'
    ];

    public $search = '';
    public function mount()
    {
        $this->user = Auth::user();

        $user = Auth::user();

        if ($user->doctor) {
            $this->address = $user->doctor->address;
        }
    }
    public function updatedSearch()
    {
        // Этот метод заставляет Livewire перерендерить компонент при каждом изменении поля поиска
    }
    public function selectAddress($addressName)
    {
        $this->address = $addressName;
        $this->showAddressModal = false;
        $this->search = '';
        $this->save();
    }
    public function clearAddress()
    {
        $this->address = '';
        $this->search = '';
    }
    public function save()
    {
        $user = Auth::user();

        $data = [
            'address' => $this->address,
        ];

        if ($user->doctor) {
            $user->doctor->update($data);
        } else {
            $user->doctor()->create($data);
        }

        session()->flash('message', 'Інформацію оновлено!');
    }
    public function resetAddress()
    {
        $this->address = '';
        $this->showAddressModal = true; // открываем модалку, если нужно
    }
    public function render()
    {
        $filteredAddresses = collect($this->allAddresses)
        ->filter(function ($address) {
            return stripos($address, $this->search) !== false;
        })
        ->values();
        return view('livewire.doctor.address', [
            'filteredAddresses' => $filteredAddresses,
        ]);
    }
}
