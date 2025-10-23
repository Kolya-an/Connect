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
            <x-input-error :messages="$errors->get('name')" class="mt-2" class="error-message" />
        </div>
        <div class="search_field search_field_input">
            <x-text-input wire:model="second_name" type="text"
                          placeholder="{{__('Ваше прізвище')}}"
                          required autocomplete="second_name" />
            <x-input-error :messages="$errors->get('second_name')" class="mt-2" class="error-message" />
        </div>
        <div class="search_field search_field_input">
            <x-text-input wire:model="email" type="email"
                          placeholder="{{__('Ваш e-mail')}}"
                          required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" class="error-message" />
        </div>
        <div class="search_field search_field_input">
            {{--<input wire:model="phone" type="tel" placeholder="{{__('Ваш номер телефону')}}">
            @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror--}}
            <x-text-input wire:model="phone" type="tel"
                          placeholder="{{__('Ваш номер телефону')}}"
                          required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" class="error-message" />
        </div>
        @if($type === 'doctor')
            <div class="search_field search_field_sex">
                <select wire:model="sex" id="search_sex" class="search_sex">
                    <option value="">Ваша стать</option>
                    <option value="male">Чоловік</option>
                    <option value="female">Жінка</option>
                    <option value="nonbinary">Небінарна особистість</option>
                </select>
            </div>
            <div class="search_field search_field_city">
                <select wire:model="city" id="search_city" class="search_city">
                    <option value="Київ">Київ</option>
                </select>
            </div>
            <div class="search_field search_field_experience">
                <select wire:model="experience" id="search_experience" class="search_experience">
                    <option value="">Досвід</option>
                    <option value="1">1</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                </select>
            </div>
        @endif
        <div class="search_field search_field_input">
            {{--<input type="password" wire:model="password" placeholder="{{__('Ваш пароль')}}">
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror--}}
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

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" class="error-message" />
            </div>
            <label class="_flex-display _align-center more_filter_checkbox">
                <input wire:model="accept_terms" id="check_discount" type="checkbox" name="discount" class="form-check-input @error('accept_terms') is-invalid @enderror">
                <span class="checkmark"></span>
                <span class="check_title">Я приймаю <a href="#">правила сайту</a></span>
               @error('accept_terms')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror

            </label>


        <x-primary-button class="btn rose_btn">
            {{ __('Зареєструватись') }}
        </x-primary-button>
    </form>
    @if($type === 'doctor')
        <p class="or">{{ __('Або') }}</p>
        <a href="{{ route('social.redirect', 'google') }}?role=doctor" class="btn google_btn">{{__('Вхід за допомогою Google')}}</a>
        <a href="{{ route('social.redirect', 'facebook') }}?role=doctor" class="btn facebook_btn">{{__('Вхід за допомогою Facebook')}}</a>
    @else
        <p class="or">{{ __('Або') }}</p>
        <a href="{{ route('social.redirect', 'google') }}?role=patient" class="btn google_btn">{{__('Вхід за допомогою Google')}}</a>
        <a href="{{ route('social.redirect', 'facebook') }}?role=patient" class="btn facebook_btn">{{__('Вхід за допомогою Facebook')}}</a>
    @endif
</div>
