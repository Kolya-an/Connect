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
                             wire:click="selectPatient({{ $patient->id }})">
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
    @if($doctorPatients->count() > 0)
        @foreach($doctorPatients as $p)
            <div class="spec_review my_appointment">
                <div class="_flex-display _justify-content-between spec_review_top">
                    <div class="_flex-display spec_review_left _width100">
                        <div class="my_appointment_left">
                            <div class="spec_review_image">
                                <img src="{{ asset('uploads/' . $p->patient->photo) }}" alt="{{ $p->patient->second_name }} {{ $p->name }}">
                            </div>
                            @if($p->patient && $p->patient->phone)
                                <p class="my_appointment_left_phone"><a href="tel:{{ $p->patient->phone}} ">{{ $p->patient->phone }}</a></p>
                            @endif
                            @if($p->patient && $p->email)
                                <p class="my_appointment_left_phone"><a href="mailto:{{ $p->email}} ">{{ $p->email }}</a></p>
                            @endif
                            @if($p->patient && $p->patient->city)
                                <div class="_flex-display _justify-content-center _align-center top_docs-city">
                                    <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p><b>м. {{ $p->patient->city }}</b></p>
                                </div>
                            @endif
                        </div>
                        <div class="spec_review_name_stars">
                            <p>{{ $p->patient->second_name }} {{ $p->name }}</p>
                            <div class="_flex-display _align-center" style="gap:6px">
                                <div wire:click="$set('historyVisible', false)"
                                     class="_flex-display _justify-content-center _align-center rose_plate_status"
                                     style="margin:0;color:#fff;font-size:15px;padding:4px 12px">{{__('Інформація про пацієнта')}}</div>
                                <div wire:click="$set('historyVisible', true)"
                                class="_flex-display _justify-content-center _align-center rose_plate"
                                     style="margin:0">{{__('Історія візитів')}}</div>
                            </div>
                            @if(!$historyVisible)
                                @if($p->doctorPatient && $p->doctorPatient->text)
                                    @php //dd($p->doctorPatient); @endphp
                                    <div class="doctor-patient-extra">
                                        <p>{{ $p->doctorPatient->text }}</p>
                                        <a wire:click="showModal({{ $p->id }})">
                                            {{ __('Редагувати') }}
                                        </a>
                                    </div>
                                @else
                                    <div class="doctor-patient-extra">
                                        <a wire:click="showModal({{ $p->id }})">
                                            {{ __('Додати опис') }}
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="my_patients_appointments">
                                    @if($appointmentsByPatient->has($p->id))
                                        @foreach($appointmentsByPatient[$p->id] as $appointment)
                                            <div class="_flex-display _justify-content-between mt20 gap10 _width100">
                                                <div>
                                                    <p>{{ optional($appointment->date)->format('d.m.Y') }}</p>
                                                    <p class="client_address"><span>{{__('Час')}}:</span> {{ $appointment->hour }}</p>
                                                    @if($appointment->service && $appointment->service->name)
                                                        <p class="client_address"><span>{{__('Процедура')}}:</span> {{ $appointment->service->name }}</p>
                                                    @endif
                                                    @if($appointment->information)
                                                        <p class="client_address"><span>{{__('Інформація про прійом:')}}:</span> {{ $appointment->information }}</p>
                                                    @endif
                                                    @if($appointment->status === 'confirmed')
                                                        <div class="_flex-display _justify-content-center _align-center">
                                                            <div class="_flex-display _align-center spec_register_buttons">
                                                                <button type="submit" wire:click="showModalHistory({{ $appointment->id }})" class="rose_btn register_prev">{{__('Візіт відбувся')}}</button>
                                                                <button type="button" wire:click="canceledAppointment({{ $appointment->id }})" class="white_rose_btn register_prev">{{__('Пацієнт не прийшов')}}</button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="_flex-display _justify-content-center _align-center rose_plate_status">
                                                    @if($appointment->status === 'confirmed')
                                                        {{__('Майбутній')}}
                                                    @else
                                                        {{__('Відбувся')}}
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>{{__('Немає активних записів.')}}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @else
        <p>{{ __('Пацієнтів не знайдено.') }}</p>
    @endif
    @if($doctorPatients->hasPages())
        <ul class="_flex-display _justify-content-center _align-center pagination">
            @if (!$doctorPatients->onFirstPage())
                <li>
                    <a wire:click="previousPage('page')" class="_flex-display _justify-content-center _align-center cursor-pointer">
                        <!-- SVG prev -->
                        <
                    </a>
                </li>
            @endif

            @foreach ($doctorPatients->getUrlRange(1, $doctorPatients->lastPage()) as $page => $url)
                @if($page === $doctorPatients->currentPage())
                    <li class="pagination_current">
                        <a class="_flex-display _justify-content-center _align-center">{{ $page }}</a>
                    </li>
                @else
                    <li>
                        <a wire:click="gotoPage({{ $page }}, 'page')" class="_flex-display _justify-content-center _align-center cursor-pointer">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endforeach

            @if ($doctorPatients->hasMorePages())
                <li>
                    <a wire:click="nextPage('page')" class="_flex-display _justify-content-center _align-center cursor-pointer">
                        <!-- SVG next -->
                        >
                    </a>
                </li>
            @endif
        </ul>
    @endif

    @if($modalVisible)
        <div class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_info_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Додайте інформацію про пацієнта')}}</h4>
                    <div wire:click="closeModal" id="window_close" class="window_close cursor-pointer">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none">
                            <rect width="48" height="48" rx="24" fill="rgb(255,225,228)" />
                            <path d="M24.0009 25.6333L18.2842 31.3499C18.0704 31.5638 17.7981 31.6708 17.4676 31.6708C17.137 31.6708 16.8648 31.5638 16.6509 31.3499C16.437 31.136 16.3301 30.8638 16.3301 30.5333C16.3301 30.2027 16.437 29.9305 16.6509 29.7166L22.3676 23.9999L16.6509 18.2833C16.437 18.0694 16.3301 17.7972 16.3301 17.4666C16.3301 17.136 16.437 16.8638 16.6509 16.6499C16.8648 16.436 17.137 16.3291 17.4676 16.3291C17.7981 16.3291 18.0704 16.436 18.2842 16.6499L24.0009 22.3666L29.7176 16.6499C29.9315 16.436 30.2037 16.3291 30.5342 16.3291C30.8648 16.3291 31.137 16.436 31.3509 16.6499C31.5648 16.8638 31.6717 17.136 31.6717 17.4666C31.6717 17.7972 31.5648 18.0694 31.3509 18.2833L25.6342 23.9999L31.3509 29.7166C31.5648 29.9305 31.6717 30.2027 31.6717 30.5333C31.6717 30.8638 31.5648 31.136 31.3509 31.3499C31.137 31.5638 30.8648 31.6708 30.5342 31.6708C30.2037 31.6708 29.9315 31.5638 29.7176 31.3499L24.0009 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </svg>
                    </div>
                </div>
                <textarea
                    wire:model="patientInformation"
                    class="add_desc_photo"
                    placeholder="{{__('Основна інформація про пацієнта')}}"
                    rows="6"
                ></textarea>
                <div class="_flex-display _justify-content-center _align-center">
                    <div class="_flex-display _align-center spec_register_buttons">
                        <button type="button" wire:click="savePatientInformation" class="rose_btn register_prev">
                            {{__('Зберегти')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($modalHistory)
                {{ $appointment->id }}
        <div class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_info_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Додайте інформацію про візит')}}</h4>
                    <div wire:click="closeModalHistory" id="window_close" class="window_close cursor-pointer">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none">
                            <rect width="48" height="48" rx="24" fill="rgb(255,225,228)" />
                            <path d="M24.0009 25.6333L18.2842 31.3499C18.0704 31.5638 17.7981 31.6708 17.4676 31.6708C17.137 31.6708 16.8648 31.5638 16.6509 31.3499C16.437 31.136 16.3301 30.8638 16.3301 30.5333C16.3301 30.2027 16.437 29.9305 16.6509 29.7166L22.3676 23.9999L16.6509 18.2833C16.437 18.0694 16.3301 17.7972 16.3301 17.4666C16.3301 17.136 16.437 16.8638 16.6509 16.6499C16.8648 16.436 17.137 16.3291 17.4676 16.3291C17.7981 16.3291 18.0704 16.436 18.2842 16.6499L24.0009 22.3666L29.7176 16.6499C29.9315 16.436 30.2037 16.3291 30.5342 16.3291C30.8648 16.3291 31.137 16.436 31.3509 16.6499C31.5648 16.8638 31.6717 17.136 31.6717 17.4666C31.6717 17.7972 31.5648 18.0694 31.3509 18.2833L25.6342 23.9999L31.3509 29.7166C31.5648 29.9305 31.6717 30.2027 31.6717 30.5333C31.6717 30.8638 31.5648 31.136 31.3509 31.3499C31.137 31.5638 30.8648 31.6708 30.5342 31.6708C30.2037 31.6708 29.9315 31.5638 29.7176 31.3499L24.0009 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </svg>
                    </div>
                </div>
                <textarea
                    wire:model="information"
                    class="add_desc_photo"
                    placeholder="{{__('Основна інформація про візит')}}"
                    rows="6"
                ></textarea>
                <div class="_flex-display _justify-content-center _align-center">
                    <div class="_flex-display _align-center spec_register_buttons">
                        <button type="button" wire:click="completedAppointment" class="rose_btn register_prev">
                            {{__('Зберегти')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
