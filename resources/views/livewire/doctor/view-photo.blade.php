<div>
    <div class="_flex-display _align-stretch photo_list_block">
        @forelse($photos as $photo)
            <div class="photo_item">
                <div class="photo_item_img">
                    <div class="_flex-display comparison-container {{ $photo->orientation === 'vertical' ? '_flex-column' : '_flex-row' }}">
                        <img src="{{ asset('uploads/'.$photo->photo_before) }}">
                        <img src="{{ asset('uploads/'.$photo->photo_after) }}">
                    </div>
                </div>
                <p><b>{{__('Процедура')}}:</b> {{ $photo->procedure }}</p>
                <p><b>{{__('Препарат')}}:</b> {{ $photo->product }}</p>
            </div>
        @empty
            <p>{{__('Фото відсутні')}}</p>
        @endforelse
    </div>
    @if($photos->hasPages())
        <ul class="_flex-display _justify-content-center _align-center pagination">
             Previous Page
            @if($photos->onFirstPage())

            @else
                <li><a wire:click="previousPage" class="_flex-display _justify-content-center _align-center">
                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                        </svg>
                    </a></li>
            @endif
             Page Numbers
            @foreach ($photos->getUrlRange(1, $photos->lastPage()) as $page => $url)
                @if($page === $photos->currentPage())
                    <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @else
                    <li><a wire:click="gotoPage({{ $page }})" class="_flex-display _justify-content-center _align-center" href="#">{{ $page }}</a></li>
                @endif
            @endforeach
             Next Page
            @if ($photos->hasMorePages())
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
