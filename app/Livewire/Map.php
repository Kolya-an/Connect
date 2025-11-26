<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use App\Models\Doctor;

class Map extends Component
{
    public $radius = 5;
    public $city;
    public $userLat;
    public $userLng;
    public $serviceId;
    protected $queryString = [
        'serviceId' => ['as' => 'service_id']
    ];
    public $doctorsList = [];

    protected $listeners = ['setUserLocation'];

    public function mount()
    {
        $this->serviceId = request()->query('service_id');
        $cityQuery = request()->query('city');
        $this->city = !empty($cityQuery) && is_string($cityQuery)
            ? (trim(strip_tags($cityQuery)) ?: '')
            : '';

        $radiusQuery = request()->query('radius');
        $this->radius = !empty($radiusQuery)
            ? (trim(strip_tags($radiusQuery)) ?: 5)
            : 5;

        $this->userLat = null;
        $this->userLng = null;

        // 1. ПОПЫТКА УСТАНОВИТЬ КООРДИНАТЫ ГОРОДА
        if ($this->city) {
            $coordinates = $this->geocodeCity($this->city);
            if ($coordinates) {
                $this->userLat = $coordinates['lat'];
                $this->userLng = $coordinates['lng'];
                $this->emitDoctors(); // Запускаем поиск по городу сразу
            }
        }
//dd($this->userLng);
        /*$this->dispatch('componentMounted', [
            'hasCity' => !empty($this->city) && $this->city !== '',
            'city' => $this->city
        ]);*/

    }
    public function getCityCoordinates($cityName)
    {
        $coordinates = $this->geocodeCity($cityName);
        if ($coordinates) {
            $this->dispatch('cityCoordinatesReceived', [
                'lat' => $coordinates['lat'],
                'lng' => $coordinates['lng']
            ]);
        }
    }
    public function setUserLocation($lat, $lng)
    {
        if ($this->city) {
            $coordinates = $this->geocodeCity($this->city);
            if ($coordinates) {
                $this->userLat = $coordinates['lat'];
                $this->userLng = $coordinates['lng'];
                $this->dispatch('updateMapCenter', [
                    'lat' => $this->userLat,
                    'lng' => $this->userLng
                ]);

            } else {
                // Если не удалось получить координаты города, используем геолокацию
                $this->userLat = $lat;
                $this->userLng = $lng;
            }
        } else {
            // Если город не выбран, используем геолокацию
            $this->userLat = $lat;
            $this->userLng = $lng;
        }

        $this->emitDoctors();
    }
    public function updatedCity()
    {
        if ($this->city) {
            // При выборе города обновляем координаты
            $coordinates = $this->geocodeCity($this->city);
            if ($coordinates) {
                $this->userLat = $coordinates['lat'];
                $this->userLng = $coordinates['lng'];

                $this->dispatch('updateMapCenter', [
                    'lat' => $this->userLat,
                    'lng' => $this->userLng
                ]);

                $this->emitDoctors();
            }
        } else {
            // Если город сброшен, запрашиваем геолокацию заново
            $this->dispatch('requestGeolocation');
        }
    }
    private function geocodeCity($cityName)
    {
        // Используем кэш чтобы не делать запросы при каждом обновлении
        return Cache::remember("city_coordinates_{$cityName}", 3600, function () use ($cityName) {
            $apiKey = config('services.google.maps_api_key');
            $url = "https://maps.googleapis.com/maps/api/geocode/json";

            $response = Http::get($url, [
                'address' => $cityName . ', Украина',
                'key' => $apiKey,
                'language' => 'uk'
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === 'OK' && !empty($data['results'])) {
                    $location = $data['results'][0]['geometry']['location'];
                    return [
                        'lat' => $location['lat'],
                        'lng' => $location['lng']
                    ];
                }
            }

            return null;
        });
    }

    public function updatedRadius()
    {
        $this->emitDoctors();
    }

    public function emitDoctors()
    {
        if (!$this->userLat || !$this->userLng) {
            //dd($this->userLat);
            // Если координат нет, отправляем пустой массив и возвращаемся
            $this->dispatch('updateMapMarkers', doctors: []);
            //dd('Dispatched empty markers because coordinates are missing.');// Для отладки:
            return;
        }
        //dd($this->userLat);
        $doctors = Doctor::with('user', 'promotions', 'services', 'photos')
            ->when($this->serviceId, function ($q) {
                $q->whereHas('services', function ($q) {
                    $q->where('service_id', $this->serviceId);
                });
            })
            ->selectRaw("
                doctors.*,
                (6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )) AS distance
            ", [$this->userLat, $this->userLng, $this->userLat])
            ->having("distance", "<=", $this->radius)
            ->orderBy("distance")
            ->get();

        $this->doctorsList = $doctors;
        //   $this->dispatch('markersReady');
        //$this->dispatch('updateMapMarkers');
        //dd($doctors->toArray());
        $this->dispatch('updateMapMarkers', doctors: $this->doctorsList);
    }
    public function getDoctorMarkersData(): array
    {
        // Возвращаем данные, которые уже были получены в emitDoctors()
        if ($this->doctorsList) {
            // Убедитесь, что это всегда массив (если $doctorsList - коллекция)
            return $this->doctorsList->toArray();
        }
        return [];
    }
    public function render()
    {
        return view('livewire.map',
            [ 'doctors' => $this->doctorsList ])
        ->layout('livewire.pages.map');
    }
}
