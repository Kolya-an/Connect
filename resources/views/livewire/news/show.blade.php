<main class="news-article">
    <div id="article_top">
        <div class="container">
            <div class="_flex-display _justify-content-between _align-center article_banner">
                <div class="article_banner_title">
                    <svg viewBox="0 0 58 58" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="58.000000" height="58.000000" fill="none" clip-path="url(#clipPath_0)" customFrame="url(#clipPath_0)">
                        <defs>
                            <clipPath id="clipPath_0">
                                <rect width="58.000000" height="58.000000" x="0.000000" y="0.000000" rx="29.000000" fill="rgb(255,255,255)" />
                            </clipPath>
                        </defs>
                        <rect id="Frame 1081" width="58.000000" height="58.000000" x="0.000000" y="0.000000" rx="29.000000" fill="rgb(255,255,255)" />
                        <path id="“" d="M24.8922 18.4688L26.2173 20.1313C24.2739 21.4146 22.831 22.7563 21.8887 24.1562C21.0053 25.4979 20.5636 26.7521 20.5636 27.9187C20.5636 29.0271 21.2409 29.7562 22.5954 30.1063C23.7733 30.3396 24.7744 30.8646 25.5989 31.6813C26.4234 32.4396 26.8357 33.4896 26.8357 34.8312C26.8357 36.1729 26.3645 37.2812 25.4223 38.1562C24.48 39.0312 23.4199 39.4688 22.2421 39.4688C20.7697 39.4688 19.4446 38.9146 18.2668 37.8063C17.0889 36.6979 16.5 34.8313 16.5 32.2062C16.5 29.8146 17.1773 27.3937 18.5318 24.9438C19.9452 22.4354 22.0654 20.2771 24.8922 18.4688ZM39.5565 18.4688L40.8816 20.1313C38.9382 21.4146 37.4953 22.7563 36.553 24.1562C35.6696 25.4979 35.2279 26.7521 35.2279 27.9187C35.2279 29.0271 35.9052 29.7562 37.2597 30.1063C38.4376 30.3396 39.4388 30.8646 40.2632 31.6813C41.0877 32.4396 41.5 33.4896 41.5 34.8312C41.5 36.1729 41.0289 37.2812 40.0866 38.1562C39.1443 39.0312 38.0842 39.4688 36.9064 39.4688C35.434 39.4688 34.109 38.9146 32.9311 37.8063C31.7532 36.6979 31.1643 34.8313 31.1643 32.2062C31.1643 29.8146 31.8416 27.3937 33.1961 24.9438C34.6095 22.4354 36.7297 20.2771 39.5565 18.4688Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                    </svg>
                    <h1>{{ $news->title }}</h1>
                </div>
                <div class="article_title_image"><img src="{{ asset('uploads/' . $news->image) }}" alt="{{ $news->title }}"></div>
            </div>
        </div>
    </div>
    <div id="article_content">
        <div class="container">

            @foreach($news->content as $block)
                @switch($block['type'])
                    @case('paragraph')
                        {!! $block['data']['content'] !!}
                        @break

                    @case('heading')
                        <{{ $block['data']['level'] }}>{{ $block['data']['heading_text'] }}</{{ $block['data']['level'] }}>
                        @break

                    @case('image_text')
                        <div class="article_image_text">
                            <img src="{{ asset('uploads/' . $block['data']['images']) }}" >
                            <div class="article_image_text_text">
                                {!! $block['data']['content'] !!}
                            </div>
                        </div>
                        @break

                    @case('important')
                        <div class="_flex-display _justify-content-between _align-center article_rose_block">
                            <div class="white-plate">{{__('Важливо!')}}</div>
                            <p>{!! $block['data']['text'] !!}</p>
                        </div>
                        @break
                @endswitch
            @endforeach
        </div>
    </div>
    <div class="container"><a onclick="history.back()" class="btn rose_btn return_btn">{{__('Повернутись назад')}}</a></div>
</main>
