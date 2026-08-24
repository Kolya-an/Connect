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
    public $doctor;
    public $photoId;
    public bool $showReportModal = false;
    public ?int $selectedPhotoId = null;
    public string $reportText = '';

    use WithPagination;
    public function mount($id)
    {
        $this->photoId = $id;
        $this->doctor = Doctor::findOrFail($id);
        //$this->photos = DoctorPhoto::where('doctor_id', $id)->get();
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

        // Завантажуємо фото разом із лікарем та його користувачем
        $photo = DoctorPhoto::with(['doctor.user'])->findOrFail($this->selectedPhotoId);
        $user = Auth::user();

        // Формуємо ім'я того, хто подає скаргу
        $reporterName = $user 
            ? trim($user->name . ' ' . ($user->patient?->second_name ?? $user->doctor?->second_name ?? '')) 
            : 'Неавторизований користувач';

        // Формуємо ім'я лікаря
        $doctorName = trim(($photo->doctor?->user?->name ?? '') . ' ' . ($photo->doctor?->second_name ?? ''));

        // Відправляємо лист
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
        $photos = DoctorPhoto::where('doctor_id', $this->photoId)
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('livewire.doctor.view-photo', [
            'photos' => $photos,
        ]);
    }
}
