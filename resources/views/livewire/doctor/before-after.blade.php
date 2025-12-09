<div class="spec_register_wrapper">
    <h5>{{__('Ваші - До/Після')}}</h5>
    <button wire:click="$set('showAddModal', true)"
            class="_flex-display _justify-content-center _align-center btn white_rose_btn add_photo add_photo_page add_photo_btn">
        <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14.000000" height="14.000000" fill="none">
            <rect id="ic:round-plus" width="14.000000" height="14.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
            <path id="Vector" d="M13 8L8 8L8 13C8 13.2652 7.89464 13.5196 7.70711 13.7071C7.51957 13.8946 7.26522 14 7 14C6.73478 14 6.48043 13.8946 6.29289 13.7071C6.10536 13.5196 6 13.2652 6 13L6 8L1 8C0.734784 8 0.48043 7.89464 0.292893 7.70711C0.105357 7.51957 0 7.26522 0 7C0 6.73478 0.105357 6.48043 0.292893 6.29289C0.48043 6.10536 0.734784 6 1 6L6 6L6 1C6 0.734784 6.10536 0.480429 6.29289 0.292893C6.48043 0.105357 6.73478 -8.88178e-16 7 0C7.26522 -8.88178e-16 7.51957 0.105357 7.70711 0.292893C7.89464 0.480429 8 0.734784 8 1L8 6L13 6C13.2652 6 13.5196 6.10536 13.7071 6.29289C13.8946 6.48043 14 6.73478 14 7C14 7.26522 13.8946 7.51957 13.7071 7.70711C13.5196 7.89464 13.2652 8 13 8Z" fill="rgb(243,150,162)" fill-rule="nonzero" />
        </svg> {{__('Додати фото')}}
    </button>
    <p>{{__('Додаючи фото, лікар повинен мати згоду на це від пацієнта!')}}</p>
    <div class="_flex-display _align-stretch photo_list_block">
        @forelse($photos as $item)
            <div class="photo_item">
                <a wire:click="deletePhoto({{ $item->id }})" class="photo_item_img">
                    <img src="{{ asset('uploads/'.$item->photo) }}" alt="{{ $item->procedure }}">
                    <div class="_flex-display _justify-content-center _align-center delete_image _display_none">
                        <svg width="23" height="29" viewBox="0 0 23 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.58333 25.3333C1.58333 26.1732 1.91696 26.9786 2.51083 27.5725C3.10469 28.1664 3.91015 28.5 4.75 28.5H17.4167C18.2565 28.5 19.062 28.1664 19.6558 27.5725C20.2497 26.9786 20.5833 26.1732 20.5833 25.3333V6.33333H1.58333V25.3333ZM4.75 9.5H17.4167V25.3333H4.75V9.5ZM16.625 1.58333L15.0417 0H7.125L5.54167 1.58333H0V4.75H22.1667V1.58333H16.625Z" fill="white"/>
                        </svg>
                    </div>
                </a>
                <p><b>{{__('Процедура:')}}</b> {{ $item->procedure }}</p>
                <p><b>{{__('Препарат:')}}</b> {{ $item->product }}</p>

            </div>
        @empty
            <p>{{__('Фото поки що немає')}}</p>
        @endforelse
    </div>

    @if($showAddModal)
        <div id="add_photo" class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_info_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Додати До/Після')}}</h4>
                    <button wire:click="$set('showAddModal', false)" id="window_close" class="window_close">
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
                <div class="_flex-display _justify-content-between _align-center">
                    <button type="button"
                            onclick="document.getElementById('photoInput').click()"
                            class="_flex-display _justify-content-center _align-center btn white_rose_btn add_photo add_photo_page">
                        <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14.000000" height="14.000000" fill="none">
                            <rect id="ic:round-plus" width="14.000000" height="14.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M13 8L8 8L8 13C8 13.2652 7.89464 13.5196 7.70711 13.7071C7.51957 13.8946 7.26522 14 7 14C6.73478 14 6.48043 13.8946 6.29289 13.7071C6.10536 13.5196 6 13.2652 6 13L6 8L1 8C0.734784 8 0.48043 7.89464 0.292893 7.70711C0.105357 7.51957 0 7.26522 0 7C0 6.73478 0.105357 6.48043 0.292893 6.29289C0.48043 6.10536 0.734784 6 1 6L6 6L6 1C6 0.734784 6.10536 0.480429 6.29289 0.292893C6.48043 0.105357 6.73478 -8.88178e-16 7 0C7.26522 -8.88178e-16 7.51957 0.105357 7.70711 0.292893C7.89464 0.480429 8 0.734784 8 1L8 6L13 6C13.2652 6 13.5196 6.10536 13.7071 6.29289C13.8946 6.48043 14 6.73478 14 7C14 7.26522 13.8946 7.51957 13.7071 7.70711C13.5196 7.89464 13.2652 8 13 8Z" fill="rgb(243,150,162)" fill-rule="nonzero" />
                        </svg> {{__('Додати фото')}}
                    </button>
                    @if ($photo)
                        <div style="margin-top:10px;">
                            <img src="{{ $photo->temporaryUrl() }}" alt="Preview" style="width:100px; border-radius:5px;">
                        </div>
                    @endif
                </div>
                <input type="file" id="photoInput" wire:model="photo" accept="image/*" style="display:none">
                @error('photo')
                <span class="error" style="color:red">{{ $message }}</span>
                @enderror
                <div class="search_field search_field_input">
                    <input type="text"
                           wire:model="procedure"
                           placeholder="{{__('Процедура')}}"
                           class="add_desc_photo"
                           style="padding:0 10px;background:none">
                @error('procedure') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="search_field search_field_input">
                    <input type="text"
                           wire:model="product"
                           placeholder="{{__('Препарат')}}"
                           class="add_desc_photo"
                           style="padding:0 10px;background:none">
                </div>
                <button wire:click="addPhoto" class="btn rose_btn submit_window">{{__('Зберегти')}}</button>
            </div>
        </div>
    @endif
</div>
