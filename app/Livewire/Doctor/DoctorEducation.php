<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Education;

class DoctorEducation extends Component
{
    use WithFileUploads;
    public $educations = [];
    public $newTitle = '';
    public $newDates = '';
    public $newDesc = '';

    public $doctor;
    public $photos = [];
    public $photo;
    public function mount()
    {
        $doctor = Auth::user()->doctor;

        if ($doctor) {
            $this->educations = $doctor->education()->get()->toArray();
            $this->photos = $doctor->education_images ?? [];
        }
    }
    public function addEducation()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) return;

        // Створюємо новий запис у базі
        $education = Education::create([
            'doctor_id' => $doctor->id,
            'title' => '',
            'period' => '',
            'desc' => '',
        ]);

        // Додаємо його у список Livewire
        $this->educations[] = $education->toArray();
    }
    public function removeEducation($id)
    {
        // Удаляем из БД
        Education::where('id', $id)->delete();

        // Удаляем из массива для Livewire
        $this->educations = array_filter($this->educations, fn($item) => $item['id'] != $id);
    }

    public function updateField($id, $field, $value)
    {
        $value = trim($value ?? '');

        $education = Education::find($id);

        if ($education) {
            $education->update([
                $field => $value === '' ? '' : $value,
            ]);
        }

        // Обновляем локальный массив
        foreach ($this->educations as &$item) {
            if ($item['id'] == $id) {
                $item[$field] = $value === '' ? '' : $value;
                break;
            }
        }
    }
    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048', // до 2 МБ
        ]);

        $filename = time() . '_' . $this->photo->getClientOriginalName();
        $path = $this->photo->storeAs(
            'education',
            $filename,
            'public_uploads'
        );

        $this->photos[] = $path;
        $this->savePhotos();
    }
    public function removeImage($path)
    {
        Storage::disk('public_uploads')->delete($path);

        $this->photos = array_values(
            array_filter($this->photos, fn ($img) => $img !== $path)
        );

        $this->savePhotos();
    }

    private function savePhotos()
    {
        $doctor = Auth::user()->doctor;

        if ($doctor) {
            $doctor->update([
                'education_images' => !empty($this->photos) ? $this->photos : null,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.doctor.doctor-education');
    }
}
