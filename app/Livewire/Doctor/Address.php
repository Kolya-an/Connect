<?php
namespace App\Livewire\Doctor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Address extends Component
{
    public $user;
    public $address;
    public $showAddressModal = false;
    public $search = ''; // Використовуємо як поле введення адреси

    public function mount()
    {
        $this->user = Auth::user();

        if ($this->user->doctor) {
            $this->address = $this->user->doctor->address;
            $this->search = $this->user->doctor->address; 
        }
    }

    public function saveAddress()
    {
        if (!empty($this->search)) {
            $this->address = $this->search;
            $this->showAddressModal = false;
            $this->save();
        }
    }

    public function clearAddress()
    {
        $this->address = '';
        $this->search = '';
        $this->save();
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

        session()->flash('message', 'Адресу збережено!');
    }

    public function render()
    {
        return view('livewire.doctor.address');
    }
}