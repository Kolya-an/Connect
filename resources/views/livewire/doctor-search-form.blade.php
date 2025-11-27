<div>
    <div class="home_search_form">
        <form wire:submit.prevent="searchDoctors" id="doc_search_form" class="_flex-display _justify-content-between _align-center">
            <div class="_flex-display field_section spec_field_section" style="position: relative;">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.5 16.5C7.68333 16.5 6.146 15.8707 4.888 14.612C3.63 13.3533 3.00067 11.816 3 10C2.99933 8.184 3.62867 6.64667 4.888 5.388C6.14733 4.12933 7.68467 3.5 9.5 3.5C11.3153 3.5 12.853 4.12933 14.113 5.388C15.373 6.64667 16.002 8.184 16 10C16 10.7333 15.8833 11.425 15.65 12.075C15.4167 12.725 15.1 13.3 14.7 13.8L20.3 19.4C20.4833 19.5833 20.575 19.8167 20.575 20.1C20.575 20.3833 20.4833 20.6167 20.3 20.8C20.1167 20.9833 19.8833 21.075 19.6 21.075C19.3167 21.075 19.0833 20.9833 18.9 20.8L13.3 15.2C12.8 15.6 12.225 15.9167 11.575 16.15C10.925 16.3833 10.2333 16.5 9.5 16.5ZM9.5 14.5C10.75 14.5 11.8127 14.0627 12.688 13.188C13.5633 12.3133 14.0007 11.2507 14 10C13.9993 8.74933 13.562 7.687 12.688 6.813C11.814 5.939 10.7513 5.50133 9.5 5.5C8.24867 5.49867 7.18633 5.93633 6.313 6.813C5.43967 7.68967 5.002 8.752 5 10C4.998 11.248 5.43567 12.3107 6.313 13.188C7.19033 14.0653 8.25267 14.5027 9.5 14.5Z" fill="black"/>
                </svg>
                <input
                    id="spec_field"
                    class="spec_field"
                    type="text"
                    placeholder="{{__('Кислотний пілінг')}}"
                    wire:model="query"
                    wire:keydown="performSearch"
                    autocomplete="off"
                />
                @if(count($services) > 0)
                    <div class="autocomplete-suggestions" style="top:100%">
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
            </div>
            <div wire:key="city-search-container"
                wire:ignore.self
                 class="_flex-display field_section city_field_section">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 11.0005C14.5 9.61924 13.3808 8.5 12.0005 8.5C10.6192 8.5 9.5 9.61924 9.5 11.0005C9.5 12.3808 10.6192 13.5 12.0005 13.5C13.3808 13.5 14.5 12.3808 14.5 11.0005Z" stroke="#25324B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9995 21.5C10.801 21.5 4.5 16.3984 4.5 11.0633C4.5 6.88664 7.8571 3.5 11.9995 3.5C16.1419 3.5 19.5 6.88664 19.5 11.0633C19.5 16.3984 13.198 21.5 11.9995 21.5Z" stroke="#25324B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input
                    id="city_field"
                    class="city_field"
                    type="text"
                    placeholder="Київ"
                    wire:model.live.debounce.300ms="search"
                    autocomplete="off"
                    wire:focus="showDropdown = true"
                    wire:blur="hideDropdown"
                />
                @if($showDropdown && count($filteredCities) > 0)
                    <div class="autocomplete-suggestions" style="top:100%">
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
            </div>
            <div class="_flex-display field_section radius_field_section">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                    <path d="M12 4.5C14.2 4.5 16 6.3 16 8.5C16 10.6 13.9 14 12 16.4C10.1 13.9 8 10.6 8 8.5C8 6.3 9.8 4.5 12 4.5ZM12 2.5C8.7 2.5 6 5.2 6 8.5C6 13 12 19.5 12 19.5C12 19.5 18 12.9 18 8.5C18 5.2 15.3 2.5 12 2.5ZM12 6.5C10.9 6.5 10 7.4 10 8.5C10 9.6 10.9 10.5 12 10.5C13.1 10.5 14 9.6 14 8.5C14 7.4 13.1 6.5 12 6.5ZM20 19.5C20 21.7 16.4 23.5 12 23.5C7.6 23.5 4 21.7 4 19.5C4 18.2 5.2 17.1 7.1 16.3L7.7 17.2C6.7 17.7 6 18.3 6 19C6 20.4 8.7 21.5 12 21.5C15.3 21.5 18 20.4 18 19C18 18.3 17.3 17.7 16.2 17.2L16.8 16.3C18.8 17.1 20 18.2 20 19.5Z" fill="black"/>
                </svg>
                <select wire:model="radius" id="radius_field" class="radius_field" name="radius">
                    <option value="">---</option>
                    <option value="5">до 5 км</option>
                    <option value="15">до 15 км</option>
                    <option value="30">до 30 км</option>
                </select>
            </div>
            <button type="submit" class="btn rose_btn">{{__('Знайти')}}</button>
        </form>
    </div>

    <div class="_flex-display home_search_specials">
        @if($service_form && count($service_form) > 0)
            <div class="home_search_specials_text">{{__('Популярне')}} :</div>
            @foreach($service_form as $service)
                <div class="home_search_specials_value"
                     wire:click="selectPopularService({{ $service->id }}, '{{ $service->name }}')">
                    {{ $service->name }}@if (! $loop->last),@endif
                </div>
            @endforeach
        @endif
    </div>
</div>
