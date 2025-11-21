<div class="spec_reviews">
    <div id="pac_search_form" class="_flex-display _align-bottom">
        <div class="_flex-display field_section spec_field_section" wire:ignore.self>
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none">
                <path d="M9.5 16.5C7.68333 16.5..." fill="black"/>
            </svg>

            <input
                id="spec_field"
                class="spec_field"
                type="text"
                wire:model.live="searchPatient"
                wire:keydown.enter="performSearch"
                wire:blur="onBlur"
                wire:focus="onFocus"
                wire:keydown.escape="$set('showSuggestions', false)"
                placeholder="{{__('Знайти пацієнта')}}"
                autocomplete="off"
            />

            <!-- Кнопка очистки -->
            @if($searchPatient)
                <button type="button" wire:click="clearSearch" class="ml-2 text-gray-500 hover:text-gray-700">
                    ×
                </button>
            @endif
            <!-- Автокомплит подсказки -->
            @if($searchPatient && count($patients) > 0 && $showSuggestions)
                <div class="autocomplete-suggestions">
                    @foreach($patients as $patient)
                        <div class="autocomplete-suggestion"
                             wire:click="selectPatient({{ $patient->id }}, '{{ $patient->name }}', '{{ $patient->patient->second_name ?? '' }}')">
                            <strong>{{ $patient->name }} {{ $patient->patient->second_name ?? '' }}</strong>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <button type="button" class="btn rose_btn" wire:click="performSearch">
            {{__('Пошук')}}
        </button>
    </div>
    @if(!isset($appointments) && $appointments->count() == 0)
        <p>{{__('Немає активних записів.')}}</p>
    @else
        @foreach($appointments as $appointment)
            <div class="spec_review my_appointment">
                <div class="_flex-display _justify-content-between spec_review_top">
                    <div class="_flex-display spec_review_left">
                        <div class="my_appointment_left">
                            <div class="spec_review_image">
                                <img src="{{ asset('uploads/' . $appointment->user->patient->photo) }}" alt="{{ $appointment->user->patient->second_name }} {{ $appointment->doctor->user->name }}">
                            </div>
                            <p class="my_appointment_left_phone"><a href="tel:{{ $appointment->user->patient->phone}} ">{{ $appointment->user->patient->phone }}</a></p>
                            <p class="my_appointment_left_phone"><a href="mailto:{{ $appointment->user->email}} ">{{ $appointment->user->email }}</a></p>
                            <div class="_flex-display _justify-content-center _align-center top_docs-city">
                                <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p><b>м. {{ $appointment->user->patient->city }}</b></p>
                            </div>
                        </div>
                        <div class="spec_review_name_stars">
                            <p>{{ $appointment->user->patient->second_name }} {{ $appointment->user->name }}</p>
                            <div class="_flex-display _justify-content-center _align-center rose_plate">{{__('Історія візитів')}}</div>
                            <p>{{ optional($appointment->date)->format('d.m.Y') }}</p>
                            <p class="client_address"><span>{{__('Час')}}:</span> {{ $appointment->hour }}</p>
                            @if($appointment->service && $appointment->service->name)
                                <p class="client_address"><span>{{__('Процедура')}}:</span> {{ $appointment->service->name }}</p>
                            @endif
                            @if($appointment->status === 'booking')
                                <div class="_flex-display _justify-content-center _align-center">
                                    <div class="_flex-display _align-center spec_register_buttons">
                                        <button type="submit" wire:click="bookingAppointment({{ $appointment->id }})" class="rose_btn register_prev">{{__('Підтвердити')}}</button>
                                        <button type="button" wire:click.prevent="showModal({{ $appointment->id }})" class="white_rose_btn register_prev">{{__('Скасувати')}}</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="spec_review_date">
                        <div class="_flex-display _justify-content-center _align-center rose_plate">{{__('Інформація про пацієнта')}}</div>
                        <div class="_flex-display _justify-content-center _align-center rose_plate_status">
                            @if($appointment->status === 'booking')
                                {{__('Новий')}}
                            @else
                                {{__('Підтверджений')}}
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    @endif
    @if($appointments->count() > 0 && $appointments->hasPages())
        <ul class="_flex-display _justify-content-center _align-center pagination">
            @if ($appointments->onFirstPage())
            @else
                <li><a wire:click="previousPage" class="_flex-display _justify-content-center _align-center"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                        </svg>
                    </a></li>
            @endif
            @foreach ($appointments->getUrlRange(1, $appointments->lastPage()) as $page => $url)
                @if($page === $appointments->currentPage())
                    <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @else
                    <li><a wire:click="gotoPage({{ $page }})" class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @endif
            @endforeach
            @if ($appointments->hasMorePages())
                <li><a wire:click="nextPage" class="_flex-display _justify-content-center _align-center">
                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Next" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </svg>
                    </a>
                </li>
            @endif
        </ul>
    @endif
    @if($modalVisible)
        <div id="add_city" class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_info_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Бажаєте скасувати візит?')}}</h4>
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
                <form wire:submit.prevent="cancelAppointment">
                    <label class="custom-radio">
                        <input type="radio"
                               wire:model="selectedReason"
                               wire:click="setReason('По причині хвороби лікаря')"
                               value="По причині хвороби лікаря">
                        <span></span> {{__('По причині хвороби лікаря')}}
                    </label>
                    <label class="custom-radio">
                        <input type="radio"
                               wire:model="selectedReason"
                               value="З особистих причин "
                               wire:click="setReason('З особистих причин ')">
                        <span></span> {{__('З особистих причин ')}}
                    </label>
                    <label class="custom-radio">
                        <input type="radio"
                               wire:model="selectedReason"
                               value="Відмовляюсь від цього пацієнта"
                               wire:click="setReason('Відмовляюсь від цього пацієнта')">
                        <span></span> {{__('Відмовляюсь від цього пацієнта')}}
                    </label>
                    <div class="search_field search_field_input">
                        <x-text-input type="text"
                                      wire:model="cancelReason"
                                      placeholder="{{__('Інша причина')}}" />
                        <x-input-error :messages="$errors->get('second_name')" class="mt-2" class="error-message" />
                    </div>
                </form>
                <div class="_flex-display _justify-content-center _align-center">
                    <div class="_flex-display _align-center spec_register_buttons">
                        <button type="submit" wire:click="cancelAppointment" class="rose_btn register_prev">{{__('Так')}}</button>
                        <button type="button" wire:click.prevent="closeModal()" class="white_rose_btn register_prev">{{__('Ні')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
