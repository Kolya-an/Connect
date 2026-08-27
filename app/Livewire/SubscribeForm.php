<?php

namespace App\Livewire;

use Livewire\Component;

class SubscribeForm extends Component
{
    // Публичное свойство для хранения значения поля email
    public string $email = '';
    public bool $accept_politik = false;

    // Публичное свойство для сообщения об успехе
    public ?string $successMessage = null;

    /**
     * Правила валидации
     */
    protected $rules = [
        'email' => 'required|email|unique:subscribers,email', // Проверьте, что таблица называется 'subscribers'
    ];

    /**
     * Метод, вызываемый при отправке формы
     */
    public function subscribe()
    {
        // 1. Валидация данных
        $this->validate();

        try {
            // 2. Сохранение email в базе данных
            // Предполагается, что у вас есть модель Subscriber и соответствующая таблица 'subscribers'
            \App\Models\Subscriber::create([
                'email' => $this->email,
            ]);

            // 3. Сброс поля и установка сообщения об успехе
            $this->reset('email');
            $this->successMessage = __('Вы успешно подписались на новости!'); // Используйте локализацию

        } catch (\Exception $e) {
            // Можно добавить логирование ошибки
            $this->addError('email', __('Произошла ошибка при подписке. Попробуйте позже.'));
        }
    }

    public function render()
    {
        return view('livewire.subscribe-form');
    }
}
