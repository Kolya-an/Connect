<div class="spec_register1_right">
    <div class="_flex-display client_reg_right">
        <div class="spec_register1_left_block spec_register1_left_block_city">
            <h5>{{__('Місто')}}</h5>
            <div class="_flex-display _align-center spec_register1_cities">
                <div class="_flex-display _align-center spec_register1_line spec_register1_city">
                    <span>{{ $city ?: 'Місто' }}</span>
                    <button wire:click="resetCity">
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
                            <path id="Vector" d="M11.9999 12.6417L9.75404 14.8875C9.67001 14.9715 9.56306 15.0135 9.4332 15.0135C9.30334 15.0135 9.1964 14.9715 9.11237 14.8875C9.02834 14.8035 8.98633 14.6965 8.98633 14.5667C8.98633 14.4368 9.02834 14.3299 9.11237 14.2458L11.3582 12L9.11237 9.75416C9.02834 9.67013 8.98633 9.56319 8.98633 9.43332C8.98633 9.30346 9.02834 9.19652 9.11237 9.11249C9.1964 9.02846 9.30334 8.98645 9.4332 8.98645C9.56306 8.98645 9.67001 9.02846 9.75404 9.11249L11.9999 11.3583L14.2457 9.11249C14.3297 9.02846 14.4367 8.98645 14.5665 8.98645C14.6964 8.98645 14.8033 9.02846 14.8874 9.11249C14.9714 9.19652 15.0134 9.30346 15.0134 9.43332C15.0134 9.56319 14.9714 9.67013 14.8874 9.75416L12.6415 12L14.8874 14.2458C14.9714 14.3299 15.0134 14.4368 15.0134 14.5667C15.0134 14.6965 14.9714 14.8035 14.8874 14.8875C14.8033 14.9715 14.6964 15.0135 14.5665 15.0135C14.4367 15.0135 14.3297 14.9715 14.2457 14.8875L11.9999 12.6417Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </g>
                        </svg>
                    </button>
                </div>
            </div>
            <button wire:click="$set('showCityModal', true)" class="btn white_rose_btn add_btn add_city">{{__('Змінити місто')}}</button>
        </div>
        <div class="spec_register1_left_block  spec_register1_left_block_sex">
            <h5>{{__('Ваша стать')}}</h5>
            <label class="custom-radio">
                <input type="radio" wire:model="sex" value="female">
                <span></span> {{__('Жінка')}}
            </label>
            <label class="custom-radio">
                <input type="radio" wire:model="sex" value="male">
                <span></span> {{__('Чоловік')}}
            </label>
           {{-- <label class="custom-radio">
                <input type="radio" wire:model="sex" value="nonbinary">
                <span></span> {{__('Небінарна особістість')}}
            </label>--}}
        </div>
    </div>
    <label class="_flex-display _align-center more_filter_checkbox">
        <input id="check_subscribe" type="checkbox" wire:model="notification">
        <span class="checkmark"></span>
        <span class="check_title">{{__('Отримувати сповіщення про акції та знижки')}}</span>
    </label>


    <button wire:click="save" class="rose_btn register_next">{{__('Зберегти')}}</button>
    @if (session()->has('message'))
        <p class="mt-3 text-green-600">{{ session('message') }}</p>
    @endif

    @if ($showCityModal)
        <div wire:key="city-modal" id="add_city" class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_info_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Місто')}}</h4>
                    <button wire:click="$set('showCityModal', false)" id="window_close" class="window_close">
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
                    </button>
                </div>
                <div class="search_field search_field_input">
                <input
                    id="add_city"
                    class="add_city"
                    type="text"
                    placeholder="{{__('Введіть місто..')}}"
                    wire:model.live="search"
                />
                </div>
                <ul>
                    @forelse ($filteredCities as $item)
                        <li wire:click="selectCity('{{ $item }}')"
                            class="px-3 py-1 hover:bg-blue-100 cursor-pointer">
                            {{ $item }}
                        </li>
                    @empty
                        <li class="px-3 py-2 text-gray-500">{{__('Не знайдено')}}</li>
                    @endforelse
                </ul>
                @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
    @endif
</div>
