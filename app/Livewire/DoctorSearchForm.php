<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;

class DoctorSearchForm extends Component
{
    public $query = '';
    public $services = [];
    public $serviceId = null;
    public $radius = 5;
    public $city = '';
    public $service_form; // популярные сервисы

    public function mount()
    {
        $this->service_form = Service::take(5)->get(); // популярные сервисы
    }
    public function updated($property)
    {
        if ($property === 'query') {
            $this->performSearch();
        }
    }

    public function performSearch()
    {
        if (strlen($this->query) < 2) {
            $this->services = [];
            return;
        }

        $this->services = Service::where('name', 'like', '%' . $this->query . '%')
            ->limit(5)
            ->get();

        if ($this->serviceId) {
            $selectedService = Service::find($this->serviceId);
            if ($selectedService && $selectedService->name !== $this->query) {
                $this->serviceId = null;
            }
        }
    }



    public function selectService($id, $name)
    {
        $this->serviceId = $id;
        $this->query = $name;
        $this->services = [];
    }

    public function selectPopularService($id, $name)
    {
        $this->selectService($id, $name);
    }

    public function searchDoctors()
    {
        // Перенаправление на страницу Map с параметрами
        return redirect()->route('map', [
            'service_id' => $this->serviceId,
            'radius'  => $this->radius,
            'city'    => $this->city
        ]);
    }
    public function render()
    {
        return view('livewire.doctor-search-form');
    }
}
