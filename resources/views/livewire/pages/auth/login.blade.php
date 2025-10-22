<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>


<div style="width:100%">
    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <form wire:submit="login" id="login">
        <!-- Email Address -->
        <div class="search_field search_field_input">
            <x-text-input wire:model="form.email" id="email" class="search_field search_field_input" type="email" name="email"
                          placeholder="{{__('Ваш e-mail')}}"
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="search_field search_field_input">

            <x-text-input wire:model="form.password" id="password"
                            type="password"
                            name="password"
                            placeholder="{{__('Пароль')}}"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" />
        </div>

        <!-- Remember Me -->
        <label class="_flex-display _align-center more_filter_checkbox">
            <input wire:model="form.remember" id="check_discount" type="checkbox" name="remember">
            <span class="checkmark"></span>
            <span class="check_title">{{ __('Запам’ятати мене') }}</span>
        </label>
        <x-primary-button class="btn rose_btn">
            {{ __('Увійти') }}
        </x-primary-button>
    </form>
    <p class="or">{{ __('Або') }}</p>
    <a class="btn google_btn">{{__('Вхід за допомогою Google')}}</a>
    <a class="btn facebook_btn">{{__('Вхід за допомогою Facebook')}}</a>
    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" wire:navigate class="forgot_link">{{ __('Забули пароль?') }}</a>
    @endif
</div>
