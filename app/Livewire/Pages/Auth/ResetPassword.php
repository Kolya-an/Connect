<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('layouts.guest')]
class ResetPassword extends Component
{
    // Свойство, которое будет автоматически заполнено из URL-параметра
    public string $token;

    // Свойства для привязки к полям формы
    #[Rule(['required', 'email'])]
    public string $email = '';

    #[Rule(['required', 'string', 'min:8', 'confirmed'])]
    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Монтирование компонента при его инициализации
     *
     * @param string $token Токен сброса пароля из URL
     * @return void
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        // Попытка получить email из сессии, если он был сохранен после запроса сброса
        $this->email = request()->get('email', '');
    }

    /**
     * Сброс пароля.
     */
    public function resetPassword(): void
    {
        // 1. Валидация полей
        $this->validate();

        // Данные, необходимые для сброса
        $credentials = [
            'token' => $this->token,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];

        // 2. Вызов метода сброса пароля
        $status = Password::broker()->reset(
            $credentials,
            function ($user, $password) {
                // Установка нового пароля
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Оповещение о сбросе пароля
                event(new PasswordReset($user));

                // Автоматический вход пользователя
                Auth::guard()->login($user);
            }
        );

        // 3. Обработка статуса
        if ($status == Password::PASSWORD_RESET) {
            // Успех: перенаправление на главную (или куда-либо еще)
            // Используем navigate: true для Livewire-редиректа
            $this->redirect(route('home', absolute: false), navigate: true);
        } else {
            // Ошибка: отображение ошибки, используя исключение валидации
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }

    /**
     * Рендеринг представления.
     */
    public function render()
    {
        return view('livewire.pages.auth.reset-password');
    }
}
