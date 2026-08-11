<div>
    <div class="_flex-display _justify-content-between _align-center doctor_right_prices">

        @forelse($services as $service)
            <div class="_flex-display _justify-content-between doctor_right_price">
                <span wire:click="openPhoneModal" style="cursor:pointer;">{{$service->name}}</span>
                <span>
                    @if($service->pivot->prefix === 'for')
                        {{__('від')}}&nbsp;
                    @endif
                    {{ $service->pivot->price }}₴</span></div>
        @empty
            <p>Послуги відсутні</p>
        @endforelse
    </div>
    @if($services->hasPages())
        <ul class="_flex-display _justify-content-center _align-center pagination">
            {{-- Previous Page --}}
            @if($services->onFirstPage())

            @else
                <li><a wire:click="previousPage" class="_flex-display _justify-content-center _align-center">
                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                        </svg>
                    </a></li>
            @endif
            {{-- Page Numbers --}}
            @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                @if($page === $services->currentPage())
                    <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @else
                    <li><a wire:click="gotoPage({{ $page }})" class="_flex-display _justify-content-center _align-center" href="#">{{ $page }}</a></li>
                @endif
            @endforeach
            {{-- Next Page --}}
            @if ($services->hasMorePages())
                <li><a wire:click="nextPage" wire:loading.attr="disabled" class="_flex-display _justify-content-center _align-center" href="#"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Next" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </svg>
                    </a></li>
            @else

            @endif
        </ul>
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
