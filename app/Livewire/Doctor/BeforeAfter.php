<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\DoctorPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class BeforeAfter extends Component
{
    use WithFileUploads;

    public $photos;
    public $showAddModal = false;
    //public $photo;
    public $procedure;
    public $product;
    public $list;
    public $confirmDeleteModal = false;
    public $photoToDelete = null;
    public $photo_before_data;
    public $photo_after_data;

    public $orientation = 'horizontal';

    protected $rules = [
        //'photo' => 'required|image|max:4096',
        'procedure' => 'required|string|max:255',
        'product' => 'nullable|string|max:255',
        'photo_before_data' => 'required',
        'photo_after_data' => 'required',
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

        /*$filename = Str::uuid() . '.' . $this->photo->getClientOriginalExtension();
        $path = $this->photo->storeAs('doctor', $filename, 'public_uploads');*/
        // Сохранение фото ДО
        $pathBefore = $this->saveBase64($this->photo_before_data, 'before');

        // Сохранение фото ПОСЛЯ
        $pathAfter = $this->saveBase64($this->photo_after_data, 'after');


        /*$doctor->photos()->create([
            'photo' => $path,
            'procedure' => $this->procedure,
            'product' => $this->product,
        ]);*/
        $doctor->photos()->create([
            'photo_before' => $pathBefore,
            'photo_after' => $pathAfter,
            'photo' => $pathBefore, // заполняем старую колонку для совместимости
            'procedure' => $this->procedure,
            'product' => $this->product,
            'orientation' => $this->orientation,
        ]);

        $this->reset(['photo_before_data', 'photo_after_data', 'procedure', 'product']);
        $this->showAddModal = false;
        $this->loadPhotos();

        session()->flash('message', 'Фото успішно додано!');
    }
    private function saveBase64($base64Data, $type)
    {
        // Извлекаем данные из base64 строки
        $image_service_str = substr($base64Data, strpos($base64Data, ",") + 1);
        $image_binary = base64_decode($image_service_str);

        // Генерируем уникальное имя файла
        $filename = 'doctor/' . Str::uuid() . '_' . $type . '.jpg';

        // Сохраняем в диск 'public_uploads'
        Storage::disk('public_uploads')->put($filename, $image_binary);

        return $filename;
    }

    public function deletePhoto($id)
    {
        $photo = DoctorPhoto::find($id);

        if ($photo) {
            // Удаляем файлы с диска
            Storage::disk('public_uploads')->delete([
                $photo->photo_before,
                $photo->photo_after,
                $photo->photo // удаляем и старый файл для совместимости
            ]);

            $photo->delete();
        }

        $this->loadPhotos();
        session()->flash('message', 'Фото успішно видалено!');
    }
    public function render()
    {
        return view('livewire.doctor.before-after');
    }
}
