<?php

namespace App\Livewire\Doctor;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Database\QueryException;

class DoctorServices extends Component
{
    public $doctor;
    public $services= [];
    public $allServices = [];
    public $service_id;
    public $prefix = 'for';
    public $price;
    public $name;

    public $showAddModal = false;
    public $showCreateModal = false;
    public $showEditModal = false;

    public $editServiceId;

    protected $rules = [
        'price' => 'required|numeric|min:0',
        'name' => 'required|string|max:255',
        'prefix' => 'nullable|string|max:10',
    ];

    public function mount()
    {
        // Берём текущего доктора, связанного с авторизованным пользователем
        $this->doctor = Auth::user()->doctor;

        if (! $this->doctor) {
            abort(403, 'Доступ дозволено лише для лікарів.');
        }

        $this->refreshServices();
    }

    public function refreshServices()
    {
        // Используем get() для получения коллекции
        $this->services = $this->doctor->services()
            ->withPivot('price', 'prefix')
            ->get()
            ->toArray(); // Преобразуем в массив для безопасности

        // Получаем только те услуги, которые еще не привязаны к доктору
        $attachedServiceIds = collect($this->services)->pluck('id')->toArray();
        $this->allServices = Service::whereNotIn('id', $attachedServiceIds)
            ->get()
            ->toArray(); // Преобразуем в массив
    }

    public function openAddModal()
    {
        $this->reset(['service_id', 'prefix', 'price']);
        $this->resetErrorBag();
        $this->prefix = 'for';
        $this->showAddModal = true;
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'prefix', 'price']);
        $this->resetErrorBag();
        $this->prefix = 'for';
        $this->showCreateModal = true;
    }

    public function addServiceToDoctor()
    {
        $this->validate([
            'service_id' => 'required|exists:services,id',
            'prefix' => 'nullable|string|max:10',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            // Проверяем, не привязана ли уже эта услуга
            $existing = $this->doctor->services()
                ->where('service_id', $this->service_id)
                ->exists();

            if ($existing) {
                throw new \Exception('Ця послуга вже додана до вашого списку.');
            }

            $this->doctor->services()->attach($this->service_id, [
                'price' => $this->price,
                'prefix' => $this->prefix,
            ]);

            $this->showAddModal = false;
            $this->refreshServices();
            session()->flash('message', 'Послугу успішно додано!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('error', 'Ця послуга вже додана до вашого списку.');
            } else {
                session()->flash('error', 'Помилка при додаванні послуги: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Помилка: ' . $e->getMessage());
        }
    }

    public function createServiceAndAttach()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'prefix' => 'nullable|string|max:10',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () {
                // Создаем новую услугу
                $service = Service::create([
                    'name' => $this->name,
                ]);

                // Привязываем к доктору
                $this->doctor->services()->attach($service->id, [
                    'price' => $this->price,
                    'prefix' => $this->prefix,
                ]);
            });

            $this->showCreateModal = false;
            $this->refreshServices();
            session()->flash('message', 'Власну послугу успішно створено та додано!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('error', 'Помилка: така послуга вже існує.');
            } else {
                session()->flash('error', 'Помилка при створенні послуги: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Помилка при створенні послуги: ' . $e->getMessage());
        }
    }

    public function openEditModal($serviceId)
    {
        try {
            $service = $this->doctor->services()
                ->where('services.id', $serviceId)
                ->withPivot('price', 'prefix')
                ->first();

            if (!$service) {
                session()->flash('error', 'Послугу не знайдено або вона не належить цьому доктору.');
                return;
            }

            $this->editServiceId = $serviceId;
            $this->name = $service->name;
            $this->prefix = $service->pivot->prefix ?? 'for';
            $this->price = $service->pivot->price;
            $this->showEditModal = true;

        } catch (\Exception $e) {
            session()->flash('error', 'Помилка при відкритті редагування: ' . $e->getMessage());
        }
    }

    public function updateService()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'nullable|string|max:10',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () {
                $service = Service::find($this->editServiceId);

                if (!$service) {
                    throw new \Exception('Послугу не знайдено.');
                }

                // Альтернативный способ проверки через pivot таблицу
                $usedByOtherDoctors = DB::table('doctor_service')
                    ->where('service_id', $this->editServiceId)
                    ->where('doctor_id', '!=', $this->doctor->id)
                    ->exists();

                if (!$usedByOtherDoctors) {
                    // Обновляем название только если услуга не используется другими
                    $service->update(['name' => $this->name]);

                    // Обновляем связь в pivot таблице
                    $this->doctor->services()->updateExistingPivot($this->editServiceId, [
                        'price' => $this->price,
                        'prefix' => $this->prefix,
                    ]);
                } else {
                    // Если используется другими - создаем новую услугу
                    $newService = Service::create(['name' => $this->name]);
                    $this->doctor->services()->detach($this->editServiceId);
                    $this->doctor->services()->attach($newService->id, [
                        'price' => $this->price,
                        'prefix' => $this->prefix,
                    ]);
                    $this->editServiceId = $newService->id;
                }
            });

            $this->showEditModal = false;
            $this->refreshServices();
            session()->flash('message', 'Послугу успішно оновлено!');

        } catch (\Exception $e) {
            session()->flash('error', 'Помилка при оновленні послуги: ' . $e->getMessage());
        }
    }

    public function deleteService($serviceId)
    {
        try {
            $this->doctor->services()->detach($serviceId);
            $this->refreshServices();
            session()->flash('message', 'Послугу успішно видалено!');

        } catch (\Exception $e) {
            session()->flash('error', 'Помилка при видаленні послуги: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.doctor.doctor-services');
    }
}
