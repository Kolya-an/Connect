<div style="width:100%">
    <h2>{{ __('Встановити новий пароль') }}</h2>

    <form wire:submit.prevent="resetPassword">

        <input type="hidden" name="token" value="{{ $token }}">

            <x-text-input wire:model="email" id="email" type="hidden" name="email"/>

        <div class="search_field search_field_input" style="padding:8px 16px;margin-bottom: 10px">
            <input wire:model="password" id="password"
                          type="password"
                          name="password"
                          style="border:0 none"
                          placeholder="{{ __('Новий пароль') }}"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="search_field search_field_input" style="padding:8px 16px;margin-bottom: 10px">
            <input wire:model="password_confirmation" id="password_confirmation"
                          type="password"
                          name="password_confirmation"
                          style="border:0 none"
                          placeholder="{{ __('Підтвердження пароля') }}"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="btn rose_btn">
            {{ __('Скинути пароль') }}
        </x-primary-button>
    </form>
</div>
