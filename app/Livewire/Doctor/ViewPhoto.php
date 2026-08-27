<?php

namespace App\Livewire\Doctor;

use App\Models\DoctorPhoto;
use Livewire\Component;
use App\Models\Doctor;
use Livewire\WithPagination;
use App\Mail\PhotoReportMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ViewPhoto extends Component
{
    use WithPagination;

    public $doctor;
    public $photoId;
    public bool $showReportModal = false;
    public ?int $selectedPhotoId = null;
    public string $reportText = '';

    public function mount($id)
    {
        $this->photoId = $id;
        $this->doctor = Doctor::findOrFail($id);
    }

    public function openReportModal(int $photoId)
    {
        $this->selectedPhotoId = $photoId;
        $this->reportText = '';
        $this->showReportModal = true;
    }

    public function closeReportModal()
    {
        $this->showReportModal = false;
        $this->reset(['selectedPhotoId', 'reportText']);
    }

    public function sendReport()
    {
        $this->validate([
            'reportText' => 'required|string|min:5|max:1000',
        ]);

        $photo = DoctorPhoto::with(['doctor.user'])->findOrFail($this->selectedPhotoId);
        $user = Auth::user();

        $reporterName = $user 
            ? trim($user->name . ' ' . ($user->patient?->second_name ?? $user->doctor?->second_name ?? '')) 
            : 'Неавторизований користувач';

        $doctorName = trim(($photo->doctor?->user?->name ?? '') . ' ' . ($photo->doctor?->second_name ?? ''));

        Mail::to('kolyaan@gmail.com')->send(new PhotoReportMail(
            reportText: $this->reportText,
            reporterName: $reporterName,
            doctorName: $doctorName,
            photoBefore: asset('uploads/' . $photo->photo_before),
            photoAfter: asset('uploads/' . $photo->photo_after)
        ));

        $this->closeReportModal();
        session()->flash('message', 'Дякуємо! Вашу скаргу успішно відправлено.');
    }

    public function render()
    {
        // Виводимо ТІЛЬКИ ті фото, де userSignature має статус 'signed'
        $photos = DoctorPhoto::where('doctor_id', $this->photoId)
            ->whereHas('photoConsent', function ($query) {
                $query->where('status', 'signed');
            })
            ->with(['photoConsent'])
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('livewire.doctor.view-photo', [
            'photos' => $photos,
        ]);
    }
}