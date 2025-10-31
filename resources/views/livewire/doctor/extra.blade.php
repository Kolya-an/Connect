<div class="_flex-display _justify-content-between spec_register1_right_block">
    <div class="spec_register1_right_forms">
        <h5>{{__('Додаткова освіта та сертифікати')}}</h5>
        <div class="add_education_block">
            @foreach($extras as $index => $ext)
            <div wire:key="ext-{{ $ext['id'] }}" class="_flex-display _align-center add_reg_block add_education_top">
                <div class="search_field search_field_input">
                    <input
                        id="add_title_education"
                        class="add_title_education"
                        type="text"
                        placeholder="{{__('Назва навчального закладу')}}"
                        value="{{ $ext['title'] }}"
                        wire:blur="updateField({{ $ext['id'] }}, 'title', $event.target.value)"
                    />
                </div>
                <div class="search_field search_field_input">
                    <input
                        id="add_education_dates"
                        class="add_education_dates"
                        type="text"
                        placeholder="{{__('Період навчання')}}"
                        value="{{ $ext['period'] }}"
                        wire:blur="updateField({{ $ext['id'] }}, 'period', $event.target.value)"
                    />
                </div>
                <button type="button" wire:click="removeExtra({{ $ext['id'] }})">
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
                <textarea
                    id="add_desc_education"
                    class="add_desc_education"
                    placeholder="{{__('Опис')}}"
                    wire:blur="updateField({{ $ext['id'] }}, 'desc', $event.target.value)"
                >{{ $ext['desc'] }}</textarea>
            </div>
            @endforeach
        </div>
        <button wire:click="addExtra" class="btn white_rose_btn add_btn add_address">
            <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14.000000" height="14.000000" fill="none">
                <rect id="ic:round-plus" width="14.000000" height="14.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                <path id="Vector" d="M13 8L8 8L8 13C8 13.2652 7.89464 13.5196 7.70711 13.7071C7.51957 13.8946 7.26522 14 7 14C6.73478 14 6.48043 13.8946 6.29289 13.7071C6.10536 13.5196 6 13.2652 6 13L6 8L1 8C0.734784 8 0.48043 7.89464 0.292893 7.70711C0.105357 7.51957 0 7.26522 0 7C0 6.73478 0.105357 6.48043 0.292893 6.29289C0.48043 6.10536 0.734784 6 1 6L6 6L6 1C6 0.734784 6.10536 0.480429 6.29289 0.292893C6.48043 0.105357 6.73478 -8.88178e-16 7 0C7.26522 -8.88178e-16 7.51957 0.105357 7.70711 0.292893C7.89464 0.480429 8 0.734784 8 1L8 6L13 6C13.2652 6 13.5196 6.10536 13.7071 6.29289C13.8946 6.48043 14 6.73478 14 7C14 7.26522 13.8946 7.51957 13.7071 7.70711C13.5196 7.89464 13.2652 8 13 8Z" fill="rgb(243,150,162)" fill-rule="nonzero" />
            </svg> {{__('Додати освіту')}}
        </button>
    </div>
    <div class="spec_register1_right_photos">
        <h5>{{__('Фото дипломів')}}</h5>
        <button wire:click="$dispatch('trigger-certificate-input')" class="btn white_rose_btn add_btn add_address">
            <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14.000000" height="14.000000" fill="none">
                <rect id="ic:round-plus" width="14.000000" height="14.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                <path id="Vector" d="M13 8L8 8L8 13C8 13.2652 7.89464 13.5196 7.70711 13.7071C7.51957 13.8946 7.26522 14 7 14C6.73478 14 6.48043 13.8946 6.29289 13.7071C6.10536 13.5196 6 13.2652 6 13L6 8L1 8C0.734784 8 0.48043 7.89464 0.292893 7.70711C0.105357 7.51957 0 7.26522 0 7C0 6.73478 0.105357 6.48043 0.292893 6.29289C0.48043 6.10536 0.734784 6 1 6L6 6L6 1C6 0.734784 6.10536 0.480429 6.29289 0.292893C6.48043 0.105357 6.73478 -8.88178e-16 7 0C7.26522 -8.88178e-16 7.51957 0.105357 7.70711 0.292893C7.89464 0.480429 8 0.734784 8 1L8 6L13 6C13.2652 6 13.5196 6.10536 13.7071 6.29289C13.8946 6.48043 14 6.73478 14 7C14 7.26522 13.8946 7.51957 13.7071 7.70711C13.5196 7.89464 13.2652 8 13 8Z" fill="rgb(243,150,162)" fill-rule="nonzero" />
            </svg> {{__('Додати фото')}}
        </button>
        <input type="file" wire:model="photo" x-on:trigger-certificate-input.window="$el.click()" class="_display_none">
        @if(!empty($photos))
            <div class="_flex-display _justify-content-between spec_about_docs_list">
                @foreach($photos as $photo)
                    <a target="_blank"
                       wire:contextmenu.prevent="removeCertificateImage('{{ $photo }}')"
                       title="Правий клік — видалити"
                    ><img src="{{ asset('uploads/extra/' . $photo) }}" alt=""></a>
                @endforeach
            </div>
        @endif
    </div>
</div>
