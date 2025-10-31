<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\DoctorPromotion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class Promotions extends Component
{
    public $promotions = [];
    public $showModal = false;
    public $editingId = null;

    // поля формы
    public $title;
    public $description;
    public $old_price;
    public $new_price;
    public $date_from;
    public $date_to;

    public function mount()
    {
        $this->loadPromotions();
    }

    protected function getDoctor()
    {
        $user = Auth::user();
        if (!$user) {
            throw new Exception('User not authenticated');
        }

        // Если у вас связь называется иначе — поправьте
        if (!method_exists($user, 'doctor') && !property_exists($user, 'doctor')) {
            throw new Exception('Relation "doctor" not found on User model');
        }

        $doctor = $user->doctor;
        if (!$doctor) {
            throw new Exception('Doctor profile not found for current user');
        }

        return $doctor;
    }

    public function loadPromotions()
    {
        try {
            $doctor = $this->getDoctor();
            $this->promotions = DoctorPromotion::where('doctor_id', $doctor->id)
                ->orderBy('date_to', 'desc')
                ->get();
        } catch (Exception $e) {
            // логируем и показываем сообщение
            logger()->error('Load promotions error: '.$e->getMessage());
            session()->flash('error', 'Не вдалося завантажити акції: '.$e->getMessage());
            $this->promotions = collect();
        }
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        try {
            $promo = DoctorPromotion::findOrFail($id);
            $this->editingId = $promo->id;
            $this->title = $promo->title;
            $this->description = $promo->description;
            $this->old_price = $promo->old_price;
            $this->new_price = $promo->new_price;
            $this->date_from = $promo->date_from ? $promo->date_from->format('Y-m-d') : null;
            $this->date_to = $promo->date_to ? $promo->date_to->format('Y-m-d') : null;
            $this->showModal = true;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Акцію не знайдено');
        } catch (Exception $e) {
            logger()->error('Open edit modal error: '.$e->getMessage());
            session()->flash('error', 'Сталася помилка при відкритті редагування');
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'old_price' => 'nullable|numeric',
            'new_price' => 'nullable|numeric',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ], [
            'title.required' => 'Назва обовʼязкова',
            'date_to.after_or_equal' => 'Дата завершення повинна бути пізніше або рівна даті початку',
        ]);

        try {
            $doctor = $this->getDoctor();

            if ($this->editingId) {
                $promo = DoctorPromotion::find($this->editingId);
                if (!$promo) {
                    session()->flash('error', 'Акцію не знайдено для оновлення');
                    $this->showModal = false;
                    return;
                }
                $promo->update([
                    'title' => $this->title,
                    'description' => $this->description,
                    'old_price' => $this->old_price,
                    'new_price' => $this->new_price,
                    'date_from' => $this->date_from,
                    'date_to' => $this->date_to,
                ]);
                session()->flash('message', 'Акцію оновлено');
            } else {
                DoctorPromotion::create([
                    'doctor_id' => $doctor->id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'old_price' => $this->old_price,
                    'new_price' => $this->new_price,
                    'date_from' => $this->date_from,
                    'date_to' => $this->date_to,
                ]);
                session()->flash('message', 'Акцію створено');
            }

            $this->showModal = false;
            $this->resetForm();
            $this->loadPromotions();
        } catch (Exception $e) {
            logger()->error('Save promotion error: '.$e->getMessage());
            session()->flash('error', 'Помилка при збереженні: '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $promo = DoctorPromotion::find($id);
            if ($promo) {
                $promo->delete();
                session()->flash('message', 'Акцію видалено');
            } else {
                session()->flash('error', 'Акцію не знайдено');
            }
            $this->loadPromotions();
        } catch (Exception $e) {
            logger()->error('Delete promotion error: '.$e->getMessage());
            session()->flash('error', 'Помилка при видаленні: '.$e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->title = $this->description = $this->old_price = $this->new_price = $this->date_from = $this->date_to = null;
    }
    public function render()
    {
        return view('livewire.doctor.promotions');
    }
}
