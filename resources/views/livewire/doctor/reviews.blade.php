<div class="spec_reviews">
    <div class="_flex-display _align-center about_rating_service">
        {{--@foreach($reviews as $key => $review)
            @php
                $medical = $medical + $review->medical;
                $service = $service + $review->service;
            @endphp
        @endforeach--}}
        {{--@php
            $medical_all = $medical / $key;
            $service_all = $service / $key;
        @endphp--}}
        <div class="_flex-display _align-center about_rating_service_rating">
            <svg viewBox="0 0 35 35" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="35.000000" height="35.000000" fill="none" customFrame="#000000">
                <path id="Star 1" d="M21.3616 11.8849C21.4018 12.0085 21.517 12.0922 21.647 12.0922L33.2202 12.0922C33.5108 12.0922 33.6316 12.4641 33.3965 12.6349L24.0336 19.4375C23.9284 19.5139 23.8844 19.6493 23.9246 19.7729L27.5009 30.7797C27.5907 31.0561 27.2744 31.2859 27.0393 31.1151L17.6763 24.3125C17.5712 24.2361 17.4288 24.2361 17.3237 24.3125L7.96073 31.1151C7.72561 31.2859 7.40927 31.0561 7.49907 30.7797L11.0754 19.7729C11.1156 19.6493 11.0716 19.5139 10.9664 19.4375L1.60348 12.6349C1.36837 12.4641 1.4892 12.0922 1.77982 12.0922L13.353 12.0922C13.483 12.0922 13.5982 12.0085 13.6384 11.8849L17.2147 0.878116C17.3045 0.601722 17.6955 0.601722 17.7853 0.878116L21.3616 11.8849Z" fill="rgb(243,150,162)" fill-rule="evenodd" />
            </svg>
            <span>{{round(($medicalAvg + $serviceAvg)/2, 1)}}</span>
        </div>
        <div class="about_rating_service_service">
            <div class="_flex-display _justify-content-between _align-top about_rating_service_service_line">
                <p>{{__('Результат процедури')}}</p>
                <div class="slider"><div class="slider_full" style="width:{{number_format($medicalAvg)*20}}%"></div></div>
                <div class="slider_number">{{ number_format($medicalAvg, 1) }}</div>
            </div>
            <div class="_flex-display _justify-content-between _align-center about_rating_service_service_line">
                <p>{{__('Сервіс')}}</p>
                <div class="slider"><div class="slider_full" style="width:{{number_format($serviceAvg)*20}}%"></div></div>
                <div class="slider_number">{{ number_format($serviceAvg, 1) }}</div>
            </div>
        </div>
    </div>
    @foreach($reviews as $review)
        <div class="spec_review">
            <div class="_flex-display _justify-content-between spec_review_top">
                <div class="_flex-display _align-center spec_review_left">
                    @if(isset($review->appointment->user->patient->photo))
                        <div class="spec_review_image">
                            <img src="{{ asset('uploads/' . $review->appointment->user->patient->photo) }}" alt="">
                        </div>
                    @endif
                    <div class="spec_review_name_stars">
                        <p>{{ $review->appointment->user->name ?? '' }} {{ $review->appointment->user->patient->second_name ?? '' }}</p>
                        <p>{{ $review->medical }} {{ $review->service }}</p>
                        <div class="_flex-display _align-center spec_review_stars">
                            @for($i=0;$i<round(($review->medical + $review->service)/2);$i++)
                                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none" customFrame="#000000">
                                    <path id="Star 5" d="M9.72876 5.32057C9.76892 5.44418 9.88411 5.52786 10.0141 5.52786L14.6851 5.52786C14.9758 5.52786 15.0966 5.89975 14.8615 6.07057L11.0825 8.81616C10.9774 8.89255 10.9334 9.02796 10.9735 9.15157L12.417 13.594C12.5068 13.8704 12.1904 14.1003 11.9553 13.9294L8.17634 11.1838C8.07119 11.1075 7.92881 11.1075 7.82366 11.1838L4.04469 13.9294C3.80957 14.1003 3.49323 13.8704 3.58303 13.594L5.02648 9.15157C5.06664 9.02796 5.02264 8.89255 4.91749 8.81616L1.13852 6.07057C0.903403 5.89975 1.02424 5.52786 1.31485 5.52786L5.98593 5.52786C6.11589 5.52786 6.23108 5.44418 6.27124 5.32057L7.71468 0.878116C7.80449 0.601722 8.19551 0.601722 8.28532 0.878116L9.72876 5.32057Z" fill="rgb(243,150,162)" fill-rule="evenodd" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="spec_review_date">{{ $review->created_at->translatedFormat('d F Y') }}</div>
            </div>
            @if($review->text)
                <p>{{ $review->text }}</p>
            @endif
        </div>
    @endforeach
    @if($reviews->hasPages())
        <ul class="_flex-display _justify-content-center _align-center pagination">
            {{-- Previous Page --}}
            @if($reviews->onFirstPage())

            @else
                <li><a wire:click="previousPage" class="_flex-display _justify-content-center _align-center">
                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                        </svg>
                    </a></li>
            @endif
            {{-- Page Numbers --}}
            @foreach ($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                @if($page === $reviews->currentPage())
                    <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @else
                    <li><a wire:click="gotoPage({{ $page }})" class="_flex-display _justify-content-center _align-center" href="#">{{ $page }}</a></li>
                @endif
            @endforeach
            {{-- Next Page --}}
            @if ($reviews->hasMorePages())
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
