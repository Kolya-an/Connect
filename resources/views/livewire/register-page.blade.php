<div>
    <div class="_flex-display _align-center form_spec_client">
        <span>Ви:</span>
        <button wire:click="setType('patient')" class="btn {{ $type === 'doctor' ? 'white_rose_btn reg_doc_btn' : 'rose_btn reg_pac_btn' }}">Клієнт</button>
        <button wire:click="setType('doctor')" class="btn {{ $type === 'patient' ? 'white_rose_btn reg_pac_btn' : 'rose_btn reg_doc_btn' }}">Спеціаліст</button>
    </div>
    <form wire:submit.prevent="register" id="register_doctor" class="_flex-display _justify-content-between _align-center">
        <div class="search_field search_field_input">
            <x-text-input wire:model="name" type="text"
                          placeholder="{{__('Ваше ім’я')}}"
                          required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 error-message" />
        </div>
        <div class="search_field search_field_input">
            <x-text-input wire:model="second_name" type="text"
                          placeholder="{{__('Ваше прізвище')}}"
                          required autocomplete="second_name" />
            <x-input-error :messages="$errors->get('second_name')" class="mt-2 error-message" />
        </div>
        <div class="search_field search_field_input">
            <x-text-input wire:model="email" type="email"
                          placeholder="{{__('Ваш e-mail')}}"
                          required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 error-message" />
        </div>
        <div class="search_field search_field_input">
            <x-text-input wire:model="phone" type="tel"
                          placeholder="{{__('Ваш номер телефону')}}"
                          required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2 error-message" />
        </div>
        @if($type === 'doctor')
            <div class="search_field search_field_sex">
                <select wire:model="sex" id="search_sex" class="search_sex">
                    <option value="">{{__('Ваша стать')}}</option>
                    <option value="male">{{__('Чоловік')}}</option>
                    <option value="female">{{__('Жінка')}}</option>
                </select>
            </div>
        @endif
        <div class="search_field search_field_input">
            <x-text-input wire:model="password"
                          type="password"
                          name="password"
                          placeholder="{{__('Ваш пароль')}}"
                          required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="error-message" />
        </div>

        <div class="search_field search_field_input">
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                          type="password" placeholder="{{__('Повторіть пароль')}}"
                          name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 error-message" />
        </div>

        <label class="_flex-display _align-center more_filter_checkbox" style="margin-bottom: 10px;">
            <input wire:model.live="accept_politik" id="check_politik" type="checkbox" name="check_politik" class="form-check-input @error('accept_politik') is-invalid @enderror">
            <span class="checkmark"></span>
            <span class="check_title">{{__('Я прочитав(ла)')}} <a target="_blank" href="{{ asset('doc/personal.pdf') }}">{{__('Політику приватності')}}</a></span>
            @error('accept_politik')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </label>

        <label class="_flex-display _align-center more_filter_checkbox" style="margin-bottom: 10px;">
            <input wire:model.live="accept_terms" id="check_terms" type="checkbox" name="check_terms" class="form-check-input @error('accept_terms') is-invalid @enderror">
            <span class="checkmark"></span>
            <span class="check_title">{{__('Я прочитав(ла) та приймаю')}} <a target="_blank" href="{{ asset('doc/' . ($type === 'doctor' ? 'umovi_doc' : 'umovi_user') . '.pdf') }}">{{__('Умови використання')}}</a></span>
            @error('accept_terms')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </label>

        <!-- Кнопка реєстрації блокується, якщо НЕ обрано хоча б один чекбокс -->
        <x-primary-button class="btn rose_btn" :disabled="!$accept_politik || !$accept_terms">
            {{ __('Зареєструватись') }}
        </x-primary-button>
    </form>

    <p class="or">{{ __('Або') }}</p>

    <!-- Кнопки соціальних мереж з атрибутом disabled та перевіркою через pointer-events -->
    @php
        $isAgreementAccepted = $accept_politik && $accept_terms;
        $roleParam = $type === 'doctor' ? 'doctor' : 'patient';
    @endphp

    <a href="{{ $isAgreementAccepted ? route('social.redirect', 'google') . '?role=' . $roleParam : 'javascript:void(0)' }}" 
       class="btn google_btn {{ !$isAgreementAccepted ? 'disabled' : '' }}"
       @if(!$isAgreementAccepted) tabindex="-1" aria-disabled="true" style="pointer-events: none; opacity: 0.6;" @endif>
        {{__('Вхід за допомогою Google')}}
    </a>

    <a href="{{ $isAgreementAccepted ? route('social.redirect', 'facebook') . '?role=' . $roleParam : 'javascript:void(0)' }}" 
       class="btn facebook_btn {{ !$isAgreementAccepted ? 'disabled' : '' }}"
       @if(!$isAgreementAccepted) tabindex="-1" aria-disabled="true" style="pointer-events: none; opacity: 0.6;" @endif>
        {{__('Вхід за допомогою Facebook')}}
    </a>
</div>