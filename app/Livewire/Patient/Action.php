<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\DoctorPromotion;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class Action extends Component
{
    public $promotions = [];
    public $patientLocation = null;

    public function mount()
    {
        $this->loadNearestPromotions();
    }

    private function getPatientLocation()
    {
        // Пытаемся получить геолокацию из браузера (через Livewire)
        // В реальном приложении это будет приходить через JavaScript
        $latitude = request()->header('X-Latitude');
        $longitude = request()->header('X-Longitude');

        if ($latitude && $longitude) {
            return [
                'latitude' => (float)$latitude,
                'longitude' => (float)$longitude,
                'source' => 'browser'
            ];
        }

        // Если геолокация отключена, получаем город из профиля пользователя
        $user = auth()->user();
        if ($user && $user->city) {
            $cityLocation = $this->geocodeCity($user->city);
            if ($cityLocation) {
                return [
                    'latitude' => $cityLocation['lat'],
                    'longitude' => $cityLocation['lng'],
                    'source' => 'user_city',
                    'city' => $user->city
                ];
            }
        }

        // Если не удалось определить, используем Киев как fallback
        return [
            'latitude' => 50.4501,
            'longitude' => 30.5234,
            'source' => 'default_kyiv'
        ];
    }

    private function geocodeCity($cityName)
    {
        try {
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $cityName . ', Украина',
                'format' => 'json',
                'limit' => 1
            ]);

            $data = $response->json();

            if (!empty($data)) {
                return [
                    'lat' => (float)$data[0]['lat'],
                    'lng' => (float)$data[0]['lon']
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Geocoding error: ' . $e->getMessage());
        }

        return null;
    }

    private function loadNearestPromotions()
    {
        $patientLocation = $this->getPatientLocation();
        $this->patientLocation = $patientLocation;

        // Используем Haversine formula для расчета расстояния
        $promotions = DoctorPromotion::with(['doctor.user'])
            ->join('doctors', 'doctor_promotions.doctor_id', '=', 'doctors.id')
            ->join('users', 'doctors.user_id', '=', 'users.id')
            ->where('doctors.active', true)
            ->where('doctors.latitude', '!=', null)
            ->where('doctors.longitude', '!=', null)
            ->whereDate('doctor_promotions.date_from', '<=', now())
            ->whereDate('doctor_promotions.date_to', '>=', now())
            ->selectRaw('doctor_promotions.*,
                (6371 * acos(cos(radians(?)) * cos(radians(doctors.latitude)) *
                cos(radians(doctors.longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(doctors.latitude)))) AS distance',
                [
                    $patientLocation['latitude'],
                    $patientLocation['longitude'],
                    $patientLocation['latitude']
                ])
            ->orderBy('distance')
            ->limit(5)
            ->get();

        $this->promotions = $promotions;
    }

    public function render()
    {
        return view('livewire.patient.action', [
            'promotions' => $this->promotions,
            'patientLocation' => $this->patientLocation
        ]);
    }
}
