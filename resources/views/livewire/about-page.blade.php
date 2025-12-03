<main class="about_pages
    @if($about->slug === 'about-doctor')
        about_spec_page
    @elseif($about->slug === 'about-user')
        about_pac_page
    @endif
    ">
    <div id="page_banner">
        <div class="container">
            <div class="page_banner_container">
                <div class="page_banner_block">
                    <p>
                        @if($about->first_name)
                        <span class="h1-title">{{ $about->first_name }} <span class="h1-line"><svg xmlns="http://www.w3.org/2000/svg" width="255" height="14" viewBox="0 0 255 14" fill="none">
  <path d="M0.5 12L254 2" stroke="#F396A2" stroke-width="3"/>
</svg></span></span>
                        @endif
                        @if($about->first_sentience){{ $about->first_sentience }}@endif
                    </p>
                    @if($about->slug === 'about-user')
                        @if($about->second_sentience)<p class="p_rose">{{ $about->second_sentience }}</p>@endif
                    @else
                        @if($about->second_sentience)<p>{{ $about->second_sentience }}</p>@endif
                    @endif
                    @if($about->slug !== 'about-doctor')
                        <div class="_flex-display home_banner_bottom">
                            <div class="home_banner_images"><img src="{{ asset('image/home_banner_images.png') }}" alt=""></div>
                            <div class="home_banner_bottom_text">
                                <div class="_flex-display rating_stars">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.71468 0.848329C6.80449 0.571936 7.19551 0.571937 7.28532 0.84833L8.72876 5.29078C8.76892 5.41439 8.88411 5.49808 9.01408 5.49808H13.6851C13.9758 5.49808 14.0966 5.86996 13.8615 6.04078L10.0825 8.78637C9.97736 8.86277 9.93336 8.99817 9.97352 9.12178L11.417 13.5642C11.5068 13.8406 11.1904 14.0705 10.9553 13.8996L7.17634 11.1541C7.07119 11.0777 6.92881 11.0777 6.82366 11.1541L3.04469 13.8996C2.80957 14.0705 2.49323 13.8406 2.58303 13.5642L4.02648 9.12178C4.06664 8.99817 4.02264 8.86276 3.91749 8.78637L0.138516 6.04078C-0.0965979 5.86996 0.0242358 5.49808 0.314853 5.49808H4.98593C5.11589 5.49808 5.23108 5.41439 5.27124 5.29078L6.71468 0.848329Z" fill="#FFDDDF"/>
                                    </svg>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.71468 0.848329C6.80449 0.571936 7.19551 0.571937 7.28532 0.84833L8.72876 5.29078C8.76892 5.41439 8.88411 5.49808 9.01408 5.49808H13.6851C13.9758 5.49808 14.0966 5.86996 13.8615 6.04078L10.0825 8.78637C9.97736 8.86277 9.93336 8.99817 9.97352 9.12178L11.417 13.5642C11.5068 13.8406 11.1904 14.0705 10.9553 13.8996L7.17634 11.1541C7.07119 11.0777 6.92881 11.0777 6.82366 11.1541L3.04469 13.8996C2.80957 14.0705 2.49323 13.8406 2.58303 13.5642L4.02648 9.12178C4.06664 8.99817 4.02264 8.86276 3.91749 8.78637L0.138516 6.04078C-0.0965979 5.86996 0.0242358 5.49808 0.314853 5.49808H4.98593C5.11589 5.49808 5.23108 5.41439 5.27124 5.29078L6.71468 0.848329Z" fill="#FFDDDF"/>
                                    </svg>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.71468 0.848329C6.80449 0.571936 7.19551 0.571937 7.28532 0.84833L8.72876 5.29078C8.76892 5.41439 8.88411 5.49808 9.01408 5.49808H13.6851C13.9758 5.49808 14.0966 5.86996 13.8615 6.04078L10.0825 8.78637C9.97736 8.86277 9.93336 8.99817 9.97352 9.12178L11.417 13.5642C11.5068 13.8406 11.1904 14.0705 10.9553 13.8996L7.17634 11.1541C7.07119 11.0777 6.92881 11.0777 6.82366 11.1541L3.04469 13.8996C2.80957 14.0705 2.49323 13.8406 2.58303 13.5642L4.02648 9.12178C4.06664 8.99817 4.02264 8.86276 3.91749 8.78637L0.138516 6.04078C-0.0965979 5.86996 0.0242358 5.49808 0.314853 5.49808H4.98593C5.11589 5.49808 5.23108 5.41439 5.27124 5.29078L6.71468 0.848329Z" fill="#FFDDDF"/>
                                    </svg>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.71468 0.848329C6.80449 0.571936 7.19551 0.571937 7.28532 0.84833L8.72876 5.29078C8.76892 5.41439 8.88411 5.49808 9.01408 5.49808H13.6851C13.9758 5.49808 14.0966 5.86996 13.8615 6.04078L10.0825 8.78637C9.97736 8.86277 9.93336 8.99817 9.97352 9.12178L11.417 13.5642C11.5068 13.8406 11.1904 14.0705 10.9553 13.8996L7.17634 11.1541C7.07119 11.0777 6.92881 11.0777 6.82366 11.1541L3.04469 13.8996C2.80957 14.0705 2.49323 13.8406 2.58303 13.5642L4.02648 9.12178C4.06664 8.99817 4.02264 8.86276 3.91749 8.78637L0.138516 6.04078C-0.0965979 5.86996 0.0242358 5.49808 0.314853 5.49808H4.98593C5.11589 5.49808 5.23108 5.41439 5.27124 5.29078L6.71468 0.848329Z" fill="#FFDDDF"/>
                                    </svg>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.71468 0.848329C6.80449 0.571936 7.19551 0.571937 7.28532 0.84833L8.72876 5.29078C8.76892 5.41439 8.88411 5.49808 9.01408 5.49808H13.6851C13.9758 5.49808 14.0966 5.86996 13.8615 6.04078L10.0825 8.78637C9.97736 8.86277 9.93336 8.99817 9.97352 9.12178L11.417 13.5642C11.5068 13.8406 11.1904 14.0705 10.9553 13.8996L7.17634 11.1541C7.07119 11.0777 6.92881 11.0777 6.82366 11.1541L3.04469 13.8996C2.80957 14.0705 2.49323 13.8406 2.58303 13.5642L4.02648 9.12178C4.06664 8.99817 4.02264 8.86276 3.91749 8.78637L0.138516 6.04078C-0.0965979 5.86996 0.0242358 5.49808 0.314853 5.49808H4.98593C5.11589 5.49808 5.23108 5.41439 5.27124 5.29078L6.71468 0.848329Z" fill="#FFDDDF"/>
                                    </svg>
                                </div>
                                <p><b>+3000</b> {{__('перевіренних косметологіва')}}</p>
                            </div>
                        </div>
                    @endif
                </div>
                @if($about->second_sentience)
                    <div class="page_banner_block">
                        {!! $about->second_text !!}
                        @if($about->slug !== 'about-doctor')
                            <a class="btn rose_btn" href="{{route('map')}}">{{__('Шукати космеолога')}}</a>
                        @endif
                    </div>
                @endif
                @if($about->slug === 'about-doctor')
                    <div class="home_search_bg _minwidth769"><img src="{{ asset('image/about_spec_bg.png') }}" alt=""></div>
                    <div class="home_search_bg_mob _maxwidth768"><img src="{{ asset('image/about_spec_bg_mob.png') }}" alt=""></div>
                @elseif($about->slug === 'about-user')
                    <div class="home_search_bg _minwidth769"><img src="{{ asset('image/about_pac_bg.png') }}" alt=""></div>
                    <div class="home_search_bg_mob _maxwidth768"><img src="{{ asset('image/about_pac_bg_mob.png') }}" alt=""></div>
                @else
                    <div class="home_search_bg _minwidth769"><img src="{{ asset('image/about_bg.png') }}" alt=""></div>
                    <div class="home_search_bg_mob _maxwidth768"><img src="{{ asset('image/about_bg_mob.png') }}" alt=""></div>
                @endif
            </div>
        </div>
    </div>
    <div id="title_about">
        <div class="container">
            <div class="subtitle">{{__('Про нас')}}</div>
            <h1><span class="h1-title">@if($about->grey_name){{ $about->grey_name }}@endif <span class="h1-line"><svg width="631" height="4" viewBox="0 0 631 4" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.5 2H631" stroke="#F396A2" stroke-width="3"/>
