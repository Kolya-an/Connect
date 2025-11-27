<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use App\Models\Doctor;
use Livewire\Attributes\Url;

class Map extends Component
{
    public $sort = 'rating';
    public $radius = 5;
    public $city;
    public $rating = '';
    public $sex = '';
    public $area = '';
    public $priceFrom = '';
    public $priceTo = '';
    public $userLat;
    public $userLng;
    public $serviceId;
    #[Url(as: 'doctor_id')]
    public $doctorId;
    public $discount = false;
    public $at_home = false;
    public $gift = false;
    protected $queryString = [
        'serviceId' => ['as' => 'service_id']
    ];
    public $doctorsList = [];

    protected $listeners = ['setUserLocation'];
    #[Url(as: 'sort')]
    public $sortQuery;

    public function mount()
    {
        $this->serviceId = request()->query('service_id');
        $this->doctorId = request()->query('doctor_id');
        $this->rating = request()->query('rating');
        $this->sex = request()->query('sex');
        $this->discount = request()->query('discount');
        $this->at_home = request()->query('at_home');
        $this->gift = request()->query('gift');

        $priceFromQuery = request()->query('priceFrom');
        $this->priceFrom = is_numeric($priceFromQuery) ? (int)$priceFromQuery : null;

        $priceToQuery = request()->query('priceTo');
        $this->priceTo = is_numeric($priceToQuery) ? (int)$priceToQuery : null;

        $cityQuery = request()->query('city');
        $this->city = !empty($cityQuery) && is_string($cityQuery)
            ? (trim(strip_tags($cityQuery)) ?: '')
            : '';

        $areaQuery = request()->query('area');
        $this->area = !empty($areaQuery) && is_string($areaQuery)
            ? (trim(strip_tags($areaQuery)) ?: '')
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
        if ($this->doctorId) {
            //dd($this->doctorId);
            $doctor = Doctor::find($this->doctorId);

            if ($doctor) {
                // Устанавливаем координаты доктора как центр поиска/карты
                $this->userLat = $doctor->latitude;
                $this->userLng = $doctor->longitude;
                // Установим радиус на 0, чтобы показать только этого доктора,
                // если не требуется другой логики фильтрации
                $this->radius = 0;
                $this->emitDoctors();
            }
        }
        if ($this->sortQuery) {
            $this->sort = $this->sortQuery;
        }
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
                    'lng' => $this->userLng,
                    'radius' => $this->radius
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
                    'lng' => $this->userLng,
                    'radius' => $this->radius
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
    public function getDoctorMarkersData(): array
    {
        // Возвращаем данные, которые уже были получены в emitDoctors()
        if ($this->doctorsList) {
            // Убедитесь, что это всегда массив (если $doctorsList - коллекция)
            return $this->doctorsList->toArray();
        }
        return [];
    }
    public function updatedRating()
    {
        $this->emitDoctors();
    }
    public function updatedSort($value)
    {
        // Оновлюємо властивість Query String для URL
        $this->sortQuery = $value;

        // Викликаємо оновлення списку після зміни сортування
        $this->emitDoctors();
    }
    public function emitDoctors()
    {
        if (!$this->userLat || !$this->userLng) {
            $this->dispatch('updateMapMarkers', doctors: []);
            return;
        }

        $doctors = Doctor::withCount('reviews') // Добавляет поле reviews_count
        ->with('user', 'promotions', 'services', 'photos')
            ->when($this->serviceId, function ($q) {
                $q->whereHas('services', function ($q) {
                    $q->where('service_id', $this->serviceId);
                });
            })
            ->when($this->doctorId, function ($q) {
                $q->where('id', $this->doctorId);
               })
            ->when($this->rating, function ($q) {
                $ratingValue = (int) $this->rating;
                $q->where('rating', '>=', $ratingValue);

            })
            ->when($this->sex, function ($q) {
                $q->where('sex', $this->sex);
            })
            ->when($this->at_home, function ($q) {
                $q->where('at_home', $this->at_home);
            })
            ->when($this->gift, function ($q) {
                $q->where('gift', $this->gift);
            })
            ->when($this->area, function ($q) {
                $q->where('area', $this->area);
            })
            ->when($this->discount, function ($q) {
                $q->whereHas('promotions', function ($q) {
                    $q->where('date_from', '<=', now())
                        ->where('date_to', '>=', now());
                });
            })
            ->when($this->priceFrom || $this->priceTo, function ($q) {

                $q->whereHas('services', function ($q) {

                    // 1. Если выбрана услуга — фильтр именно по этой услуге
                    if ($this->serviceId) {
                        $q->where('service_id', $this->serviceId);
                    }

                    // 2. Фильтр по цене — всегда через pivot doctor_service
                    if ($this->priceFrom) {
                        $q->where('doctor_service.price', '>=', $this->priceFrom);
                    }

                    if ($this->priceTo) {
                        $q->where('doctor_service.price', '<=', $this->priceTo);
                    }
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
            ->when($this->sort === 'rating', function ($q) {
                $q->orderByDesc('rating');
            })
            ->when($this->sort === 'reviews', function ($q) {
                $q->orderByDesc('reviews_count');
            })
            ->when($this->sort === 'cheaper' || $this->sort === 'expensive', function ($q) {

                // Використовуємо SubQuery для знаходження мінімальної ціни послуг кожного лікаря
                $q->withMin('services as min_price', 'doctor_service.price');

                if ($this->sort === 'cheaper') {
                    $q->orderBy('min_price');
                } else {
                    $q->orderByDesc('min_price');
                }
            })

            // За замовчуванням або як другорядне сортування: за відстанню
            ->when($this->sort !== 'cheaper' && $this->sort !== 'expensive', function ($q) {
                $q->orderBy("distance");
            })
            // Якщо сортування за ціною, то відстань як другорядний критерій:
            ->when($this->sort === 'cheaper' || $this->sort === 'expensive', function ($q) {
                $q->orderBy("distance");
            })
            ->get();

        $this->doctorsList = $doctors;

        if ($this->doctorId && $this->doctorsList->isNotEmpty()) {
            $doctor = $this->doctorsList->first();
            $this->dispatch('updateMapCenter', lat: $doctor->latitude, lng: $doctor->longitude, radius: 5);
        }
        $this->dispatch('updateMapMarkers', doctors: $this->doctorsList);
    }

    public function render()
    {
        return view('livewire.map',
            [ 'doctors' => $this->doctorsList ])
        ->layout('livewire.pages.map');
    }
}
