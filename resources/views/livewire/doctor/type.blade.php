<div>
    <div class="_flex-display _align-center spec_register1_addresses">
        @foreach($types as $index => $type)
            <div class="_flex-display _align-center spec_register1_line spec_register1_type">
                <span>{{ $type }}</span>
                <button wire:click="deleteType({{ $index }})" type="button">
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
        @endforeach
    </div>
    <div class="search_field search_field_input">
        <input
            id="add_spec"
            class="add_spec"
            type="text"
            placeholder="{{__('Ваша спеціальність')}}"
            wire:model.defer="newType"
            wire:keydown.enter="addType"
            wire:blur="addType"
        />
    </div>
</div>