</svg></span></span>@if($about->grey_title){{ $about->grey_title }}@endif</h1>
        </div>
    </div>
    <div class="container">
        <div class="_flex-display _justify-content-between _align-stretch grey_photo">
            <div class="grey_img _maxwidth768">
                @if($about->slug === 'about-doctor')
                    <img src="{{ asset('image/grey_about_spec_mob.png') }}" alt="">
                @elseif($about->slug === 'about-user')
                    <img src="{{ asset('image/grey_about_photo_mob.png') }}" alt="">
                @else
                    <img src="{{ asset('image/grey_about_photo.png') }}" alt="">
                @endif
            </div>
            <div class="grey">
                <div class="doc-plate rose-plate _display_table">
                    @if($about->slug === 'about-doctor')
                        {{__('Ваша сторінка')}}
                    @elseif($about->slug === 'about-user')
                        {{__('Чому ми')}}
                    @else
                        {{__('Політика сайту')}}
                    @endif
                </div>
                @if($about->grey_text){!! $about->grey_text !!}@endif
            </div>
            <div class="grey_img _minwidth769"></div>
        </div>
        @if((!empty($about->action_text) && strip_tags($about->action_text) !== '')|| (!empty($about->rating_text) && strip_tags($about->rating_text)))
            <div class="_flex-display _justify-content-between _align-stretch about_action_rating">
                @if($about->action_text)
                    <div class="_flex-display _justify-content-between about_action">
                        <div class="about_action_image _minwidth769"><img src="{{ asset('image/about_action_image.png') }}" alt=""></div>
                        <div class="about_action_image _maxwidth768"><img src="{{ asset('image/about_action_image_mob.png') }}" alt=""></div>
                        <div class="about_action_text">
                            <div class="white-plate _display_table">{{__('Акції')}}</div>
                            {!! $about->action_text !!}
                        </div>
                    </div>
                @endif
                @if($about->rating_text)
                    <div class="about_rating">
                        <div class="doc-plate rose-plate _display_table">{{__('Рейтинг')}}</div>
                        {!! $about->rating_text !!}
                        <div class="_flex-display _align-center about_rating_service">
                            <div class="_flex-display _align-center about_rating_service_rating">
                                <svg width="41" height="38" viewBox="0 0 41 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.2153 0.855728C20.3064 0.581987 20.6936 0.581987 20.7847 0.855727L25.2588 14.3053C25.2995 14.4279 25.4142 14.5106 25.5434 14.5106H40.0066C40.2989 14.5106 40.4186 14.8861 40.1802 15.0553L28.4915 23.3502C28.3839 23.4265 28.3388 23.5643 28.3805 23.6895L32.848 37.1194C32.9395 37.3946 32.6262 37.6266 32.3897 37.4588L20.6736 29.1445C20.5696 29.0707 20.4304 29.0707 20.3264 29.1445L8.61029 37.4588C8.3738 37.6266 8.06047 37.3946 8.15201 37.1194L12.6195 23.6895C12.6612 23.5643 12.6161 23.4265 12.5085 23.3502L0.819787 15.0553C0.581391 14.8861 0.701083 14.5106 0.993407 14.5106H15.4566C15.5858 14.5106 15.7005 14.4279 15.7412 14.3053L20.2153 0.855728Z" fill="#F396A2"/>
                                </svg>
                                <span>5.0</span>
                            </div>
                            <div class="about_rating_service_service">
                                <p>{{__('Надання медичної послуги')}}</p>
                                <p>{{__('Сервіс')}}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        @if(!empty($about->photobank_text) && strip_tags($about->photobank_text) !== '')
            <div class="_flex-display _justify-content-between _align-center about_rose_photo">
                <div class="about_rose">
                    <div class="doc-plate rose-plate _display_table">{{__('Фотобанк')}}</div>
                    {!! $about->photobank_text !!}
                </div>
                <a href="#" class="_flex-display _justify-content-center _align-bottom about_photo">
                    <span class="_flex-display _justify-content-center _align-center about_photo_bottom">
                        <span class="_flex-display _justify-content-center _align-center about_photo_title">{{__('Фотобанк')}}</span>
                        <svg viewBox="0 0 26 25" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26.000000" height="25.000000" fill="none">
                            <path id="Frame 1079" d="M13.5 0C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25L12.5 25C5.59644 25 0 19.4036 0 12.5C0 5.59644 5.59644 0 12.5 0L13.5 0Z" fill="rgb(255,255,255)" fill-rule="evenodd" />
                            <path id="Arrow 1" d="M0 -1L13.4536 -1L13.4536 1L0 1L0 -1ZM0.02 0.98L0 1C-0.56 1 -1 0.56 -1 -0C-1 -0.56 -0.56 -1 0 -1L0.02 -0.98L0.02 0.98ZM12.0394 0L7.08966 -4.94975C6.69368 -5.34573 6.69368 -5.96798 7.08966 -6.36396C7.48564 -6.75994 8.1079 -6.75994 8.50388 -6.36396L14.1607 -0.707107C14.5567 -0.311127 14.5567 0.311127 14.1607 0.707107L8.50388 6.36396C8.1079 6.75994 7.48564 6.75994 7.08966 6.36396C6.69368 5.96798 6.69368 5.34573 7.08966 4.94975L12.0394 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(0.743294,-0.668965,0.668965,0.743294,8,17)" />
                        </svg>
                    </span>
                </a>
            </div>
        @endif
        @if((!empty($about->our_text) && strip_tags($about->our_text) !== '')|| (!empty($about->our_rose_text) && strip_tags($about->our_rose_text)))
            <div class="_flex-display _justify-content-between _align-center about_grey_photo_text">
                <img src="{{ asset('image/about_grey_photo.png') }}" alt="">
                <div class="about_grey_text">
                    <div class="doc-plate rose-plate _display_table">{{__('Ваша сторінка')}}</div>
                    @if(!empty($about->our_text) && strip_tags($about->our_text) !== ''){!! $about->our_text !!}@endif
                    @if(!empty($about->our_rose_text) && strip_tags($about->our_rose_text) !== '')
                        {{ $about->our_rose_text }}
                    @else
                        <a class="btn rose_btn" href="#">{{__('Підтримка')}}</a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</main>
