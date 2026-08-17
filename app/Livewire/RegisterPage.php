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
        $rules = [
            'name' => 'required|min:3',
            'second_name' => 'required|min:3',
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];



        /*if ($this->type === 'doctor') {
            $rules['specialization'] = 'required|min:2';
        }*/

        return $rules;
    }

    public function setType($type)
    {
        $this->type = $type;
        $this->resetValidation();
        $this->reset(['name', 'second_name', 'email', 'phone', 'password', 'password_confirmation']);
    }

    public function register()
    {
        $this->validate();

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
//dd($role);

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
    public function render()
    {
        return view('livewire.register-page');
    }
}
