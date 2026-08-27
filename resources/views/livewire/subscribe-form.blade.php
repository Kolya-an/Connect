<div>
    @if ($successMessage)
        <div class="alert alert-success">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit.prevent="subscribe">
        <input
            type="email"
            class="subscribe_email @error('email') is-invalid @enderror"
            placeholder="E-mail"
            wire:model.live="email" {{-- Привязка к свойству $email с обновлением при каждом вводе --}}
        >
        <label class="_flex-display _align-center more_filter_checkbox" style="margin-bottom: 10px;">
            <input wire:model.live="accept_politik" id="check_politik" type="checkbox" name="check_politik" class="form-check-input @error('accept_politik') is-invalid @enderror">
            <span class="checkmark"></span>
            <span class="check_title">{{__('Я прочитав(ла)')}} <a target="_blank" href="{{ asset('doc/personal.pdf') }}">{{__('Політику приватності')}}</a></span>
            @error('accept_politik')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </label>

        {{-- Отображение ошибки валидации --}}
        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <button class="btn rose_btn send_button" type="submit" @disabled(!$accept_politik)>
            {{__('Надіслати')}}
        </button>
    </form>
</div>
