<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class DoctorProfile extends Component
{
    public $user = [];
    public $user_id;
    public $doctor;
    public $step = 1;
    public $reviewsCount = 0;
    protected $queryString = [
        'step' => ['as' => 'tab', 'except' => 1],
        // 'except' => 1 означает, что tab=1 не будет отображаться в URL
    ];

    public function mount(User $id)
    {
        $this->user = $id;
        $this->user_id = $this->user->id;
        //$this->user->load('doctor.promotions');
        $id->load([
            'doctor' => function ($query) {
                $query->with('promotions')->withCount('reviews');
            }
        ]);
        $this->doctor = $this->user->doctor;
        //dd($this->doctor->reviews_count);
        $this->reviewsCount = $this->doctor->reviews_count ?? 0;
    }
    public function setStep($stepNumber)
    {
        $this->step = $stepNumber;
        if ($this->step === 2) {
            $this->dispatch('reinit-swipers');
        }
    }
    public function render()
    {
        return view('livewire.doctor-profile')->layout('doctor.view');

    }
}
