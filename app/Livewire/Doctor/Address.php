<?php
// app/Livewire/Doctor/Address.php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Address extends Component
{
    public $user;
    public $address;
    public $showAddressModal = false;
    public $search = '';
    public $suggestions = [];
    public $isLoading = false;

    public function mount()
    {
        $this->user = Auth::user();

        if ($this->user->doctor) {
            $this->address = $this->user->doctor->address;
            $this->search = $this->user->doctor->address; // Инициализируем поле поиска
        }
    }

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->suggestions = [];
            $this->isLoading = false;
            return;
        }

        if (strlen($this->search) < 2) {
            $this->suggestions = [];
            return;
        }

        $this->isLoading = true;
        $this->dispatch('search-debounced');
    }

    public function performSearch()
    {
        if (strlen($this->search) < 2) {
            $this->suggestions = [];
            $this->isLoading = false;
            return;
        }

        try {
            $results = $this->searchStreet($this->search);
            $this->suggestions = $results;
        } catch (\Exception $e) {
            Log::error('Address search error: ' . $e->getMessage());
            $this->suggestions = [];
        }

        $this->isLoading = false;
    }

    public function searchStreet($query)
    {
        $url = "https://nominatim.openstreetmap.org/search";

        $params = [
            'q' => $query . ', Украина',
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => 20,
            'countrycodes' => 'ua',
            'accept-language' => 'uk'
        ];

        $response = Http::timeout(8)
            ->withHeaders([
                'User-Agent' => 'YourApp/1.0 (your@email.com)'
            ])
            ->get($url, $params);

        if (!$response->successful()) {
            return [];
        }

        $data = $response->json();

        if (empty($data)) {
            return [];
        }

        return $this->filterAndFormatStreets($data);
    }

    private function filterAndFormatStreets($results)
    {
        $streets = [];
        $uniqueStreets = [];

        foreach ($results as $result) {
            $address = $result['address'] ?? [];
            $displayName = $result['display_name'] ?? '';

            // Фильтруем только улицы
            if ($this->isStreet($address)) {
                $streetKey = $this->getStreetKey($address);

                // Убираем дубликаты
                if (!in_array($streetKey, $uniqueStreets)) {
                    $uniqueStreets[] = $streetKey;

                    $streets[] = [
                        'display_name' => $this->formatStreet($address),
                        'full_address' => $displayName,
                        'street_name' => $address['road'],
                        'city' => $this->getCity($address),
                        'type' => $this->getStreetType($address)
                    ];
                }
            }

            if (count($streets) >= 10) {
                break;
            }
        }

        return $streets;
    }

    private function isStreet($address)
    {
        // Проверяем, что это улица (есть road)
        $hasStreet = isset($address['road']);

        // Исключаем конкретные здания, магазины и т.д.
        $isPoi = isset($address['shop']) ||
            isset($address['amenity']) ||
            isset($address['building']) ||
            isset($address['historic']) ||
            isset($address['tourism']);

        return $hasStreet && !$isPoi;
    }

    private function getStreetKey($address)
    {
        return $address['road'] ?? '';
    }

    private function formatStreet($address)
    {
        $streetName = $address['road'] ?? '';

        if (!$streetName) {
            return null;
        }

        $streetType = $this->getStreetType($address);

        return $streetType . $streetName;
    }

    private function getCity($address)
    {
        if (isset($address['city'])) {
            return $address['city'];
        }
        if (isset($address['town'])) {
            return $address['town'];
        }
        if (isset($address['village'])) {
            return $address['village'];
        }
        return '';
    }

    private function getStreetType($address)
    {
        $street = $address['road'] ?? '';

        if (preg_match('/\b(проспект|пр-т|пр\.)\b/ui', $street)) {
            return '';
        } elseif (preg_match('/\b(бульвар|бульв|бл-р)\b/ui', $street)) {
            return '';
        } elseif (preg_match('/\b(площа|пл\.)\b/ui', $street)) {
            return '';
        } elseif (preg_match('/\b(провулок|пров|пр-к)\b/ui', $street)) {
            return '';
        } elseif (preg_match('/\b(набережна|наб)\b/ui', $street)) {
            return '';
        } else {
            return '';
        }
    }

    public function selectAddress($index)
    {
        if (isset($this->suggestions[$index])) {
            $suggestion = $this->suggestions[$index];
            $this->search = $suggestion['display_name']; // Просто обновляем поле поиска
            $this->suggestions = []; // Скрываем подсказки
        }
    }

    public function saveAddress()
    {
        // Сохраняем то что в поле поиска
        if (!empty($this->search)) {
            $this->address = $this->search;
            $this->showAddressModal = false;
            $this->suggestions = [];
            $this->save();
        }
    }

    public function clearAddress()
    {
        $this->address = '';
        $this->search = '';
        $this->suggestions = [];
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
