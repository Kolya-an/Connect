<div class="container">
    <div class="_flex-display _justify-content-center _align-center select_cats">
        <button wire:click="setStep(1)" class="btn {{ $step === 1 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Крок 1: Особиста інформація')}}</button>
        <button wire:click="setStep(2)" class="btn {{ $step === 2 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Крок 2: Послуги')}}</button>
        <button wire:click="setStep(3)" class="btn {{ $step === 3 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Крок 3: Розклад')}}</button>
        <button wire:click="setStep(4)" class="btn {{ $step === 4 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Крок 4: Фото робіт - До/після')}}</button>
        <button wire:click="setStep(5)" class="btn {{ $step === 5 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Крок 5: Акції та знижки')}}</button>
    </div>
    @if($step === 1)
        <div class="spec_register_wrapper">
            <div class="_flex-display _justify-content-between spec_register1">
                <div class="spec_register1_left">
                    @livewire('doctor.avatar-upload')
                    @livewire('doctor.personal1')
                </div>
                <div class="spec_register1_right">
                    <h5>{{__('Ваша Спеціальність')}}</h5>
                    @livewire('doctor.type')
                    @livewire('doctor.doctor-education')
                    @livewire('doctor.extra')
                    @livewire('doctor.description')
                    <button wire:click="setStep(2)" class="rose_btn register_next">{{__('Далі')}}</button>
                </div>
            </div>
        </div>
    @elseif($step === 2)
        @livewire('doctor.doctor-services')
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(1)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a wire:click="setStep(3)" class="rose_btn register_next">{{__('Далі')}}</a>
        </div>
    @elseif($step === 3)
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(2)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a wire:click="setStep(4)" class="rose_btn register_next">{{__('Далі')}}</a>
        </div>
    @elseif($step === 4)
        @livewire('doctor.before-after')
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(3)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a wire:click="setStep(5)" class="rose_btn register_next">{{__('Далі')}}</a>
        </div>
    @elseif($step === 5)
        @livewire('doctor.promotions')
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(4)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a href="#" class="rose_btn register_next">{{__('Зберегти та перейти в особістий кабінет')}}</a>
        </div>
    @endif

</div>
