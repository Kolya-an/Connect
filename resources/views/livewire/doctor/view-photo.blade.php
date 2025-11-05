<div>
    <div class="_flex-display _justify-content-between _align-stretch photo_list_block">
        @forelse($photos as $photo)
            <div class="photo_item">
                <a class="photo_item_img"><img src="{{ asset('uploads/'.$photo->photo) }}" alt=""></a>
                <a class="photo_name">Некрасова Анна</a>
                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                    <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"></path>
                        </svg>
                        <p><b>4.8</b> (105)</p>
                    </div>
                    <div class="_flex-display _align-bottom top_docs-city">
                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p><b>м. Київ</b></p>
                    </div>
                </div>
                <p><b>{{__('Процедура')}}:</b> {{ $photo->procedure }}</p>
                <p><b>{{__('Препарат')}}:</b> {{ $photo->product }}</p>
            </div>
        @empty
            <p>Фото відсутні</p>
        @endforelse

    </div>
    @if($photos->hasPages())
        <ul class="_flex-display _justify-content-center _align-center pagination">
            {{-- Previous Page --}}
            @if($photos->onFirstPage())

            @else
                <li><a wire:click="previousPage" class="_flex-display _justify-content-center _align-center">
                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                        </svg>
                    </a></li>
            @endif
            {{-- Page Numbers --}}
            @foreach ($photos->getUrlRange(1, $photos->lastPage()) as $page => $url)
                @if($page === $photos->currentPage())
                    <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @else
                    <li><a wire:click="gotoPage({{ $page }})" class="_flex-display _justify-content-center _align-center" href="#">{{ $page }}</a></li>
                @endif
            @endforeach
            {{-- Next Page --}}
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
