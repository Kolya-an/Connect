<?php

namespace App\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\DoctorPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PhotoConsent;
use App\Models\UserSignature;
use App\Models\Pacient;

class BeforeAfter extends Component
{
    use WithFileUploads;

    public $photos;
    public $showAddModal = false;
    public $procedure;
    public $product;
    public $list;
    public $confirmDeleteModal = false;
    public $photoToDelete = null;
    public $photo_before_data;
    public $photo_after_data;
    public $accept_umov = false;
    public $accept_zgoda = false;
    public $patient_id; // Властивість для збереження обраного пацієнта
    public $patients = [];

    public $orientation = 'horizontal';

    protected function rules()
    {
        return [
            'patient_id'        => 'required|exists:users,id',
            'procedure'         => 'required|string|max:255',
            'product'           => 'nullable|string|max:255',
            'photo_before_data' => 'required',
            'photo_after_data'  => 'required',
        ];
    }

    protected $listeners = [
        'deletePhoto' => 'deletePhoto',
    ];

    public function mount()
    {
        $this->loadPhotos();

        $doctor = Doctor::where('user_id', Auth::id())->first();

        if ($doctor) {
            // 1. Беремо унікальні user_id пацієнтів з таблиці appointments для цього лікаря
            $userIds = \App\Models\Appointment::where('doctor_id', $doctor->id)
                ->whereNotNull('user_id')
                ->pluck('user_id')
                ->unique();

            // 2. Завантажуємо пацієнтів із таблиці pacients разом із name з таблиці users
            $this->patients = Pacient::whereIn('user_id', $userIds)
                ->with('user')
                ->get();
        } else {
            $this->patients = collect();
        }
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

        $pathBefore = $this->saveBase64($this->photo_before_data, 'before');
        $pathAfter = $this->saveBase64($this->photo_after_data, 'after');

        // Знаходимо модель Pacient за її user_id, щоб отримати її реальний pacient.id
        $pacientModel = Pacient::where('user_id', $this->patient_id)->first();

        // 1. Створюємо фото з прив'язкою до pacients.id
        $photo = $doctor->photos()->create([
            'patient_id'   => $pacientModel?->id, // Зберігаємо ID з таблиці pacients
            'photo_before' => $pathBefore,
            'photo_after'  => $pathAfter,
            'photo'        => $pathBefore,
            'procedure'    => $this->procedure,
            'product'      => $this->product,
            'orientation'  => $this->orientation,
            'is_published' => false, 
        ]);

        $token = Str::random(64);

        // 2. Створюємо запис підпису, передаючи ID користувача з таблиці users ($this->patient_id)
        $doctorName = trim(($doctor->user?->name ?? '') . ' ' . ($doctor->second_name ?? ''));

        $signature = UserSignature::create([
            'user_id'     => $this->patient_id, // Береться напряму ID з таблиці users
            'doctor_id'   => $doctor->id,
            'title'       => 'Згода на публікацію фотографій',
            'description' => "Лікар {$doctorName} просить надати згоду на публікацію фотографій «До / Після» по процедурі: {$this->procedure}.",
            'token'       => $token,
            'status'      => 'pending',
            'is_read'     => false,
        ]);

        // 3. Створюємо PhotoConsent
        PhotoConsent::create([
            'doctor_photo_id'   => $photo->id,
            'user_signature_id' => $signature->id,
            'token'             => $token,
            'status'            => 'pending',
        ]);

        $this->reset(['photo_before_data', 'photo_after_data', 'procedure', 'product', 'patient_id']);
        $this->showAddModal = false;
        $this->loadPhotos();

        session()->flash('message', 'Фото успішно додано!');
    }

    private function saveBase64($base64Data, $type)
    {
        $image_service_str = substr($base64Data, strpos($base64Data, ",") + 1);
        $image_binary = base64_decode($image_service_str);

        $filename = 'doctor/' . Str::uuid() . '_' . $type . '.jpg';

        Storage::disk('public_uploads')->put($filename, $image_binary);

        return $filename;
    }

    public function deletePhoto($id)
    {
        $photo = DoctorPhoto::find($id);

        if ($photo) {
            Storage::disk('public_uploads')->delete([
                $photo->photo_before,
                $photo->photo_after,
                $photo->photo
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