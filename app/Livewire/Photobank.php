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

    public function mount()
    {
        $this->loadInitialPhotos();
    }

    public function loadInitialPhotos()
    {
        // Завантажуємо фото, де в photoConsent статус саме 'signed'
        $photos = DoctorPhoto::with(['doctor' => function ($query) {
                $query->withCount('reviews');
            }, 'doctor.user', 'photoConsent'])
            ->where('list', true)
            ->whereHas('photoConsent', function ($query) {
                $query->where('status', 'signed');
            })
            ->get();

        $this->initialPhotosByProcedure = $photos->groupBy(function($item) {
            return $item->procedure ?? 'Без процедури';
        })->toArray();
    }

    public function filterByProcedure($procedure)
    {
        $this->selectedProcedure = $procedure;
        $this->isFiltered = true;
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->selectedProcedure = null;
        $this->isFiltered = false;
        $this->resetPage();
    }

    public function render()
    {
        if (!$this->isFiltered) {
            return view('livewire.photobank', [
                'initialPhotosByProcedure' => $this->initialPhotosByProcedure,
                'paginatedPhotos' => collect([]),
            ])->layout('livewire.pages.photobank');
        }

        $paginatedPhotos = DoctorPhoto::with(['doctor.user', 'photoConsent'])
            ->whereHas('photoConsent', function ($query) {
                $query->where('status', 'signed');
            })
            ->when($this->selectedProcedure, function($query) {
                $query->where('procedure', $this->selectedProcedure);
            })
            ->paginate(24);

        return view('livewire.photobank', [
            'initialPhotosByProcedure' => [],
            'paginatedPhotos' => $paginatedPhotos,
        ])->layout('livewire.pages.photobank');
    }
}