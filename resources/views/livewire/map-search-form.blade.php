<div class="search_form">
    <form wire:submit.prevent="searchDoctors" id="search" class="_flex-display _justify-content-between _align-center search_form">
        <div class="search_field search_field_service">
            <input
                id="search_service"
                class="search_service"
                type="text"
                placeholder="{{__('Обрати послугу')}}"
                wire:model="query"
                wire:keydown="performSearch"
                autocomplete="off"
            />
        </div>
        @if(count($services) > 0)
            <div class="autocomplete-suggestions">
                <ul>
                    @foreach($services as $service)
                        <li
                            wire:click="selectService({{ $service->id }}, @js($service->name))"
                            class="autocomplete-item"
                        >
                            {{ $service->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div wire:key="city-search-container"
             wire:ignore.self class="search_field search_field_city" >

            <input
                id="city_field"
                class="city_field"
                style="background:none"
                type="text"
                placeholder="{{__('Київ')}}"
                wire:model.live.debounce.300ms="search"
                autocomplete="off"
                wire:focus="showDropdown = true"
                wire:blur="hideDropdown"
            />
        </div>
        @if($showDropdown && count($filteredCities) > 0)
            <div class="autocomplete-suggestions">
                <ul>
                    @foreach($filteredCities as $item)
                        <li
                            wire:mousedown.prevent="selectCity('{{ $item }}')"
                            class="autocomplete-item"
                        >
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="search_field search_field_radius">
            <select wire:model="radius" id="search_radius" class="search_radius" name="radius">
                <option value="">---</option>
                <option value="5">до 5 км</option>
                <option value="15">до 15 км</option>
                <option value="30">до 30 км</option>
            </select>
        </div>
        <div class="search_field search_field_input doctor-search-wrapper"
             wire:key="doctor-search-container">
            <input
                id="search_doctor"
                class="search_search"
                type="text"
                placeholder="{{__('Пошук майстра (за прізвищем)')}}"
                name="doctor_query"

                {{-- Привязка к doctorQuery --}}
                wire:model.live.debounce.300ms="doctorQuery"
                autocomplete="off"

                wire:focus="showDoctorDropdown = true"
                wire:blur="hideDoctorDropdown"
            />

        </div>
            @if($showDoctorDropdown && count($doctorResults) > 0)
                <div class="autocomplete-suggestions">
                    <ul>
                        @foreach($doctorResults as $doctor)
                            @php
                                // Формируем полное имя для отображения
                                $fullName = $doctor->user->name . ' ' . $doctor->second_name;
                            @endphp

                            <li
                                class="autocomplete-item"
                                {{-- mousedown.prevent для корректной работы с wire:blur --}}
                                wire:mousedown.prevent="selectDoctor({{ $doctor->id }}, '{{ $fullName }}')"
                            >
                                {{ $fullName }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div class="search_field search_field_rating">
            <select wire:model="rating" id="search_rating" class="search_rating" name="rating">
                <option value="">{{__('Рейтинг лікаря')}}</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div wire:click="openMoreFilter()" id="more_filter">{{__('Ще фільтри')}}</div>
        <button type="submit" class="btn rose_btn submit_button">{{__('Знайти')}}</button>
        @if ($more_filter)
            <div id="more_filter_block">
                <div wire:click="closeMoreFilter()" id="more_filter_close">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="48" height="48" rx="24" fill="#FFE1E4"/>
                        <path d="M23.9999 25.6333L18.2833 31.3499C18.0694 31.5638 17.7972 31.6708 17.4666 31.6708C17.136 31.6708 16.8638 31.5638 16.6499 31.3499C16.436 31.136 16.3291 30.8638 16.3291 30.5333C16.3291 30.2027 16.436 29.9305 16.6499 29.7166L22.3666 23.9999L16.6499 18.2833C16.436 18.0694 16.3291 17.7972 16.3291 17.4666C16.3291 17.136 16.436 16.8638 16.6499 16.6499C16.8638 16.436 17.136 16.3291 17.4666 16.3291C17.7972 16.3291 18.0694 16.436 18.2833 16.6499L23.9999 22.3666L29.7166 16.6499C29.9305 16.436 30.2027 16.3291 30.5333 16.3291C30.8638 16.3291 31.136 16.436 31.3499 16.6499C31.5638 16.8638 31.6708 17.136 31.6708 17.4666C31.6708 17.7972 31.5638 18.0694 31.3499 18.2833L25.6333 23.9999L31.3499 29.7166C31.5638 29.9305 31.6708 30.2027 31.6708 30.5333C31.6708 30.8638 31.5638 31.136 31.3499 31.3499C31.136 31.5638 30.8638 31.6708 30.5333 31.6708C30.2027 31.6708 29.9305 31.5638 29.7166 31.3499L23.9999 25.6333Z" fill="black"/>
                    </svg>
                </div>
                <h5>{{__('Оберіть фільтри')}}</h5>
                <div class="_flex-display _justify-content-between _align-center more_filter_selects">
                    <div class="search_field search_field_area">
                        <div wire:key="area-search-container"
                             wire:ignore.self >

                            <input
                                id="area_field"
                                class="area_field"
                                style="background:none"
                                type="text"
                                placeholder="{{__('Район/Метро')}}"
                                wire:model.live.debounce.300ms="areaSearch"
                                autocomplete="off"
                                wire:focus="showAreaDropdown = true"
                                wire:blur="hideAreaDropdown"
                            />
                        </div>
                        @if($showAreaDropdown && count($filteredAreas) > 0)
                            <div class="autocomplete-suggestions">
                                <ul>
                                    @foreach($filteredAreas as $area)
                                        <li
                                            wire:mousedown.prevent="selectArea('{{ $area }}')"
                                            class="autocomplete-item"
                                        >
                                            {{ $area }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="search_field search_field_sex">
                        <select wire:model="sex" id="search_sex" class="search_sex" name="sex">
                            <option value="">{{__('Стать лікаря')}}</option>
                            <option value="male">{{__('Чоловік')}}</option>
                            <option value="female">{{__('Жінка')}}</option>
                        </select>
                    </div>
                </div>
                <div class="_flex-display more_filter_numb_checkbox">
                    <div class="_flex-display more_filter_numb">
                        <p>{{__('Вартість')}}</p>
                        <div class="_flex-display  more_filter_numb_inputs">
                            <div class="_flex-display _align-center more_filter_numb_field">
                                <span>{{__('Від')}}</span>
                                <input
                                    id="search_for"
                                    type="text"
                                    value="1000"
                                    wire:model="priceFrom"
                                    autocomplete="off"
                                    name="for">
                            </div>
                            <div class="_flex-display _align-center more_filter_numb_field">
                                <span>{{__('До')}}</span>
                                <input
                                    id="search_to"
                                    type="text"
                                    wire:model="priceTo"
                                    autocomplete="off"
                                    name="to">
                            </div>
                        </div>
                    </div>
                    <div class="_flex-display _align-center more_filter_checkboxes">
                        <label class="_flex-display _align-center more_filter_checkbox">
                            <input
                                id="check_discount"
                                type="checkbox"
                                name="discount"
                                wire:model.live="discount"
                            >
                            <span class="checkmark"></span>
                            <span class="check_title">{{__('Знижка')}}</span>
                        </label>
                        <label class="_flex-display _align-center more_filter_checkbox">
                            <input
                                id="check_gift"
                                type="checkbox"
                                name="gift"
                                wire:model.live="gift"
                            >
                            <span class="checkmark"></span>
                            <span class="check_title">{{__('Подарунок')}}</span>
                        </label>
                        <label class="_flex-display _align-center more_filter_checkbox">
                            <input
                                id="check_home"
                                type="checkbox"
                                name="at_home"
                                wire:model.live="at_home"
                            >
                            <span class="checkmark"></span>
                            <span class="check_title">{{__('Виїзд додому')}}</span>
                        </label>
                    </div>
                </div>
                <div class="_flex-display _justify-content-between _align-center more_filter_buttons">
                    <div wire:click="resetFilters()" id="clear_search" class="btn white_rose_btn clear_button">{{__('Очистити')}}</div>
                    <div wire:click="closeMoreFilter()" id="apply_search" class="btn rose_btn apply_button">{{__('Застосувати')}}</div>
                </div>
            </div>
        @endif
    </form>
</div>
