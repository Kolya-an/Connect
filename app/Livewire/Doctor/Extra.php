<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class Extra extends Component
{
    use WithFileUploads;
    public $extras = [];
    public $newTitle = '';
    public $newDates = '';
    public $newDesc = '';
    public $doctor;
    public $photo;
    public $photos = [];
    public function mount()
    {
        $doctor = Auth::user()->doctor;

        if ($doctor) {
            $this->extras = $doctor->extra()->get()->toArray();
            $this->photos = $doctor->extra_images ?? [];
        }
    }
    public function addExtra()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) return;

        // Створюємо новий запис у базі
        $extra = \App\Models\Extra::create([
            'doctor_id' => $doctor->id,
            'title' => '',
            'period' => '',
            'desc' => '',
        ]);

        // Додаємо його у список Livewire
        $this->extras[] = $extra->toArray();
    }
    public function removeExtra($id)
    {
        \App\Models\Extra::where('id', $id)->delete();

        // Удаляем из массива для Livewire
        $this->extras = array_filter($this->extras, fn($item) => $item['id'] != $id);
    }
    public function updateField($id, $field, $value)
    {
        $education = \App\Models\Extra::find($id);
        if ($education) {
            $education->update([$field => $value]);
        }
        // Оновлюємо локальний масив, щоб UI одразу відображав зміни
        foreach ($this->extras as &$item) {
            if ($item['id'] == $id) {
                $item[$field] = $value;
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
        $this->photo->storeAs('extra', $filename, 'public_uploads');

        $this->photos[] = $filename;
        $this->saveCertificatePhotos();
    }
    public function removeCertificateImage($filename)
    {
        Storage::disk('public_uploads')->delete($filename);

        $this->photos = array_values(array_filter($this->photos, fn($img) => $img !== $filename));

        $this->saveCertificatePhotos();
    }

    private function saveCertificatePhotos()
    {
        $doctor = Auth::user()->doctor;

        if ($doctor) {
            $doctor->update([
                'extra_images' => !empty($this->photos) ? $this->photos : null,
            ]);
        }
    }
    public function render()
    {
        return view('livewire.doctor.extra');
    }
}
