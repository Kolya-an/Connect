<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterPage extends Component
{
    public $type = 'patient'; // patient | doctor
    public bool $accept_terms = false;
    public bool $accept_politik = false;
    
    // Общие поля
    public $name;
    public $second_name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    

    // Только для доктора
    public $sex;
    public $city;
    public $experience;

    protected function rules()
{
    return [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'second_name' => ['required', 'string', 'min:3', 'max:255'],

        'phone' => [
            'required',
            'regex:/^\+380\d{9}$/',
        ],

        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email',
        ],

        'password' => [
            'required',
            'min:6',
            'confirmed',
        ],

        'accept_politik' => 'accepted', 
        'accept_terms' => 'accepted',
    ];
}

    public function setType($type)
    {
        $this->type = $type;
        $this->resetValidation();
        $this->reset(['name', 'second_name', 'email', 'phone', 'password', 'password_confirmation']);
    }

    public function register()
    {

    $this->phone = preg_replace('/[\s\-\(\)]/', '', $this->phone);

    if (str_starts_with($this->phone, '0')) {
        $this->phone = '+38' . $this->phone;
    }
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'second_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string'],
            'password' => ['required', 'min:6', 'confirmed'],
            'accept_politik' => ['accepted'],
            'accept_terms' => ['accepted'],
        ]);

        $role = $this->type === 'doctor' ? 'doctor' : 'patient';
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $role,
        ]);

        // При желании создаем связанные записи
        if ($role === 'doctor' && class_exists(\App\Models\Doctor::class)) {
            \App\Models\Doctor::create([
                'user_id' => $user->id,
                'second_name' => $this->second_name,
                'phone' => $this->phone,
                'sex' => $this->sex,
                'city' => $this->city,
                'experience' => $this->experience,
            ]);
        }

        if ($role === 'patient' && class_exists(\App\Models\Pacient::class)) {
            \App\Models\Pacient::create([
                'user_id' => $user->id,
                'second_name' => $this->second_name,
                'phone' => $this->phone,
            ]);
        }

        Auth::login($user);


        //return redirect()->route('home');
        return $this->redirectByRole(request(), $user);
    }

    protected function redirectByRole(Request $request,$user)
    {

        switch ($user->role) {
            case 'doctor': // Доктор
                return redirect()->route('doctor.dashboard');
            case 'patient': // Пациент
                if (session()->has('_previous.url')) {
                    return redirect(session('_previous.url'));
                }
                return redirect()->route('patient.dashboard');

            default:
                return redirect()->route('home');
        }
    }

    protected function messages()
{
    return [
        'name.required' => 'Введіть ім’я.',
        'name.min' => 'Ім’я повинно містити щонайменше 3 символи.',

        'second_name.required' => 'Введіть прізвище.',
        'second_name.min' => 'Прізвище повинно містити щонайменше 3 символи.',

        'phone.required' => 'Введіть номер телефону.',
        'phone.regex' => 'Введіть номер у форматі +380XXXXXXXXX.',

        'email.required' => 'Введіть e-mail.',
        'email.email' => 'Введіть коректну адресу e-mail.',
        'email.max' => 'E-mail занадто довгий.',
        'email.unique' => 'Користувач з таким e-mail вже зареєстрований.',

        'password.required' => 'Введіть пароль.',
        'password.min' => 'Пароль повинен містити щонайменше 6 символів.',
        'password.confirmed' => 'Паролі не співпадають.',
        
        'accept_politik.accepted' => 'Ви повинні прочитати та прийняти Політику приватності.',
        'accept_terms.accepted' => 'Ви повинні прийняти Умови використання.',
    ];
}

    public function render()
    {
        return view('livewire.register-page');
    }
}
