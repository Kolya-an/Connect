<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\DoctorPhoto;
use App\Models\Education;
use App\Models\Extra;
use Livewire\Component;
use App\Mail\PhotoReportMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ViewEducation extends Component
{
    public $doctor;
    public $educations;
    public $extras =[];
    public $description;
    public $education_images =[];
    public $extra_images =[];
    public $photoId;
    public bool $showReportModal = false;
    public ?int $selectedPhotoId = null;
    public string $reportText = '';

    public function mount($id)
    {
        $this->photoId = $id;
        $this->doctor = Doctor::findOrFail($id);
        $this->educations = Education::where('doctor_id', $id)->get();
        $this->extras = Extra::where('doctor_id', $id)->get();
        $images = $this->doctor->education_images;
        $this->education_images = is_array($images) ? $images : [];
        $extras_images = $this->doctor->extra_images;
        $this->extra_images = is_array($extras_images) ? $extras_images : [];
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
        Mail::to('connectcosmetologist@gmail.com')->send(new PhotoReportMail(
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
            ->paginate(2);
        return view('livewire.doctor.view-education', [
            'photos' => $photos,
        ]);
    }
}
