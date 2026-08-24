<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Mail\DoctorReportMail;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DoctorProfile extends Component
{
    public $user = [];
    public $user_id;
    public $doctor;
    public $step = 1;
    public $reviewsCount = 0;
    protected $queryString = [
        'step' => ['as' => 'tab', 'except' => 1],
        // 'except' => 1 означает, что tab=1 не будет отображаться в URL
    ];
    public bool $showDoctorReportModal = false;
    public ?int $selectedDoctorId = null;
    public string $doctorReportText = '';

    public function mount(User $id)
    {
        $this->user = $id;
        $this->user_id = $this->user->id;
        //$this->user->load('doctor.promotions');
        $id->load([
            'doctor' => function ($query) {
                $query->with('promotions')->withCount('reviews');
            }
        ]);
        $this->doctor = $this->user->doctor;
        //dd($this->doctor->reviews_count);
        $this->reviewsCount = $this->doctor->reviews_count ?? 0;
    }

    public function setStep($stepNumber)
    {
        $this->step = $stepNumber;
        if ($this->step === 2) {
            $this->dispatch('reinit-swipers');
        }
    }
    public function openDoctorReportModal(?int $doctorId = null)
    {
        // Якщо ID передано кнопкою — беремо його, інакше використовуємо з властивостей компонента
        $this->selectedDoctorId = $doctorId ?? $this->doctor?->id;
        $this->doctorReportText = '';
        $this->showDoctorReportModal = true;
    }

    public function closeDoctorReportModal()
    {
        $this->showDoctorReportModal = false;
        $this->reset(['selectedDoctorId', 'doctorReportText']);
    }

    public function sendDoctorReport()
    {
        $this->validate([
            'doctorReportText' => 'required|string|min:5|max:1000',
        ]);

        $doctor = Doctor::with('user')->findOrFail($this->selectedDoctorId);
        $user = Auth::user();

        // Ім'я автора скарги
        $reporterName = $user 
            ? trim($user->name . ' ' . ($user->patient?->second_name ?? $user->doctor?->second_name ?? '')) 
            : 'Неавторизований користувач';

        // ПІБ лікаря, на якого скаржаться
        $doctorName = trim(($doctor->user?->name ?? '') . ' ' . ($doctor->second_name ?? ''));

        // Відправка листа
        Mail::to('connectcosmetologist@gmail.com')->send(new DoctorReportMail(
            reportText: $this->doctorReportText,
            reporterName: $reporterName,
            doctorName: $doctorName
        ));

        $this->closeDoctorReportModal();
        session()->flash('message', 'Дякуємо! Вашу скаргу на лікаря успішно відправлено.');
    }

    public function render()
    {
        return view('livewire.doctor-profile')->layout('doctor.view');

    }
}
