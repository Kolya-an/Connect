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
use App\Services\DiiaService;
use App\Enums\ConsentStatus;
use Livewire\Attributes\Computed;

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
    public $patient_id;
    public $patients = [];

    // ✅ Замість одиничного $consent використовуємо масив посилань по photo_id
    public array $generatedLinks = [];

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
            $userIds = \App\Models\Appointment::where('doctor_id', $doctor->id)
                ->whereNotNull('user_id')
                ->pluck('user_id')
                ->unique();

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
            // ✅ Додаємо eager loading для photoConsent
            $this->photos = $doctor->photos()->with('photoConsent')->get();
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

        $pacientModel = Pacient::where('user_id', $this->patient_id)->first();

        $photo = $doctor->photos()->create([
            'patient_id'   => $pacientModel?->id,
            'photo_before' => $pathBefore,
            'photo_after'  => $pathAfter,
            'photo'        => $pathBefore,
            'procedure'    => $this->procedure,
            'product'      => $this->product,
            'orientation'  => $this->orientation,
            'is_published' => false, 
        ]);

        $token = Str::random(64);
        $doctorName = trim(($doctor->user?->name ?? '') . ' ' . ($doctor->second_name ?? ''));

        $signature = UserSignature::create([
            'user_id'     => $this->patient_id,
            'doctor_id'   => $doctor->id,
            'photo_id'    => $photo->id,
            'title'       => 'Згода на публікацію фотографій',
            'description' => "Лікар {$doctorName} просить надати згоду на публікацію фотографій «До / Після» по процедурі: {$this->procedure}.",
            'token'       => $token,
            'status'      => 'pending',
            'is_read'     => false,
        ]);

        PhotoConsent::create([
            'doctor_photo_id'   => $photo->id,
            'user_signature_id' => $signature->id,
            'token'             => $token,
            'status'            => ConsentStatus::PENDING,
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

    /**
     * ✅ Генерація унікального посилання для конкретного фото за ID
     */
    public function generateConsentLink(int $photoId)
    {
        $token = Str::random(32);

        $consent = PhotoConsent::firstOrCreate(
            ['doctor_photo_id' => $photoId],
            [
                'token'  => $token,
                'status' => ConsentStatus::PENDING,
            ]
        );

        if (!$consent->wasRecentlyCreated) {
            $consent->update([
                'token'  => $token,
                'status' => ConsentStatus::PENDING,
            ]);
        }

        // ✅ Записуємо згенероване посилання у масив за ключем photo_id
        $this->generatedLinks[$photoId] = route('consent.show', ['token' => $consent->token]);

        $this->loadPhotos(); // Перезавантажуємо список для актуальності статусів
        session()->flash('success', 'Посилання успішно згенеровано!');
    }

    public function hasPendingConsents(): bool
{
    return $this->photos->contains(function ($photo) {
        $status = $photo->photoConsent?->status?->value ?? $photo->photoConsent?->status;
        return $status === 'pending';
    });
}

    public function render()
    {
        return view('livewire.doctor.before-after');
    }
}