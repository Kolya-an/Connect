<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use App\Models\HomepageSetting;
use App\Models\News;
use App\Models\Doctor;

class Homepage extends Component
{
    public $settings;
    public $news;
    public $service_form;
    public $service_block;
    public $doctor;
    public $doctors;
    public $promotion;
    public $doctors_ids;
    public function mount()
    {
        $this->settings = HomepageSetting::with([
            'promotion.doctor' => function ($query) {
                $query->withCount('reviews'); // создаёт reviews_count
            },
            'promotion.doctor.user',
        ])->first();

        $this->promotion = $this->settings->promotion;

        if (!$this->settings) {
            $this->settings = null;
            $this->news = collect();
            $this->service_form = collect();
            $this->service_block = collect();
            $this->doctor = null;
            $this->doctors_ids = collect();
            $this->promotion = null;
            return;
        }

        // Определяем, какие новости выводить
        switch ($this->settings->news_display_type) {
            case 'featured':
                $this->news = News::where('is_featured', true)
                    ->take($this->settings->news_limit ?? 5)
                    ->get();
                break;

            case 'manual':
                $this->news = News::whereIn('id', $this->settings->manual_news_ids ?? [])
                    ->get();
                break;

            case 'latest':
            default:
                $this->news = News::latest()
                    ->take($this->settings->news_limit ?? 5)
                    ->get();
                break;
        }
        switch ($this->settings->service_display_type) {
            case 'manual':
                $this->service_form = Service::whereIn('id', $this->settings->manual_service_ids ?? [])
                    ->get();
                break;

            case 'latest':
            default:
                $this->news = Service::latest()
                    ->take($this->settings->service_limit ?? 5)
                    ->get();
                break;
        }
        switch ($this->settings->procedure_display_type) {
            case 'manual':
                $this->service_block = Service::whereIn('id', $this->settings->manual_procedure_ids ?? [])
                    ->get();
                break;

            case 'latest':
            default:
                $this->service_block = Service::latest()
                    ->take($this->settings->procedure_limit ?? 5)
                    ->get();
                break;
        }
        //$this->doctor = Doctor::with('services')->find($this->settings->doctor_id);
        try {
            $this->doctor = Doctor::with('services')
                ->withCount('reviews')
                ->find($this->settings->doctor_id);
        } catch (\Throwable $e) {
            //dd($e->getMessage(), $e->getTraceAsString());
        }
        $this->doctors_ids = $this->settings && !empty($this->settings->doctors_ids)
            ? array_map('intval', $this->settings->doctors_ids)
            : [];




// Загружаем докторов с услугами, если есть хотя бы один ID
        $this->doctors = $this->doctors_ids
            ? Doctor::with('services')
                ->withCount('reviews')
                ->whereIn('id', $this->doctors_ids)->get()
            : collect();

        $this->promotion = $this->settings->promotion;
    }
    public function render()
    {
        return view('livewire.homepage')->layout('home.index');
    }
}
