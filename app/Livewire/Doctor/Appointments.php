<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Appointments extends Component
{
    public $showModal = false;
    public $doctorId;
    public $selectedDate = null;
    public $schedules = [];
    public $workingHours = [];
    public $formattedDate;

    public function mount()
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();
        if ($doctor) {
            $this->doctorId = $doctor->id;
        }
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
        //dd(array_keys($this->schedules));
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->showModal = true;

        $this->dispatch('reinit-swiper');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedDate = null;

        // Также диспатчим при закрытии модалки
        $this->dispatch('reinit-swiper');
    }

    public function updateTimeSlot($hour, $status)
    {
        if (!$this->selectedDate) return;

        try {
            $formattedDate = Carbon::parse($this->selectedDate)->format('Y-m-d');
            if ($status === 'non_working') {
                DoctorSchedule::where('doctor_id', $this->doctorId)
                    ->where('date', $formattedDate)
                    ->where('hour', $hour)
                    ->delete();
            } else {
                DoctorSchedule::updateOrCreate(
                    [
                        'doctor_id' => $this->doctorId,
                        'date' => $formattedDate,
                        'hour' => $hour,
                    ],
                    ['status' => $status]
                );
            }

            $this->loadSchedules();

        } catch (\Exception $e) {

        }
    }

    private function generateWorkingHours(): array
    {
        $hours = [];
        for ($i = 8; $i <= 21; $i++) {
            $hours[] = sprintf('%02d:00', $i);
        }
        return $hours;
    }

    public function getDatesForDisplay()
    {
        $dates = [];
        for ($i = 0; $i < 14; $i++) {
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

        return $slots;
    }
    public function render()
    {
        return view('livewire.doctor.appointments', [
            'dates' => $this->getDatesForDisplay(),
        ]);
    }
}
