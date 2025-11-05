<div>
    <div class="_flex-display _justify-content-between _align-center doctor_right_prices">

        @forelse($services as $service)
            <div class="_flex-display _justify-content-between doctor_right_price"><span>{{$service->name}}</span>
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
</div>
