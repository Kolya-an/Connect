<main class="news">
    <div id="photo_top">
        <div class="container">
            <div class="search_banner">
                <div class="search_banner_title">
                    <h3>
                        @if($category)
                            {{ $category->title }}
                        @else
                            Дізнайся про важливе. <span>Новини в світі краси, поради</span>
                        @endif
                    </h3>
                    <svg viewBox="0 0 587.021 7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="587.020508" height="7.000000" fill="none" customFrame="#000000">
                        <path id="Vector 1" d="M0.0102539 5.5L587.01 1.5" stroke="rgb(243,150,162)" stroke-width="3" />
                    </svg>
                </div>
                <div class="home_search_bg _minwidth769"><img src="" alt=""></div>
            </div>
        </div>
    </div>
    <div id="news_list">
        <div class="container">
            <div class="_flex-display _align-center select_cats">
                @foreach($categories as $category)
                    <a wire:click="setCategory({{ $category->id }})"
                       class="btn {{ $selectedCategory === $category->id ? 'rose_btn' : 'white_rose_btn' }}">
                        {{ $category->title }}
                    </a>
                @endforeach
            </div>
            <div class="_flex-display _justify-content-between number_sort">
                @php
                    $number = $news->count();
                    $lastDigit = $number % 10;
                @endphp
                <div class="number_news">{{ $news->count() }}
                    @if($lastDigit == 1)
                        {{__('стаття')}}
                    @elseif($lastDigit > 1 && $lastDigit < 5)
                        {{__('статті')}}
                    @else
                        {{__('статтей')}}
                    @endif
                </div>
                <div class="sort_news">{{__('Впорядкувати за')}}: <span class="sort_news_title">{{ $sortField === 'views' ? 'популярністю' : 'назвою' }}</span> <svg viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10.000000" height="6.000000" fill="none" customFrame="#000000">
                        <path id="Vector" d="M5.54025 5.77093C5.3994 5.9176 5.20839 6 5.00923 6C4.81007 6 4.61906 5.9176 4.47821 5.77093L0.229299 1.34511C0.157562 1.27294 0.100342 1.18661 0.0609786 1.09116C0.0216147 0.995705 0.000894977 0.893043 2.83584e-05 0.789161C-0.00083826 0.68528 0.0181658 0.582259 0.0559312 0.486109C0.0936966 0.38996 0.149467 0.302607 0.219989 0.229149C0.290511 0.15569 0.374371 0.0975976 0.466677 0.0582597C0.558983 0.0189218 0.657887 -0.000873163 0.757616 2.95397e-05C0.857345 0.000932243 0.955903 0.0225147 1.04754 0.0635176C1.13917 0.10452 1.22205 0.164122 1.29134 0.238846L5.00923 4.11154L8.72712 0.238846C8.86878 0.0963322 9.05851 0.0174745 9.25544 0.019257C9.45237 0.0210396 9.64075 0.10332 9.78001 0.248376C9.91927 0.393433 9.99826 0.589659 9.99997 0.794792C10.0017 0.999925 9.92598 1.19755 9.78916 1.34511L5.54025 5.77093Z" fill="rgb(243,150,162)" fill-rule="evenodd" />
                    </svg>
                    <div class="sort_list _display_none">
                        <div class="sort_list_li" wire:click="setSort('views')">{{__('популярністю')}}</div>
                        <div class="sort_list_li" wire:click="setSort('title')">{{__('назвою')}}</div>
                    </div>
                </div>
            </div>
            <div class="_flex-display _justify-content-between _align-stretch news_list_block">
                @foreach($news as $item)
                    <div class="news_item">
                        <a href="{{ route('news.show', $item->slug) }}" class="photo_item_img"><img src="{{ asset('uploads/' . $item->image) }}" alt=""></a>
                        <a href="{{ route('news.show', $item->slug) }}" class="_flex-display _justify-content-between news_item_title">
                            <span>{{ $item->title }}</span>
                            <svg viewBox="0 0 36 35" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36.000000" height="35.000000" fill="none">
                                <path id="Frame 1079" d="M18.5 0C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35L17.5 35C7.83502 35 0 27.165 0 17.5C0 7.83502 7.83502 0 17.5 0L18.5 0Z" fill="rgb(243,150,162)" fill-rule="evenodd" />
                                <path id="Arrow 1" d="M0 -1L13.4536 -1L13.4536 1L0 1L0 -1ZM0.02 0.98L0 1C-0.56 1 -1 0.56 -1 -0C-1 -0.56 -0.56 -1 0 -1L0.02 -0.98L0.02 0.98ZM12.0394 0L7.08966 -4.94975C6.69368 -5.34573 6.69368 -5.96798 7.08966 -6.36396C7.48564 -6.75994 8.1079 -6.75994 8.50388 -6.36396L14.1607 -0.707107C14.5567 -0.311127 14.5567 0.311127 14.1607 0.707107L8.50388 6.36396C8.1079 6.75994 7.48564 6.75994 7.08966 6.36396C6.69368 5.96798 6.69368 5.34573 7.08966 4.94975L12.0394 0Z" fill="rgb(255,255,255)" fill-rule="nonzero" transform="matrix(0.743294,-0.668965,0.668965,0.743294,13,22)" />
                            </svg>
                        </a>
                        <p>{{ $item->preview }}</p>
                    </div>
                @endforeach
            </div>
            @if ($news->hasPages())
                <ul class="_flex-display _justify-content-center _align-center pagination">
                    @if ($news->onFirstPage())

                    @else
                        <li><a wire:navigate href="{{ $news->url(1) }}" class="_flex-display _justify-content-center _align-center"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                <rect id="Icon / Pagination / First" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(51,51,51)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,12.6665,12)" />
                                <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(51,51,51)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,8.27344,12)" />
                            </svg></a></li>
                    @endif
                    @if ($news->onFirstPage())

                    @else
                        <li><a wire:navigate href="{{ $news->previousPageUrl() }}" class="_flex-display _justify-content-center _align-center"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                            </svg>
                        </a></li>
                    @endif
                    @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                        @if ($page == $news->currentPage())
                                <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                        @else
                                <li><a wire:navigate class="_flex-display _justify-content-center _align-center" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                    @if ($news->hasMorePages())
                        <li><a class="_flex-display _justify-content-center _align-center" href="{{ $news->nextPageUrl() }}"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                    <rect id="Icon / Pagination / Next" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                    <path id="Vector" d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                                </svg></a></li>
                    @else

                    @endif
                    @if ($news->hasMorePages())
                        <li><a wire:navigate class="_flex-display _justify-content-center _align-center" href="{{ $news->url($news->lastPage()) }}"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                    <rect id="Icon / Pagination / Last" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                    <path id="Vector" d="M4.2735 4L3.3335 4.94L6.38683 8L3.3335 11.06L4.2735 12L8.2735 8L4.2735 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                                    <path id="Vector" d="M8.66656 4L7.72656 4.94L10.7799 8L7.72656 11.06L8.66656 12L12.6666 8L8.66656 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                                </svg></a></li>
                    @else

                    @endif
                </ul>
            @endif
        </div>
    </div>
</main>
