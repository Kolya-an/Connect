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

        {{-- Отображение ошибки валидации --}}
        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <button class="btn rose_btn send_button" type="submit">
            {{__('Надіслати')}}
        </button>
    </form>
</div>
