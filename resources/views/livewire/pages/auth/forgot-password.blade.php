<div style="width:100%">
    <h2>{{ __('Відновлення пароля') }}</h2>
    <p>{{ __('Забули пароль? Чи не біда. Просто повідомте нам свою адресу електронної пошти, і ми надішлемо вам посилання для скидання пароля.') }}</p>

    <x-auth-session-status :status="session('status')" />

    <form wire:submit.prevent="sendResetLink">
        <div class="search_field search_field_input" style="padding:8px 16px;margin-bottom: 10px">
            <input wire:model="email" id="email" type="email" name="email"
                   style="border:0 none"
                  placeholder="{{ __('Ваш e-mail') }}"
                  required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="btn rose_btn">
            {{ __('Відправити посилання для заміни паролю') }}
        </x-primary-button>
    </form>
</div>
