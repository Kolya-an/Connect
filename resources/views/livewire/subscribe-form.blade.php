<div>

    <form wire:submit.prevent="subscribe">
        <input
            type="email"
            class="subscribe_email @error('email') is-invalid @enderror"
            placeholder="E-mail"
            wire:model.live="email"
        >
        
        {{-- Отображение ошибки email --}}
        @error('email')
            <span class="error">{{ $message }}</span>
        @enderror

        <div style="margin-top: 10px; margin-bottom: 10px;">
            <label class="_flex-display _align-center more_filter_checkbox">
                <input wire:model.live="accept_politik" id="check_politik" type="checkbox" name="check_politik" class="form-check-input @error('accept_politik') is-invalid @enderror">
                <span class="checkmark"></span>
                <span class="check_title">{{__('Я прочитав(ла)')}} <a target="_blank" href="{{ asset('doc/personal.pdf') }}">{{__('Політику приватності')}}</a></span>
            </label>

            {{-- Отображение ошибки accept_politik --}}
            @error('accept_politik')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Виведення повідомлення про успіх (якщо є) --}}
        @if ($successMessage)
            <div class="success" style="color: green; margin-bottom: 10px;">{{ $successMessage }}</div>
        @endif

        {{-- Прибрано @disabled, щоб валідація спрацьовувала при спробі відправки без галочки --}}
        <button class="btn rose_btn send_button" type="submit">
            {{__('Надіслати')}}
        </button>
    </form>
    <script>
        const emailInput = document.querySelector('input[type="email"]');

        if (emailInput) {
            emailInput.addEventListener('invalid', function() {
                if (this.validity.typeMismatch || this.validity.valueMissing || this.value.startsWith('@')) {
                    this.setCustomValidity('Будь ласка, введіть повну адресу електронної пошти (наприклад, name@gmail.com).');
                }
            });

            emailInput.addEventListener('input', function() {
                this.setCustomValidity(''); // Очищаємо помилку при введенні
            });
        }
    </script>
</div>
