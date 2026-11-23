<?php

namespace App\Livewire;

use Livewire\Component;

class SubscribeForm extends Component
{
    public string $email = '';
    public bool $accept_politik = false;
    public ?string $successMessage = null;

    protected $rules = [
        'email' => 'required|email|unique:subscribers,email',
        'accept_politik' => 'accepted', // Обов'язкове правило для чекбокса згоди
    ];

    protected function messages()
    {
        return [
            'accept_politik.accepted' => 'Ви повинні прочитати та прийняти Політику приватності.',
        ];
    }

    public function subscribe()
    {
        $this->validate();

        try {
            \App\Models\Subscriber::create([
                'email' => $this->email,
            ]);

            $this->reset(['email', 'accept_politik']); // Скидаємо також чекбокс після успіху
            $this->successMessage = __('Ви успішно підписалися на новини!');

        } catch (\Exception $e) {
            $this->addError('email', __('Сталася помилка під час передплати. Спробуйте пізніше.'));
        }
    }

    public function render()
    {
        return view('livewire.subscribe-form');
    }
}