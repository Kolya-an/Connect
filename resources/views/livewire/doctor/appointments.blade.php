<div>
    <h5>Ваш Розклад</h5>
    <div class="_flex-display _justify-content-between appointments">
        <div class="appointments_btn">
            <div class="_flex-display _justify-content-center _align-center app_spec_prev">
                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                    <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                    <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(243,150,162)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                </svg>
            </div>
        </div>
        <div class="appointments_schedule">
            <div class="swiper swiper_spec">
                <div class="swiper-wrapper appointments_carousel">
                    @foreach($dates as $date)


                        <div class="swiper-slide appointments-slide">
                            <div class="appointments_day">
                                <div
                                    wire:click="selectDate('{{ $date['date'] }}')"
                                    class="_flex-display _justify-content-center _align-center appointments_day_edit_link">
                                    <span>Редагувати</span>
                                </div>
                                <div class="appointments_title">
                                    {{ $date['weekday'] }},<br>
                                    {{ $date['formatted'] }}
                                </div>
                                @php
                                    //dd($this->getTimeSlotsForDisplay($selectedDate));
                                @endphp
                                @foreach($this->getTimeSlotsForDisplay($date['date']) as $slot)
                                    @if($slot['status']  === 'non_working')
                                        <div class="_flex-display _justify-content-center _align-center appointments_not ">-</div>
                                    @elseif($slot['status'] === 'available')
                                        <div class="_flex-display _justify-content-center _align-center appointments_free ">{{ $slot['hour'] }}</div>
                                    @else
                                        <div class="_flex-display _justify-content-center _align-center appointments_busy ">{{ $slot['hour'] }}</div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="appointments_btn">
            <div class="_flex-display _justify-content-center _align-center app_spec_next">
                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                    <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" transform="matrix(-1,0,0,1,16,0)" />
                    <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(243,150,162)" fill-rule="nonzero" transform="matrix(1,8.74228e-08,8.74228e-08,-1,5,12)" />
                </svg>
            </div>
        </div>
    </div>
    @if($showModal)
        <div wire:click="closeModal" id="edit_schedule" class="_flex-display _justify-content-center _align-center screen">
            <div wire:click.stop class="window add_info_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Редагувати розклад')}}</h4>
                    <div wire:click="closeModal" id="window_close" class="window_close">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48.000000" height="48.000000" fill="none" clip-path="url(#clipPath_6)" customFrame="url(#clipPath_6)">
                            <defs>
                                <clipPath id="clipPath_6">
                                    <rect width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,255,255)" />
                                </clipPath>
                                <clipPath id="clipPath_7">
                                    <rect width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" />
                                </clipPath>
                            </defs>
                            <rect id="Frame 1153" width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,225,228)" />
                            <g id="material-symbols:close-rounded" clip-path="url(#clipPath_7)" customFrame="url(#clipPath_7)">
                                <rect id="material-symbols:close-rounded" width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <path id="Vector" d="M24.0009 25.6333L18.2842 31.3499C18.0704 31.5638 17.7981 31.6708 17.4676 31.6708C17.137 31.6708 16.8648 31.5638 16.6509 31.3499C16.437 31.136 16.3301 30.8638 16.3301 30.5333C16.3301 30.2027 16.437 29.9305 16.6509 29.7166L22.3676 23.9999L16.6509 18.2833C16.437 18.0694 16.3301 17.7972 16.3301 17.4666C16.3301 17.136 16.437 16.8638 16.6509 16.6499C16.8648 16.436 17.137 16.3291 17.4676 16.3291C17.7981 16.3291 18.0704 16.436 18.2842 16.6499L24.0009 22.3666L29.7176 16.6499C29.9315 16.436 30.2037 16.3291 30.5342 16.3291C30.8648 16.3291 31.137 16.436 31.3509 16.6499C31.5648 16.8638 31.6717 17.136 31.6717 17.4666C31.6717 17.7972 31.5648 18.0694 31.3509 18.2833L25.6342 23.9999L31.3509 29.7166C31.5648 29.9305 31.6717 30.2027 31.6717 30.5333C31.6717 30.8638 31.5648 31.136 31.3509 31.3499C31.137 31.5638 30.8648 31.6708 30.5342 31.6708C30.2037 31.6708 29.9315 31.5638 29.7176 31.3499L24.0009 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                            </g>
                        </svg>
                    </div>
                </div>
                @if($selectedDate)
                    <div class="edit_schedule_window_block">
                        @foreach($workingHours as $hour)
                            @php
                                $currentStatus = $this->getCurrentStatus($selectedDate, $hour);
                            @endphp
                            <div class="_flex-display _justify-content-between _align-center edit_hour">
                                <div class="_flex-display _justify-content-center _align-center edit_hour_time">{{ $hour }}
                                    @if($currentStatus === 'non_working')
                                        Не працюємо
                                    @elseif($currentStatus === 'available')
                                        Вільно
                                    @else
                                        Зайнято
                                    @endif
                                </div>
                                <div wire:click="updateTimeSlot('{{ $hour }}', 'busy')" class="_flex-display _justify-content-center _align-center _cursor_pointer btn white_rose_btn edit_hour_not_free_btn">Немає вільніх місць</div>
                                <div wire:click="updateTimeSlot('{{ $hour }}', 'non_working')" class="_cursor_pointer edit_hour_close">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24.000000" height="24.000000" fill="none" clip-path="url(#clipPath_0)" customFrame="url(#clipPath_0)">
                                        <defs>
                                            <clipPath id="clipPath_0">
                                                <rect width="24.000000" height="24.000000" x="0.000000" y="0.000000" rx="12.000000" fill="rgb(255,255,255)" />
                                            </clipPath>
                                            <clipPath id="clipPath_1">
                                                <rect width="11.000000" height="11.000000" x="6.500000" y="6.500000" fill="rgb(255,255,255)" />
                                            </clipPath>
                                        </defs>
                                        <rect id="Frame 1153" width="24.000000" height="24.000000" x="0.000000" y="0.000000" rx="12.000000" fill="rgb(255,225,228)" />
                                        <g id="material-symbols:close-rounded" clip-path="url(#clipPath_1)" customFrame="url(#clipPath_1)">
                                            <rect id="material-symbols:close-rounded" width="11.000000" height="11.000000" x="6.500000" y="6.500000" fill="rgb(255,255,255)" fill-opacity="0" />
                                            <path id="Vector" d="M11.9999 12.6415L9.75404 14.8874C9.67001 14.9714 9.56306 15.0134 9.4332 15.0134C9.30334 15.0134 9.1964 14.9714 9.11237 14.8874C9.02834 14.8033 8.98633 14.6964 8.98633 14.5665C8.98633 14.4367 9.02834 14.3297 9.11237 14.2457L11.3582 11.9999L9.11237 9.75404C9.02834 9.67001 8.98633 9.56306 8.98633 9.4332C8.98633 9.30334 9.02834 9.1964 9.11237 9.11237C9.1964 9.02834 9.30334 8.98633 9.4332 8.98633C9.56306 8.98633 9.67001 9.02834 9.75404 9.11237L11.9999 11.3582L14.2457 9.11237C14.3297 9.02834 14.4367 8.98633 14.5665 8.98633C14.6964 8.98633 14.8033 9.02834 14.8874 9.11237C14.9714 9.1964 15.0134 9.30334 15.0134 9.4332C15.0134 9.56306 14.9714 9.67001 14.8874 9.75404L12.6415 11.9999L14.8874 14.2457C14.9714 14.3297 15.0134 14.4367 15.0134 14.5665C15.0134 14.6964 14.9714 14.8033 14.8874 14.8874C14.8033 14.9714 14.6964 15.0134 14.5665 15.0134C14.4367 15.0134 14.3297 14.9714 14.2457 14.8874L11.9999 12.6415Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                </div>
                                <div wire:click="updateTimeSlot('{{ $hour }}', 'available')" class="_cursor_pointer edit_hour_chech">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24.000000" height="24.000000" fill="none" clip-path="url(#clipPath_2)" customFrame="url(#clipPath_2)">
                                        <defs>
                                            <clipPath id="clipPath_2">
                                                <rect width="24.000000" height="24.000000" x="0.000000" y="0.000000" rx="12.000000" fill="rgb(255,255,255)" />
                                            </clipPath>
                                            <clipPath id="clipPath_3">
                                                <rect width="11.000000" height="11.000000" x="6.500000" y="6.500000" fill="rgb(255,255,255)" />
                                            </clipPath>
                                        </defs>
                                        <rect id="Frame 1154" width="24.000000" height="24.000000" x="0.000000" y="0.000000" rx="12.000000" fill="rgb(243,150,162)" />
                                        <g id="material-symbols:done-rounded" clip-path="url(#clipPath_3)" customFrame="url(#clipPath_3)">
                                            <rect id="material-symbols:done-rounded" width="11.000000" height="11.000000" x="6.500000" y="6.500000" fill="rgb(255,255,255)" fill-opacity="0" />
                                            <path id="Vector" d="M10.877 13.4437L14.7614 9.55937C14.853 9.46771 14.96 9.42188 15.0822 9.42188C15.2044 9.42188 15.3114 9.46771 15.403 9.55937C15.4947 9.65104 15.5405 9.75997 15.5405 9.88617C15.5405 10.0124 15.4947 10.1211 15.403 10.2125L11.1978 14.4292C11.1062 14.5208 10.9992 14.5667 10.877 14.5667C10.7548 14.5667 10.6478 14.5208 10.5562 14.4292L8.58534 12.4583C8.49367 12.3667 8.44967 12.2579 8.45334 12.132C8.457 12.0061 8.50482 11.8972 8.5968 11.8052C8.68877 11.7132 8.7977 11.6674 8.92359 11.6677C9.04948 11.668 9.15825 11.7138 9.24992 11.8052L10.877 13.4437Z" fill="rgb(255,255,255)" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>
