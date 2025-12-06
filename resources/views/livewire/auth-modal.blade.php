<div x-data="{ modal: null, init() { modal = @entangle('modal') } }" x-init="init()">
    <!-- Кнопка -->
    <button
        @click="modal='register'"
        class="btn rose_btn register_btn">
        {{__('Реєстрація')}}
    </button>
    <div @click="modal='register'" id="btn_reg" class="btn" style="background:#000;color:#fff;cursor:pointer">{{__('Зареєструйся, щоб бачити актуальні акції від лікарів!')}}</div>
    <!-- Модалка -->
    <div
        x-show="modal === 'register'"
        x-cloak { display: none !important; }
        wire:ignore.self
        id="register_window" class="_flex-display _justify-content-center _align-center screen"
    >
        <div
            @click.away="modal=null"
            class="window login_appointment_window"
        >
            <div class="_flex-display _justify-content-between _align-center window_top">
                <h4>{{__('Зареєструйтесь')}}</h4>
            <!-- Кнопка закрытия -->
                <button
                    @click="modal=null"
                    id="window_close"
                >
                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         width="48.000000" height="48.000000" fill="none" clip-path="url(#clipPath_0)"
                         customFrame="url(#clipPath_0)">
                        <defs>
                            <clipPath id="clipPath_0">
                                <rect width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000"
                                      fill="rgb(255,255,255)"/>
                            </clipPath>
                            <clipPath id="clipPath_1">
                                <rect width="28.000000" height="28.000000" x="10.000000" y="10.000000"
                                      fill="rgb(255,255,255)"/>
                            </clipPath>
                        </defs>
                        <rect id="Frame 1153" width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000"
                              fill="rgb(255,225,228)"/>
                        <g id="material-symbols:close-rounded" clip-path="url(#clipPath_1)" customFrame="url(#clipPath_1)">
                            <rect id="material-symbols:close-rounded" width="28.000000" height="28.000000" x="10.000000"
                                  y="10.000000" fill="rgb(255,255,255)" fill-opacity="0"/>
                            <path id="Vector"
                                  d="M23.9999 25.6333L18.2833 31.3499C18.0694 31.5638 17.7972 31.6708 17.4666 31.6708C17.136 31.6708 16.8638 31.5638 16.6499 31.3499C16.436 31.136 16.3291 30.8638 16.3291 30.5333C16.3291 30.2027 16.436 29.9305 16.6499 29.7166L22.3666 23.9999L16.6499 18.2833C16.436 18.0694 16.3291 17.7972 16.3291 17.4666C16.3291 17.136 16.436 16.8638 16.6499 16.6499C16.8638 16.436 17.136 16.3291 17.4666 16.3291C17.7972 16.3291 18.0694 16.436 18.2833 16.6499L23.9999 22.3666L29.7166 16.6499C29.9305 16.436 30.2027 16.3291 30.5333 16.3291C30.8638 16.3291 31.136 16.436 31.3499 16.6499C31.5638 16.8638 31.6708 17.136 31.6708 17.4666C31.6708 17.7972 31.5638 18.0694 31.3499 18.2833L25.6333 23.9999L31.3499 29.7166C31.5638 29.9305 31.6708 30.2027 31.6708 30.5333C31.6708 30.8638 31.5638 31.136 31.3499 31.3499C31.136 31.5638 30.8638 31.6708 30.5333 31.6708C30.2027 31.6708 29.9305 31.5638 29.7166 31.3499L23.9999 25.6333Z"
                                  fill="rgb(0,0,0)" fill-rule="nonzero"/>
                        </g>
                    </svg>
                </button>

            <!-- Внутри — форма регистрации -->
                @livewire('register-page')
                <div @click="modal='login'">{{__('Або увійдіть')}}</div>
            </div>
        </div>
    </div>

    <div
        x-show="modal === 'login'"
        x-cloak
        id="login_window" class="_flex-display _justify-content-center _align-center screen"
    >
        <div
            @click.away="open = false"
            class="window login_appointment_window"
        >
            <div class="_flex-display _justify-content-between _align-center window_top" @click.away="modal=null">
                <h4>{{__('Увійдіть до вашого аккаунту')}}</h4>
                <!-- Кнопка закрытия -->
                <button
                    @click="modal=null"
                    id="window_close"
                >
                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         width="48.000000" height="48.000000" fill="none" clip-path="url(#clipPath_0)"
                         customFrame="url(#clipPath_0)">
                        <defs>
                            <clipPath id="clipPath_0">
                                <rect width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000"
                                      fill="rgb(255,255,255)"/>
                            </clipPath>
                            <clipPath id="clipPath_1">
                                <rect width="28.000000" height="28.000000" x="10.000000" y="10.000000"
                                      fill="rgb(255,255,255)"/>
                            </clipPath>
                        </defs>
                        <rect id="Frame 1153" width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000"
                              fill="rgb(255,225,228)"/>
                        <g id="material-symbols:close-rounded" clip-path="url(#clipPath_1)" customFrame="url(#clipPath_1)">
                            <rect id="material-symbols:close-rounded" width="28.000000" height="28.000000" x="10.000000"
                                  y="10.000000" fill="rgb(255,255,255)" fill-opacity="0"/>
                            <path id="Vector"
                                  d="M23.9999 25.6333L18.2833 31.3499C18.0694 31.5638 17.7972 31.6708 17.4666 31.6708C17.136 31.6708 16.8638 31.5638 16.6499 31.3499C16.436 31.136 16.3291 30.8638 16.3291 30.5333C16.3291 30.2027 16.436 29.9305 16.6499 29.7166L22.3666 23.9999L16.6499 18.2833C16.436 18.0694 16.3291 17.7972 16.3291 17.4666C16.3291 17.136 16.436 16.8638 16.6499 16.6499C16.8638 16.436 17.136 16.3291 17.4666 16.3291C17.7972 16.3291 18.0694 16.436 18.2833 16.6499L23.9999 22.3666L29.7166 16.6499C29.9305 16.436 30.2027 16.3291 30.5333 16.3291C30.8638 16.3291 31.136 16.436 31.3499 16.6499C31.5638 16.8638 31.6708 17.136 31.6708 17.4666C31.6708 17.7972 31.5638 18.0694 31.3499 18.2833L25.6333 23.9999L31.3499 29.7166C31.5638 29.9305 31.6708 30.2027 31.6708 30.5333C31.6708 30.8638 31.5638 31.136 31.3499 31.3499C31.136 31.5638 30.8638 31.6708 30.5333 31.6708C30.2027 31.6708 29.9305 31.5638 29.7166 31.3499L23.9999 25.6333Z"
                                  fill="rgb(0,0,0)" fill-rule="nonzero"/>
                        </g>
                    </svg>
                </button>

                <!-- Внутри — форма регистрации -->
                @livewire('pages.auth.login')
                <div @click="modal='register'">{{__('Або зареєструйтесь')}}</div>
            </div>
        </div>
    </div>

</div>
