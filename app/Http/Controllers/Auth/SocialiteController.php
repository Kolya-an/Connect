<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Pacient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * List of all official Socialite providers supported.
     * This list is used for validation and database field naming.
     */
    protected $officialProviders = [
        'google',
        'facebook',
    ];

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(string $provider, Request $request)
    {
        $role = $request->get('role', 'patient');

        // Валидируем роль
        if (!in_array($role, ['patient', 'doctor'])) {
            $role = 'patient';
        }

        session([
            'social_role' => $role
        ]);

        if (!in_array($provider, $this->officialProviders) || !config("services.{$provider}")) {
            // Abort if the provider is not supported or misconfigured
            abort(404, "Socialite provider {$provider} not supported or configured.");
        }

        // Redirect to the social provider's authorization page
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the OAuth Provider and handle login/creation.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(string $provider)
    {
        if (!in_array($provider, $this->officialProviders)) {
            abort(404);
        }

        try {
            // Retrieve the user from the social provider
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            // Handle exceptions (e.g., user denied access, invalid state/CSRF token)
            return redirect()->route('home')->withErrors(['email' => 'Authentication failed. Please try again or choose a different method.']);
        }

        // Centralized logic to find or create the user and assign the role
        $user = $this->findOrCreateUser($socialiteUser, $provider);

        // 🛑 Перевіряємо, чи акаунт активний (active === 1)
        if ((int) $user->active !== 1) {
            return redirect()->route('home')->withErrors([
                'email' => __('Ваш акаунт деактивовано або видалено.')
            ]);
        }

        // Log the user into the application
        Auth::login($user, true);
        return $this->redirectByRole($user);
    }

    protected function redirectByRole($user) // <-- ИЗМЕНИТЕ ЗДЕСЬ
    {
        switch ($user->role) {
            case 'doctor':
                return redirect()->route('doctor.dashboard');
            case 'patient':


                return redirect()->route('patient.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    /**
     * Finds user by provider ID or email, creates if necessary, and assigns 'subscriber' role using Spatie.
     *
     * @param SocialiteUser $socialiteUser
     * @param string $provider
     * @return User
     */
    protected function findOrCreateUser(SocialiteUser $socialiteUser, string $provider): User
    {
        $providerKey = str_replace('-', '_', $provider);
        $providerIdField = "{$providerKey}_id";

        // 1. Пошук користувача за Social ID або Email
        $user = User::where($providerIdField, $socialiteUser->getId())
            ->orWhere('email', $socialiteUser->getEmail())
            ->first();

        // Розподіл імені на частини
        $fullName = $socialiteUser->getName() ?? $socialiteUser->getNickname() ?? 'New Social User';
        list($firstName, $lastName) = $this->splitName($fullName);

        // 2. Якщо користувача знайдено
        if ($user) {
            // ❌ Забороняємо вхід, якщо акаунт неактивний (активовано видалення/active === 2)
            if ((int) $user->active !== 1) {
                throw new \Exception(__('Ваш акаунт деактивовано або видалено.'));
            }

            if (!$user->{$providerIdField}) {
                $user->update([
                    $providerIdField => $socialiteUser->getId(),
                ]);
            }

            return $user;
        }

        // 3. Користувач не існує, створюємо нового з active = 1
        $role = session('social_role', 'patient');

        $user = User::create([
            'name'              => $firstName,
            'email'             => $socialiteUser->getEmail(),
            'password'          => bcrypt(Str::random(24)),
            $providerIdField    => $socialiteUser->getId(),
            'email_verified_at' => now(),
            'role'              => $role,
            'active'            => 1, // <--- Явно вказуємо активний статус для нового користувача
        ]);

        // Створення пов'язаного запису
        if ($role == 'doctor') {
            Doctor::create([
                'user_id'     => $user->id,
                'second_name' => $lastName,
            ]);
        }

        if ($role == 'patient') {
            Pacient::create([
                'user_id'     => $user->id,
                'second_name' => $lastName,
            ]);
        }

        return $user;
    }

    /**
     * Attempts to split a full name string into first name and the rest (last name/patronymic).
     *
     * @param string $fullName
     * @return array [firstName, lastName]
     */
    protected function splitName(string $fullName): array
    {
        // Удаляем лишние пробелы по краям и внутри
        $fullName = trim(preg_replace('/\s+/', ' ', $fullName));

        $parts = explode(' ', $fullName);
        $firstName = $parts[0] ?? $fullName;

        // Вся остальная часть строки считается "фамилией"
        $lastName = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : '';

        return [
            $firstName, // Первая часть (Имя)
            $lastName   // Все остальное (Фамилия, Отчество и т.д.)
        ];
    }

}
