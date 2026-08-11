<?php

namespace App\Livewire\Doctor;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorService;
use App\Models\Service;
use App\Models\User;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Booking extends Component
{
    public $doctor; // модель доктора
    public $user;   // текущий пользователь
    public $showModal = false;
    public $doctorId;
    public $selectedDate = null;
    public $schedules = [];
    public $selectedHour;
    public $workingHours = [];
    public $formattedDate;
    public $showLoginModal = false;
    public $showPhoneModal = false;

    public $search = '';

    public $selectedServiceId;
    public $showSuggestions = false;

    protected $listeners = ['serviceSelected'];
    public function mount($id)
    {
        //dd(session());


        $this->doctorId = $id;
        $this->doctor = Doctor::with(['user', 'services'])->findOrFail($id);
        $this->user = auth()->user(); // если пользователь залогинен
        $this->workingHours = $this->generateWorkingHours();

        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $startDate = now()->format('Y-m-d');
        $endDate = now()->addDays(30)->format('Y-m-d');

        $schedulesData = DoctorSchedule::where('doctor_id', $this->doctorId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', '!=', 'canceled')
            ->get();
        //dd($schedulesData);
        $this->schedules = $schedulesData
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            })
            ->map(function ($daySchedules) {
                return $daySchedules->keyBy(function ($sched) {
                    return substr($sched->hour, 0, 5); // '09:00'
                });
            })
            ->toArray();
        //dd($this->schedules);
    }


    public function closeModal()
    {
        $this->showModal = false;
        //$this->selectedDate = null;
        $this->showPhoneModal = false;
        // Также диспатчим при закрытии модалки
        $this->dispatch('reinit-swiper');
        $this->search = '';
    }


    private function generateWorkingHours(): array
    {
        $hours = [];
        for ($i = 8; $i <= 21; $i++) {
            $hours[] = sprintf('%02d:00', $i);
        }
        //dd($hours);
        return $hours;
    }

    public function getDatesForDisplay()
    {
        $dates = [];
        for ($i = 0; $i < 30; $i++) {
            $date = now()->addDays($i);
            $dates[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('d'),
                'month' => $date->format('m'),
                'weekday' => $date->translatedFormat('D'),
                'formatted' => $date->format('d.m'),
                'is_past' => $i === 0 && now()->format('H') >= 19,
            ];
        }
        //dd($dates);
        return $dates;
    }


    public function getCurrentStatus($date, $hour)
    {
        if (isset($this->schedules[$date][$hour])) {
            return $this->schedules[$date][$hour]['status'];
        }

        return 'non_working';
    }

    public function getTimeSlotsForDisplay($date)
    {
        $normalizedDate = Carbon::parse($date)->format('Y-m-d');
        $slots = [];

        $daySchedules = $this->schedules[$normalizedDate] ?? [];

        for ($i = 8; $i <= 21; $i++) {
            $hour = sprintf('%02d:00', $i);
            $status = $daySchedules[$hour]['status'] ?? 'non_working';

            $slots[] = [
                'hour' => $hour,
                'status' => $status,
            ];
        }
        //dd($slots);
        return $slots;
    }

    public function selectDate($date, $hour)
    {
        $this->selectedDate = $date;
        $this->selectedHour = $hour;
        if(!Auth::check()) {
           // session(['booking.intended_url' => url()->current()]);

            $this->showLoginModal = true;
            //$this->dispatch('openLoginModal');
            //dd(session());
            return;
        }
        if (Auth::user()->role != 'patient') { // 3 = patient
            // не пацієнт → форму не відкриваємо (можна показати повідомлення)
            $this->dispatch('notify', type: 'error', message: 'Тільки пацієнт може записатися.');
            return;
        }
        $this->showModal = true; // открываем модалку
       // $this->dispatch('openBookingModal');
        $this->dispatch('reinit-swiper');
    }
    // Запись на прием
    public function bookAppointment()
    {
        if (!$this->selectedServiceId) {
            $this->dispatch('alert', message: 'Оберіть послугу!');
            return;
        }
        // создаем запись в appointments
        Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $this->doctorId,
            'service_id' => $this->selectedServiceId,
            'date' => $this->selectedDate,
            'hour' => $this->selectedHour,
            'status' => 'booking',
        ]);

        // обновляем статус в doctor_schedules
        DoctorSchedule::where('doctor_id', $this->doctorId)
            ->where('date', $this->selectedDate)
            ->where('hour', $this->selectedHour)
            ->update(['status' => 'busy']);

        // закрываем модалку
        $this->showModal = false;
        $this->dispatch('reinit-swiper');

        // перезагружаем даты/слоты
        $this->loadSchedules();
    }

    public function updatedSearch($value)
    {
        $this->showSuggestions = !empty($value);

        // Опционально: автоматически выбирать первую услугу при поиске
        if ($this->services->isNotEmpty()) {
            $this->selectedServiceId = $this->services->first()->id;
        }
    }

    public function selectService($serviceId)
    {
        $service = $this->doctor->services->find($serviceId);
        if ($service) {
            $this->selectedServiceId = $serviceId;
            $this->search = $service->name;
            $this->showSuggestions = false;
        }
    }

    public function resetSearch()
    {
        $this->showSuggestions = false;
    }

    public function serviceSelected($serviceId)
    {
        $this->selectService($serviceId);
    }

    public function getServicesProperty()
    {
        $services = $this->doctor->services;

        if ($this->search) {
            $services = $services->filter(function($service) {
                return str_contains(
                    mb_strtolower($service->name),
                    mb_strtolower($this->search)
                );
            });
        }

        return $services;
    }

    public function openPhoneModal()
    {
        $this->showPhoneModal = true;
    }

    public function render()
    {

        return view('livewire.doctor.booking', [
            'dates' => $this->getDatesForDisplay(),
            'services' => $this->services,
        ]);
    }
}
