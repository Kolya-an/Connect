<div class="_flex-display _justify-content-between appointments">
    <div class="appointments_btn">
        <div class="_flex-display _justify-content-center _align-center appointments_prev">
            <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(243,150,162)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
            </svg>
        </div>
    </div>
    <div class="appointments_schedule">
        <div class="swiper swiper_appointments">
            <div class="swiper-wrapper appointments_carousel">
                @foreach($dates as $date)
                    <div class="swiper-slide appointments-slide">
                        <div class="appointments_day">

                            <div class="appointments_title">
                                {{ $date['weekday'] }},<br>
                                {{ $date['formatted'] }}
                            </div>
                            @foreach($this->getTimeSlotsForDisplay($date['date']) as $slot)
                                @if($slot['status']  === 'non_working')
                                    <div class="_flex-display _justify-content-center _align-center appointments_not">-</div>
                                @elseif($slot['status'] === 'available')
                                    <!--<div class="_flex-display _justify-content-center _align-center appointments_free"
                                         wire:click="selectDate('{{ $date['date'] }}','{{ $slot['hour'] }}')">
                                        {{ $slot['hour'] }}</div>-->
                                    <div class="_flex-display _justify-content-center _align-center appointments_free"
                                         wire:click="openPhoneModal">
                                        {{ $slot['hour'] }}</div>     
                                @else
                                    <div class="_flex-display _justify-content-center _align-center appointments_busy">{{ $slot['hour'] }}</div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <div class="appointments_btn">
        <div class="_flex-display _justify-content-center _align-center appointments_next">
            <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" transform="matrix(-1,0,0,1,16,0)" />
                <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(243,150,162)" fill-rule="nonzero" transform="matrix(1,8.74228e-08,8.74228e-08,-1,5,12)" />
            </svg>
        </div>
    </div>
    @if($showModal)
        <div id="window_appointment" class="_flex-display _justify-content-center _align-center screen">
            <div class="window login_appointment_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Записатись на прийом')}}</h4>
                    <div wire:click="closeModal" id="window_close">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48.000000" height="48.000000" fill="none" clip-path="url(#clipPath_0)" customFrame="url(#clipPath_0)">
                            <defs>
                                <clipPath id="clipPath_0">
                                    <rect width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,255,255)" />
                                </clipPath>
                                <clipPath id="clipPath_1">
                                    <rect width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" />
                                </clipPath>
                            </defs>
                            <rect id="Frame 1153" width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,225,228)" />
                            <g id="material-symbols:close-rounded" clip-path="url(#clipPath_1)" customFrame="url(#clipPath_1)">
                                <rect id="material-symbols:close-rounded" width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <path id="Vector" d="M23.9999 25.6333L18.2833 31.3499C18.0694 31.5638 17.7972 31.6708 17.4666 31.6708C17.136 31.6708 16.8638 31.5638 16.6499 31.3499C16.436 31.136 16.3291 30.8638 16.3291 30.5333C16.3291 30.2027 16.436 29.9305 16.6499 29.7166L22.3666 23.9999L16.6499 18.2833C16.436 18.0694 16.3291 17.7972 16.3291 17.4666C16.3291 17.136 16.436 16.8638 16.6499 16.6499C16.8638 16.436 17.136 16.3291 17.4666 16.3291C17.7972 16.3291 18.0694 16.436 18.2833 16.6499L23.9999 22.3666L29.7166 16.6499C29.9305 16.436 30.2027 16.3291 30.5333 16.3291C30.8638 16.3291 31.136 16.436 31.3499 16.6499C31.5638 16.8638 31.6708 17.136 31.6708 17.4666C31.6708 17.7972 31.5638 18.0694 31.3499 18.2833L25.6333 23.9999L31.3499 29.7166C31.5638 29.9305 31.6708 30.2027 31.6708 30.5333C31.6708 30.8638 31.5638 31.136 31.3499 31.3499C31.136 31.5638 30.8638 31.6708 30.5333 31.6708C30.2027 31.6708 29.9305 31.5638 29.7166 31.3499L23.9999 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                            </g>
                        </svg>
                    </div>
                </div>
                <p class="p_rose">{{__('Ваш запис')}}:</p>
                @if($doctor->types)
                    <p><b>{{__('Спеціаліст')}}:</b>
                        @foreach($doctor->types as $type)
                            {{$type}}{{ $loop->last ? '' : ', ' }}
                        @endforeach
                    </p>
                @endif
                <p><b>{{__('ПІБ')}}:</b> {{ $doctor->second_name ?? '' }} {{ $doctor->user->name ?? '-' }}</p>
                <p><b>{{__('Дата')}}:</b> {{ $selectedDate }}</p>
                <p><b>{{__('Час')}}:</b> {{ $selectedHour }}</p>
                <p><b>{{__('Адреса')}}:</b> {{ $doctor->city ?? '' }},  {{ $doctor->address ?? '' }}
                <div class="search_field search_field_input">
                    <input
                        type="text"
                        wire:model="search"
                        wire:keydown.escape="resetSearch"
                        list="servicesList"
                        class="form-control"
                        placeholder="Пошук послуги..."
                        autocomplete="off"
                    />

                    <datalist id="servicesList">
                        @foreach($services as $service)
                            <option value="{{ $service->name }}">
                        @endforeach
                    </datalist>

                    <!-- Опционально: выпадающий список -->
                    @if($search && $services->isNotEmpty())
                        <div class="autocomplete-suggestions">
                            @foreach($services as $service)
                                <div
                                    class="autocomplete-suggestion"
                                    wire:click="selectService({{ $service->id }})"
                                >
                                    {{ $service->name }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <p>&nbsp;</p>
                <a wire:click="bookAppointment" class="btn rose_btn">{{__('Записатись')}}</a>
            </div>
        </div>
    @endif
    @if($showLoginModal)
        <div wire:click="closeModal" id="login_appointment" class="_flex-display _justify-content-center _align-center screen">
            <div class="window login_appointment_window">
                <h4>{{__('Авторизуйтесь, щоб записатися на прийом')}}</h4>
                <div wire:click="closeModal" style="cursor:pointer;" id="window_close">
                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48.000000" height="48.000000" fill="none" clip-path="url(#clipPath_0)" customFrame="url(#clipPath_0)">
                        <defs>
                            <clipPath id="clipPath_0">
                                <rect width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,255,255)" />
                            </clipPath>
                            <clipPath id="clipPath_1">
                                <rect width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" />
                            </clipPath>
                        </defs>
                        <rect id="Frame 1153" width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,225,228)" />
                        <g id="material-symbols:close-rounded" clip-path="url(#clipPath_1)" customFrame="url(#clipPath_1)">
                            <rect id="material-symbols:close-rounded" width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M23.9999 25.6333L18.2833 31.3499C18.0694 31.5638 17.7972 31.6708 17.4666 31.6708C17.136 31.6708 16.8638 31.5638 16.6499 31.3499C16.436 31.136 16.3291 30.8638 16.3291 30.5333C16.3291 30.2027 16.436 29.9305 16.6499 29.7166L22.3666 23.9999L16.6499 18.2833C16.436 18.0694 16.3291 17.7972 16.3291 17.4666C16.3291 17.136 16.436 16.8638 16.6499 16.6499C16.8638 16.436 17.136 16.3291 17.4666 16.3291C17.7972 16.3291 18.0694 16.436 18.2833 16.6499L23.9999 22.3666L29.7166 16.6499C29.9305 16.436 30.2027 16.3291 30.5333 16.3291C30.8638 16.3291 31.136 16.436 31.3499 16.6499C31.5638 16.8638 31.6708 17.136 31.6708 17.4666C31.6708 17.7972 31.5638 18.0694 31.3499 18.2833L25.6333 23.9999L31.3499 29.7166C31.5638 29.9305 31.6708 30.2027 31.6708 30.5333C31.6708 30.8638 31.5638 31.136 31.3499 31.3499C31.136 31.5638 30.8638 31.6708 30.5333 31.6708C30.2027 31.6708 29.9305 31.5638 29.7166 31.3499L23.9999 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </g>
                    </svg>
                </div>
                @livewire('pages.auth.login')
            </div>
        </div>
    @endif
    @if($showPhoneModal)
        <div wire:click="closeModal" id="phone_appointment" class="_flex-display _justify-content-center _align-center screen">
            <div class="window phone_appointment_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Зателефонуйте ')}}</h4>
                    <div wire:click="closeModal" style="cursor:pointer;" id="window_close">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48.000000" height="48.000000" fill="none" clip-path="url(#clipPath_0)" customFrame="url(#clipPath_0)">
                            <defs>
                                <clipPath id="clipPath_0">
                                    <rect width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,255,255)" />
                                </clipPath>
                                <clipPath id="clipPath_1">
                                    <rect width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" />
                                </clipPath>
                            </defs>
                            <rect id="Frame 1153" width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,225,228)" />
                            <g id="material-symbols:close-rounded" clip-path="url(#clipPath_1)" customFrame="url(#clipPath_1)">
                                <rect id="material-symbols:close-rounded" width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <path id="Vector" d="M23.9999 25.6333L18.2833 31.3499C18.0694 31.5638 17.7972 31.6708 17.4666 31.6708C17.136 31.6708 16.8638 31.5638 16.6499 31.3499C16.436 31.136 16.3291 30.8638 16.3291 30.5333C16.3291 30.2027 16.436 29.9305 16.6499 29.7166L22.3666 23.9999L16.6499 18.2833C16.436 18.0694 16.3291 17.7972 16.3291 17.4666C16.3291 17.136 16.436 16.8638 16.6499 16.6499C16.8638 16.436 17.136 16.3291 17.4666 16.3291C17.7972 16.3291 18.0694 16.436 18.2833 16.6499L23.9999 22.3666L29.7166 16.6499C29.9305 16.436 30.2027 16.3291 30.5333 16.3291C30.8638 16.3291 31.136 16.436 31.3499 16.6499C31.5638 16.8638 31.6708 17.136 31.6708 17.4666C31.6708 17.7972 31.5638 18.0694 31.3499 18.2833L25.6333 23.9999L31.3499 29.7166C31.5638 29.9305 31.6708 30.2027 31.6708 30.5333C31.6708 30.8638 31.5638 31.136 31.3499 31.3499C31.136 31.5638 30.8638 31.6708 30.5333 31.6708C30.2027 31.6708 29.9305 31.5638 29.7166 31.3499L23.9999 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="spec_register1_right_block" style="margin:0">
                    <p class="client_address" style="margin:0 0 10px 0; text-align:center;">
                       {{__('Зателефонуйте щоб записатися на прийом ')}}
                    </p>
                    <p class="client_address" style="margin:0 0 10px 0; text-align:center; font-size: 38px; font-weight: bold;color: red;">
                       +380 44 354 77 77
                    </p>
                   
                </div>
            </div>
        </div>
    @endif
</div>
