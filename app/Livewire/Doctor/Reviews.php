<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;
use App\Mail\ReviewReportMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Reviews extends Component
{
    public $doctor;
    public $doctorId;
    public bool $showReviewReportModal = false;
    public ?int $selectedReviewId = null;
    public string $reviewReportText = '';

    use WithPagination;

    public function mount($id)
    {
        $this->doctorId = $id;
        $this->doctor = Doctor::findOrFail($id);
    }

    public function getReviewsProperty()
    {
        return Review::with([
            'appointment.user',
            'appointment.user.patient',
        ])
            ->where('active', true) // <-- Фільтр тільки активних відгуків
            ->whereHas('appointment', function ($q) {
                $q->where('doctor_id', $this->doctorId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
    public function getMedicalAvgProperty()
    {
        return Review::where('active', true) // <-- Розрахунок середнього лише за активними
            ->whereHas('appointment', function ($q) {
                $q->where('doctor_id', $this->doctorId);
            })
            ->avg('medical');
    }
    public function getServiceAvgProperty()
    {
        return Review::where('active', true) // <-- Розрахунок середнього лише за активними
            ->whereHas('appointment', function ($q) {
                $q->where('doctor_id', $this->doctorId);
            })
            ->avg('service');
    }

    public function openReviewReportModal(int $reviewId)
    {
        $this->selectedReviewId = $reviewId;
        $this->reviewReportText = '';
        $this->showReviewReportModal = true;
    }

    public function closeReviewReportModal()
    {
        $this->showReviewReportModal = false;
        $this->reset(['selectedReviewId', 'reviewReportText']);
    }

    public function sendReviewReport()
    {
        $this->validate([
            'reviewReportText' => 'required|string|min:5|max:1000',
        ]);

        // Завантажуємо лікаря через зв'язок appointment
        $review = Review::with(['appointment.doctor.user', 'appointment.user'])->findOrFail($this->selectedReviewId);
        $user = Auth::user();

        // Автор скарги
        $reporterName = $user 
            ? trim($user->name . ' ' . ($user->patient?->second_name ?? $user->doctor?->second_name ?? '')) 
            : 'Неавторизований користувач';

        // Отримуємо ім'я лікаря через appointment->doctor
        $doctor = $review->appointment?->doctor;
        $doctorName = trim(($doctor?->user?->name ?? '') . ' ' . ($doctor?->second_name ?? ''));

        $reviewDate = $review->created_at ? $review->created_at->translatedFormat('d F Y (H:i)') : '—';
        $reviewText = $review->text ?? 'Без тексту';

        Mail::to('connectcosmetologist@gmail.com')->send(new ReviewReportMail(
            reportText: $this->reviewReportText,
            reporterName: $reporterName,
            doctorName: $doctorName,
            reviewDate: $reviewDate,
            reviewText: $reviewText
        ));

        $this->closeReviewReportModal();
        session()->flash('message', 'Дякуємо! Вашу скаргу на відгук успішно відправлено.');
    }

    public function render()
    {
        return view('livewire.doctor.reviews', [
            'reviews' => $this->reviews,
            'medicalAvg' => $this->medicalAvg,
            'serviceAvg' => $this->serviceAvg,
        ]);
    }
}
