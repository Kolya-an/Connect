<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DoctorPhoto;
use Livewire\WithPagination;

class Photobank extends Component
{
    use WithPagination;
    public $initialPhotosByProcedure = [];
    public $selectedProcedure = null;
    public $isFiltered = false;
    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->loadInitialPhotos();
    }

    public function loadInitialPhotos()
    {
        // Загружаем только фото с list == true для начального отображения
        $photos = DoctorPhoto::with(['doctor.user'])
            ->where('list', true)
            ->get();

        // Группируем по процедуре
        $this->initialPhotosByProcedure = $photos->groupBy(function($item) {
            return $item->procedure ?? 'Без процедуры';
        })->toArray();
    }

    // Метод для фильтрации
    public function filterByProcedure($procedure)
    {
        $this->selectedProcedure = $procedure;
        $this->isFiltered = true;
        $this->resetPage(); // Сбрасываем пагинацию при фильтрации
    }

    // Метод для сброса фильтра
    public function resetFilter()
    {
        $this->selectedProcedure = null;
        $this->isFiltered = false;
        $this->resetPage();
    }

    public function render()
    {
        // Если фильтр не применен, показываем только начальные фото
        if (!$this->isFiltered) {
            return view('livewire.photobank', [
                'initialPhotosByProcedure' => $this->initialPhotosByProcedure,
                'paginatedPhotos' => collect([]), // Пустая коллекция
            ])->layout('livewire.pages.photobank');
        }

        // Если фильтр применен, показываем все фото с пагинацией
        $paginatedPhotos = DoctorPhoto::with(['doctor.user'])
            ->when($this->selectedProcedure, function($query) {
                $query->where('procedure', $this->selectedProcedure);
            })
            ->paginate(24); // Укажите нужное количество элементов на странице

        return view('livewire.photobank', [
            'initialPhotosByProcedure' => [],
            'paginatedPhotos' => $paginatedPhotos,
        ])->layout('livewire.pages.photobank');
    }
}
