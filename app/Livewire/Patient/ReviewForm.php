<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Review;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class ReviewForm extends Component
{
    public $modal = false;

    public $appointmentId;
    public $text = '';
    public $medical = 5;
    public $service = 5;

    protected $rules = [
        'text' => 'required|min:3',
        'medical' => 'required|integer|min:1|max:5',
        'service' => 'required|integer|min:1|max:5',
    ];
    protected $listeners = [
        'open-review' => 'open'
    ];

    public function open($appointmentId)
    {
        $this->resetValidation();
        $this->appointmentId = $appointmentId;
        $this->text = '';
        $this->medical = 5;
        $this->service = 5;
        $this->modal = true;
    }

    public function close()
    {
        $this->modal = false;
    }

    public function submit()
    {
        $this->validate();

        Review::create([
            'appointment_id' => $this->appointmentId,
            'text' => $this->text,
            'medical' => $this->medical,
            'service' => $this->service,
        ]);

        $this->modal = false;

        session()->flash('success', 'Спасибо за ваш отзыв!');
    }

    public function render()
    {
        return view('livewire.patient.review-form');
    }
}
