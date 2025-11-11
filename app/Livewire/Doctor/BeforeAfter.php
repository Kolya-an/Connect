<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\DoctorPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class BeforeAfter extends Component
{
    use WithFileUploads;

    public $photos;
    public $showAddModal = false;
    public $photo;
    public $procedure;
    public $product;
    public $list;
    public $confirmDeleteModal = false;
    public $photoToDelete = null;

    protected $rules = [
        'photo' => 'required|image|max:4096',
        'procedure' => 'required|string|max:255',
        'product' => 'nullable|string|max:255',
    ];
    protected $listeners = [
        'deletePhoto' => 'deletePhoto',
    ];

    public function mount()
    {
        $this->loadPhotos();
    }

    public function loadPhotos()
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if ($doctor) {
            $this->photos = $doctor->photos()->get();
        } else {
            $this->photos = collect();
        }
    }

    public function addPhoto()
    {
        $this->validate();

        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor) {
            session()->flash('error', 'Доктор не знайдений.');
            return;
        }

        $filename = Str::uuid() . '.' . $this->photo->getClientOriginalExtension();
        $path = $this->photo->storeAs('doctor', $filename, 'public_uploads');

        $doctor->photos()->create([
            'photo' => $path,
            'procedure' => $this->procedure,
            'product' => $this->product,
        ]);

        $this->reset(['photo', 'procedure', 'product']);
        $this->showAddModal = false;
        $this->loadPhotos();

        session()->flash('message', 'Фото успішно додано!');
    }
    public function confirmDelete($id)
    {
        $this->photoToDelete = $id;
        $this->confirmDeleteModal = true;
    }

    public function deletePhoto()
    {
        $photo = DoctorPhoto::find($this->photoToDelete);

        if ($photo) {
            $path = public_path('uploads/' . $photo->photo);
            if (file_exists($path)) {
                unlink($path);
            }
            $photo->delete();
        }

        $this->confirmDeleteModal = false;
        $this->photoToDelete = null;
        $this->loadPhotos();

        session()->flash('message', 'Фото успішно видалено!');
    }
    public function render()
    {
        return view('livewire.doctor.before-after');
    }
}
