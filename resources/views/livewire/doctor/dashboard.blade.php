<div class="container">
    <div class="_flex-display _justify-content-center _align-center select_cats">
        <button wire:click="setStep(1)" class="btn {{ $step === 1 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Особиста інформація')}}</button>
        <button wire:click="setStep(2)" class="btn {{ $step === 2 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Процедури')}}</button>
        <button wire:click="setStep(3)" class="btn {{ $step === 3 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Графік роботи')}}</button>
        <button wire:click="setStep(4)" class="btn {{ $step === 4 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Мої записи')}}</button>
        <button wire:click="setStep(5)" class="btn {{ $step === 5 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Пацієнти')}}</button>
        <button wire:click="setStep(6)" class="btn {{ $step === 6 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Фото')}}</button>
        <button wire:click="setStep(7)" class="btn {{ $step === 7 ? 'rose_btn' : 'white_rose_btn' }}">{{__('Акції та знижки')}}</button>
        <a href="https://t.me/+380998402441" target="_blank" class="btn white_rose_btn">{{__('Підтримка')}}</a>
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
                    @livewire('doctor.passport')
                    @livewire('doctor.doctor-education')
                    @livewire('doctor.extra')
                    @livewire('doctor.licensy')
                    @livewire('doctor.share')
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
        @livewire('doctor.appointments')
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(2)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a wire:click="setStep(4)" class="rose_btn register_next">{{__('Далі')}}</a>
        </div>
    @elseif($step === 4)
        @livewire('doctor.my-appointments', ['doctorId' => $doctorId])
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(3)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a wire:click="setStep(5)" class="rose_btn register_next">{{__('Далі')}}</a>
        </div>
    @elseif($step === 5)
        @livewire('doctor.patients', ['doctorId' => $doctorId])
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(4)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a wire:click="setStep(6)" class="rose_btn register_next">{{__('Далі')}}</a>
        </div>
    @elseif($step === 6)
        @livewire('doctor.before-after')
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(5)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a wire:click="setStep(7)" class="rose_btn register_next">{{__('Далі')}}</a>
        </div>
    @elseif($step === 7)
        @livewire('doctor.promotions')
        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(6)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            <a href="/doctors/{{Auth::id()}}" class="rose_btn register_next" target="_blank">{{__('Подивитися сторінку')}}</a>
        </div>
    @elseif($step === 8)

        <div class="_flex-display _align-center spec_register_buttons">
            <a wire:click="setStep(7)" class="white_rose_btn register_prev">{{__('Назад')}}</a>
            {{--<a href="#" class="rose_btn register_next">{{__('Перейти в особістий кабінет')}}</a>--}}
        </div>
    @endif
     <!-- МОДАЛЬНЕ ВІКНО ЗГОДИ -->
    @if($agreeModalVisible)
        <div id="add_agree" class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_agree_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Надайте згоду')}}</h4>
                    <div wire:click="closeAgreeModal" id="window_close" class="window_close cursor-pointer">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none">
                            <rect width="48" height="48" rx="24" fill="rgb(255,225,228)" />
                            <path d="M24.0009 25.6333L18.2842 31.3499C18.0704 31.5638 17.7981 31.6708 17.4676 31.6708C17.137 31.6708 16.8648 31.5638 16.6509 31.3499C16.437 31.136 16.3301 30.8638 16.3301 30.5333C16.3301 30.2027 16.437 29.9305 16.6509 29.7166L22.3676 23.9999L16.6509 18.2833C16.437 18.0694 16.3301 17.7972 16.3301 17.4666C16.3301 17.136 16.437 16.8638 16.6509 16.6499C16.8648 16.436 17.137 16.3291 17.4676 16.3291C17.7981 16.3291 18.0704 16.436 18.2842 16.6499L24.0009 22.3666L29.7176 16.6499C29.9315 16.436 30.2037 16.3291 30.5342 16.3291C30.8648 16.3291 31.137 16.436 31.3509 16.6499C31.5648 16.8638 31.6717 17.136 31.6717 17.4666C31.6717 17.7972 31.5648 18.0694 31.3509 18.2833L25.6342 23.9999L31.3509 29.7166C31.5648 29.9305 31.6717 30.2027 31.6717 30.5333C31.6717 30.8638 31.5648 31.136 31.3509 31.3499C31.137 31.5638 30.8648 31.6708 30.5342 31.6708C30.2037 31.6708 29.9315 31.5638 29.7176 31.3499L24.0009 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </svg>
                    </div>
                </div>
                <div class="spec_register1_right_block" style="margin:0">
                    <p class="client_address" style="margin:0 0 10px 0">
                        {{__('Я надаю згоду на обробку моїх даних, що стосуються здоров’я, у межах функціоналу медичного запису платформи, включно із зберіганням відомостей про проведені процедури, використані препарати, рекомендації та іншої інформації, необхідної для ведення моєї історії процедур') }}
                    </p>
                    <button 
                        type="button" 
                        wire:click.prevent="agreeDoctorHistory" 
                        class="white_rose_btn register_prev" 
                        style="width:100%"
                    >
                        {{__('Підтвердити та відправити')}}
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if(!$modalAgree)
        <div class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_info_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Я погоджуюся')}}</h4>
                    <div wire:click="closeAgree" id="window_close" class="window_close cursor-pointer">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none">
                            <rect width="48" height="48" rx="24" fill="rgb(255,225,228)" />
                            <path d="M24.0009 25.6333L18.2842 31.3499C18.0704 31.5638 17.7981 31.6708 17.4676 31.6708C17.137 31.6708 16.8648 31.5638 16.6509 31.3499C16.437 31.136 16.3301 30.8638 16.3301 30.5333C16.3301 30.2027 16.437 29.9305 16.6509 29.7166L22.3676 23.9999L16.6509 18.2833C16.437 18.0694 16.3301 17.7972 16.3301 17.4666C16.3301 17.136 16.437 16.8638 16.6509 16.6499C16.8648 16.436 17.137 16.3291 17.4676 16.3291C17.7981 16.3291 18.0704 16.436 18.2842 16.6499L24.0009 22.3666L29.7176 16.6499C29.9315 16.436 30.2037 16.3291 30.5342 16.3291C30.8648 16.3291 31.137 16.436 31.3509 16.6499C31.5648 16.8638 31.6717 17.136 31.6717 17.4666C31.6717 17.7972 31.5648 18.0694 31.3509 18.2833L25.6342 23.9999L31.3509 29.7166C31.5648 29.9305 31.6717 30.2027 31.6717 30.5333C31.6717 30.8638 31.5648 31.136 31.3509 31.3499C31.137 31.5638 30.8648 31.6708 30.5342 31.6708C30.2037 31.6708 29.9315 31.5638 29.7176 31.3499L24.0009 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </svg>
                     </div>
                 </div>
                 
                
                 <div class="_flex-display _justify-content-center _align-center">
                     <div class="_flex-display _align-center spec_register_buttons">
                        <label class="_flex-display _align-top more_filter_checkbox" style="flex-wrap: nowrap;">
                   
                            <input id="doc_agree" type="checkbox" wire:model.live="doc_agree">
                            <span class="checkmark"></span>
                            <span class="check_title" style="width: calc(100% - 30px);">{{ __('отримувати повідомлення про нові сервіси, персональні знижки, добірки фахівців та новини платформи (через email, SMS, push).') }}</span>
                        </label>
                         <button 
                             type="button" 
                             wire:click="saveAgree" 
                             class="rose_btn register_prev" 
                             @disabled(!$doc_agree)
                         >
                             {{__('Підтвердити та відправити')}}
                         </button>
                     </div>
                 </div>
            </div>
        </div>
    @endif





</div>
