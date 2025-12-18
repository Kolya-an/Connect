<main>
    @if($settings)
    <div id="home_search">
        <div class="container">
            <div class="home_search_block">
                <div class="home_search_bg _minwidth769"><img src="{{ asset('images/home_search_bg.png') }}" alt=""></div>
                <div class="home_banner">
                    <svg width="59" height="59" viewBox="0 0 59 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.529785" width="58" height="58" rx="29" fill="#FFE7E8"/>
                        <path d="M29.5 38.8798L28.05 37.5598C22.9 32.8898 19.5 29.7998 19.5 26.0298C19.5 22.9398 21.92 20.5298 25 20.5298C26.74 20.5298 28.41 21.3398 29.5 22.6098C30.59 21.3398 32.26 20.5298 34 20.5298C37.08 20.5298 39.5 22.9398 39.5 26.0298C39.5 29.7998 36.1 32.8898 30.95 37.5598L29.5 38.8798Z" fill="black"/>
                    </svg>
                    <p class="home_banner_title">{!! $settings->title  !!} </p>
                    <svg width="515" height="21" viewBox="0 0 515 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 19.4702L514 2.47021" stroke="#F396A2" stroke-width="3"/>
                    </svg>
                    <div class="_flex-display _justify-content-center home_banner_bottom">
                        <div class="home_banner_images"><img src="{{ asset('images/home_banner_images.png') }}" alt=""></div>
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
                            <p><b>+3000</b> {{__('перевіренних косметологів')}}</p>
                        </div>
                    </div>
                    <div class="home_search_bg_mob _maxwidth768"><img src="{{ asset('images/home_search_bg_mob.png') }}" alt=""></div>
                </div>

                <livewire:doctor-search-form />
            </div>
        </div>
    </div>
    <div id="top_docs">
        <div class="container">
            <div class="_flex-display _justify-content-between _align-stretch top_docs">
                @if ($doctor)
                    <div class="top_docs_preview doc_number_one">
                        <div class="doc_number_one_image">
                            <img src="{{ asset('uploads/' . $doctor->photo) }}" alt="{{ $doctor->second_name }} {{ $doctor->user->name }}">
                        </div>
                        <div class="fio_doc_spec">
                            <p class="fio_doc">{{ $doctor->second_name }} {{ $doctor->user->name }}</p>
                            @if ($doctor->types)
                                <p class="spec_doc">
                                    @foreach ($doctor->types as $type)
                                        {{$type}}
                                    @endforeach
                                </p>
                            @endif
                        </div>
                        <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                            @if ($doctor->reviews_count > 0)
                                <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                    </svg>
                                    <p><b>{{ $doctor->rating }}</b> ({{ $doctor->reviews_count }})</p>
                                </div>
                            @endif
                            <div class="_flex-display _align-bottom top_docs-city">
                                <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p><b>м. {{ $doctor->city }}</b></p>
                            </div>
                        </div>

                        @if ($doctor && $doctor->services->isNotEmpty())
                            <div class="top_docs-spec">
                                <p>{{__('Послуги')}}: <span>
                                    @foreach ($doctor->services as $key => $service)
                                        {{ $service->name }}{{ $loop->last ? '' : ', ' }}
                                    @endforeach
                                </span></p>
                            </div>
                        @endif
                        <a href="/doctors/{{$doctor->user->id}}" class="btn rose_btn doc_more">{{__('Докладніше про лікаря')}}</a>
                        @if($doctor->plate)
                            <div class="doc-plate rose-plate">{{$doctor->plate}}</div>
                        @endif
                    </div>
                @endif
                <div class="doc_carousel">

                    <div class="swiper swiper-home">
                        <div class="swiper-wrapper">
                             {{--початок циклу--}}
                            @foreach($doctors as $doctor_item)
                            <div class="swiper-slide top_docs_preview">
                                <div class="doc_number_one_image">
                                    <img src="{{ asset('uploads/' . $doctor_item->photo) }}" alt="{{ $doctor_item->second_name }} {{ $doctor_item->user->name }}">
                                </div>
                                <div class="fio_doc_spec">
                                    <p class="fio_doc">{{ $doctor_item->second_name }} {{ $doctor_item->user->name }}</p>
                                    @if ($doctor_item->types)
                                        <p class="spec_doc">
                                            @foreach ($doctor_item->types as $type)
                                                {{$type}}
                                            @endforeach
                                        </p>
                                    @endif
                                </div>

                                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                    @if ($doctor_item->reviews_count > 0)
                                        <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                            </svg>
                                            <p><b>{{ $doctor_item->rating }}</b> ({{ $doctor_item->reviews_count }})</p>
                                        </div>
                                    @endif
                                    <div class="_flex-display _align-bottom top_docs-city">
                                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p><b>м. {{ $doctor_item->city }}</b></p>
                                    </div>
                                </div>
                                @if ($doctor_item && $doctor_item->services->isNotEmpty())
                                    <div class="top_docs-spec">
                                        <p>{{__('Послуги')}}: <span>
                                    @foreach ($doctor_item->services as $key => $service)
                                        {{ $service->name }}{{ $loop->last ? '' : ', ' }}
                                    @endforeach
                                </span></p>
                                    </div>
                                @endif
                                <a href="/doctors/{{$doctor_item->user->id}}" class="btn rose_btn doc_more">{{__('Докладніше про лікаря')}}</a>
                                @if($doctor_item->plate)
                                    <div class="doc-plate">{{$doctor_item->plate}}</div>
                                @endif
                            </div>
                         {{--Кінець циклу--}}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="_flex-display _justify-content-center top_docs_buttons">
                    <div class="_flex-display _justify-content-center _align-center carousel_btn carousel_btn_prev"><svg xmlns="http://www.w3.org/2000/svg" width="6" height="8" viewBox="0 0 6 8" fill="none">
                            <path d="M4.56 8L5.5 7.06L2.44667 4L5.5 0.94L4.56 8.21774e-08L0.56 4L4.56 8Z" fill="#F396A2"/>
                        </svg></div>
                    <div class="_flex-display _justify-content-center _align-center carousel_btn carousel_btn_next"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                            <path d="M7.44 4L6.5 4.94L9.55333 8L6.5 11.06L7.44 12L11.44 8L7.44 4Z" fill="#F396A2"/>
                        </svg></div>
                </div>
            </div>
        </div>
    </div>
    <div id="platform">
        <div class="container">
            <p class="subtitle">{{__('Про нас')}}</p>
            <h1><span class="h1-title">{{ $settings->about_name }} <span class="h1-line"><svg xmlns="http://www.w3.org/2000/svg" width="255" height="14" viewBox="0 0 255 14" fill="none">
              <path d="M0.5 12L254 2" stroke="#F396A2" stroke-width="3"/>
            </svg></span></span>- {{ $settings->about_title }}</h1>
            <div class="_flex-display _justify-content-between _align-stretch platform-block">
                <div class="platform-modals">
                    <div class="_flex-display _justify-content-between _align-stretch platform-modal platform-modal-top">
                        <div class="_flex-display _justify-content-between platform-modal-grey">
                            <div class="_flex-display _justify-content-between _align-center">
                                <div class="_flex-display _justify-content-center _align-center platform-about_plate">Про нас</div>
                                <a href="{{route('about')}}"><svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                        <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                                    </svg></a>
                            </div>
                            <div class="platform-about-text">
                                {!! $settings->about_text !!}
                            </div>
                        </div>
                        <div class="platform-modal-rose"></div>
                    </div>
                    <div class="_flex-display _justify-content-between _align-stretch platform-modal platform-modal-bottom _minwidth769">
                        <div class="_flex-display _justify-content-between _align-bottom platform-modal-rose">
                            <a href="{{route('photobank')}}" class="_flex-display _justify-content-center _align-center platform-photo_plate">{{__('Фотобанк')}}</a>
                            <a href="{{route('photobank')}}"><svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                    <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                                </svg></a>
                        </div>
                        <div class="platform-modal-grey">
                            <div class="_flex-display _justify-content-between _align-center">
                                <div class="_flex-display _justify-content-center _align-center platform-action_plate">{{__('Акція')}}</div>
                                <a href="/doctors/{{$promotion->doctor->user->id}}?tab=5"><svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                        <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                                    </svg></a>
                            </div>
                            <div class="_flex-display _justify-content-between _align-center platform-action-bottom">
                                <div class="platform-action-image"><img src="{{ asset('uploads/' . $promotion->doctor->photo) }}" alt="{{ $promotion->title }}" /></div>
                                <div class="platform-action-text">
                                    <p class="platform-action-title"><a href="/doctors/{{$promotion->doctor->user->id}}?tab=5">{{ $promotion->title }}</a></p>
                                    <p>{{ $promotion->description }}</p>
                                    <div class="fio_doc_spec">
                                        <a href="/doctors/{{$promotion->doctor->user->id}}" class="fio_doc">{{ $promotion->doctor->second_name }} {{ $promotion->doctor->user?->name }}</a>
                                        @if ($promotion?->doctor?->types)
                                            <p class="spec_doc">
                                                @foreach ($promotion->doctor->types as $type)
                                                    {{$type}}{{ $loop->last ? '' : ', ' }}
                                                @endforeach
                                            </p>
                                        @endif
                                    </div>
                                    <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                            <div class="_flex-display _align-center top_docs-rating"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                    <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                                </svg>
                                                <p><b>{{ $promotion->doctor->rating }}</b> ({{ $promotion->doctor->reviews_count }})</p>
                                            </div>

                                        <div class="_flex-display _align-center top_docs-city">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="13" viewBox="0 0 11 13" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.60028C7 4.77152 6.32846 4.09998 5.5003 4.09998C4.67154 4.09998 4 4.77152 4 5.60028C4 6.42843 4.67154 7.09998 5.5003 7.09998C6.32846 7.09998 7 6.42843 7 5.60028Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9C4.78062 11.9 1 8.839 1 5.63795C1 3.13196 3.01426 1.09998 5.49971 1.09998C7.98515 1.09998 10 3.13196 10 5.63795C10 8.839 6.21879 11.9 5.49971 11.9Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p><b>{{ $promotion->doctor->city }}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="platform-services">
                    @if($service_block)
                        <div class="platform-services-plate">{{__('Популярні послуги')}}</div>
                        <ul class="platform-services-list">
                            @foreach($service_block as $key => $services)
                                <li><a href="{{ route('map', ['service_id' => $services->id]) }}">{{ $services->name }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="_flex-display _justify-content-between _align-stretch platform-modal platform-modal-bottom _maxwidth768">
                    <div class="platform-modal-grey">
                        <div class="_flex-display _justify-content-between _align-center">
                            <div class="_flex-display _justify-content-center _align-center platform-action_plate">{{__('Акція')}}</div>
                            <a href="/doctors/{{$promotion->doctor->user->id}}">
                                <svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                    <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                                </svg></a>
                        </div>
                        <div class="_flex-display _justify-content-between _align-center platform-action-bottom">
                            <div class="platform-action-image"><img src="{{ asset('uploads/' . $promotion->doctor->photo) }}" alt="{{ $promotion->title }}" /></div>
                            <div class="platform-action-text">
                                <p class="platform-action-title">{{ $promotion->title }}</p>
                                <p>{{ $promotion->description }}</p>
                                <div class="fio_doc_spec">
                                    <a href="/doctors/{{$promotion->doctor->user->id}}" class="fio_doc">{{ $promotion->doctor->second_name }} {{ $promotion->doctor->user?->name }}</a>
                                    @if ($promotion?->doctor?->types)
                                        <p class="spec_doc">
                                            @foreach ($promotion->doctor->types as $type)
                                                {{$type}}{{ $loop->last ? '' : ', ' }}
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                    @if ($promotion->doctor->reviews_count > 0)
                                        <div class="_flex-display _align-center top_docs-rating"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                            </svg>
                                            <p><b>{{ $promotion->doctor->rating }}</b> ({{ $promotion->doctor->reviews_count }})</p>
                                        </div>
                                    @endif
                                    <div class="_flex-display _align-center top_docs-city">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="13" viewBox="0 0 11 13" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.60028C7 4.77152 6.32846 4.09998 5.5003 4.09998C4.67154 4.09998 4 4.77152 4 5.60028C4 6.42843 4.67154 7.09998 5.5003 7.09998C6.32846 7.09998 7 6.42843 7 5.60028Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9C4.78062 11.9 1 8.839 1 5.63795C1 3.13196 3.01426 1.09998 5.49971 1.09998C7.98515 1.09998 10 3.13196 10 5.63795C10 8.839 6.21879 11.9 5.49971 11.9Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p><b>{{ $promotion->doctor->city }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_flex-display _justify-content-center _align-bottom platform-modal-rose">
                        <div class="_flex-display _justify-content-center _align-center platform-photo_plate">{{__('Фотобанк')}}</div>
                        <a href="{{route('photobank')}}">
                            <svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($news)
        @php
            $news1 = $news[0];
            $news2 = $news[1];
            $news3 = $news[2];
        @endphp
        <div id="home-articles">
            <div class="container">
                <div class="_flex-display _justify-content-between _align-stretch home-articles-list">
                    <div class="article first-article _minwidth769">
                        <div class="article-image">
                            <img src="{{ asset('uploads/' . $news1->image) }}" alt="" />
                        </div>
                        <a class="_flex-display _justify-content-between _align-center article_title" href="{{ route('news.show', $news1->slug) }}">
                            <h5>{{ $news1->title }}</h5>
                            <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 17.5C0 7.83502 7.83502 0 17.5 0H18.5C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35H17.5C7.83502 35 0 27.165 0 17.5Z" fill="#F396A2"/>
                                <path d="M12.331 21.2567C11.9205 21.6262 11.8872 22.2585 12.2567 22.669C12.6262 23.0795 13.2585 23.1128 13.669 22.7433L12.331 21.2567ZM23.9986 13.0526C24.0276 12.501 23.6041 12.0304 23.0526 12.0014L14.065 11.5284C13.5135 11.4993 13.0428 11.9229 13.0138 12.4744C12.9848 13.0259 13.4084 13.4966 13.9599 13.5256L21.9488 13.9461L21.5284 21.935C21.4993 22.4865 21.9229 22.9572 22.4744 22.9862C23.0259 23.0152 23.4966 22.5916 23.5256 22.0401L23.9986 13.0526ZM13 22L13.669 22.7433L23.669 13.7433L23 13L22.331 12.2567L12.331 21.2567L13 22Z" fill="white"/>
                            </svg>
                        </a>
                        <p>{{ $news1->preview }}</p>
                    </div>
                    <div class="home-articles-right">
                        <p class="subtitle">{{__('Корисні статті')}}</p>
                        <h2>{{__('Дізнайся про')}} <span>{{__('важливе')}}</span></h2>
                        <div class="_flex-display _justify-content-between _align-stretch home-articles-23">
                            <div class="article _maxwidth768">
                                <div class="article-image">
                                    <img src="{{ asset('uploads/' . $news1->image) }}" alt="" />
                                </div>
                                <a class="_flex-display _justify-content-between _align-center article_title" href="{{ route('news.show', $news1->slug) }}">
                                    <h5>{{ $news1->title }}</h5>
                                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 17.5C0 7.83502 7.83502 0 17.5 0H18.5C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35H17.5C7.83502 35 0 27.165 0 17.5Z" fill="#F396A2"/>
                                        <path d="M12.331 21.2567C11.9205 21.6262 11.8872 22.2585 12.2567 22.669C12.6262 23.0795 13.2585 23.1128 13.669 22.7433L12.331 21.2567ZM23.9986 13.0526C24.0276 12.501 23.6041 12.0304 23.0526 12.0014L14.065 11.5284C13.5135 11.4993 13.0428 11.9229 13.0138 12.4744C12.9848 13.0259 13.4084 13.4966 13.9599 13.5256L21.9488 13.9461L21.5284 21.935C21.4993 22.4865 21.9229 22.9572 22.4744 22.9862C23.0259 23.0152 23.4966 22.5916 23.5256 22.0401L23.9986 13.0526ZM13 22L13.669 22.7433L23.669 13.7433L23 13L22.331 12.2567L12.331 21.2567L13 22Z" fill="white"/>
                                    </svg>
                                </a>
                                <p>{{ $news1->preview }}</p>
                            </div>
                            <div class="article">
                                <div class="article-image">
                                    <img src="{{ asset('uploads/' . $news2->image) }}" alt="" />
                                </div>
                                <a class="_flex-display _justify-content-between _align-center article_title" href="{{ route('news.show', $news2->slug) }}">
                                    <h5>{{ $news2->title }}</h5>
                                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 17.5C0 7.83502 7.83502 0 17.5 0H18.5C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35H17.5C7.83502 35 0 27.165 0 17.5Z" fill="#F396A2"/>
                                        <path d="M12.331 21.2567C11.9205 21.6262 11.8872 22.2585 12.2567 22.669C12.6262 23.0795 13.2585 23.1128 13.669 22.7433L12.331 21.2567ZM23.9986 13.0526C24.0276 12.501 23.6041 12.0304 23.0526 12.0014L14.065 11.5284C13.5135 11.4993 13.0428 11.9229 13.0138 12.4744C12.9848 13.0259 13.4084 13.4966 13.9599 13.5256L21.9488 13.9461L21.5284 21.935C21.4993 22.4865 21.9229 22.9572 22.4744 22.9862C23.0259 23.0152 23.4966 22.5916 23.5256 22.0401L23.9986 13.0526ZM13 22L13.669 22.7433L23.669 13.7433L23 13L22.331 12.2567L12.331 21.2567L13 22Z" fill="white"/>
                                    </svg>
                                </a>
                                <p>{{ $news2->preview }}</p>
                            </div>
                            <div class="article">
                                <div class="article-image">
                                    <img src="{{ asset('uploads/' . $news3->image) }}" alt="" />
                                </div>
                                <a class="_flex-display _justify-content-between _align-center article_title" href="{{ route('news.show', $news3->slug) }}">
                                    <h5>{{ $news3->title }}</h5>
                                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 17.5C0 7.83502 7.83502 0 17.5 0H18.5C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35H17.5C7.83502 35 0 27.165 0 17.5Z" fill="#F396A2"/>
                                        <path d="M12.331 21.2567C11.9205 21.6262 11.8872 22.2585 12.2567 22.669C12.6262 23.0795 13.2585 23.1128 13.669 22.7433L12.331 21.2567ZM23.9986 13.0526C24.0276 12.501 23.6041 12.0304 23.0526 12.0014L14.065 11.5284C13.5135 11.4993 13.0428 11.9229 13.0138 12.4744C12.9848 13.0259 13.4084 13.4966 13.9599 13.5256L21.9488 13.9461L21.5284 21.935C21.4993 22.4865 21.9229 22.9572 22.4744 22.9862C23.0259 23.0152 23.4966 22.5916 23.5256 22.0401L23.9986 13.0526ZM13 22L13.669 22.7433L23.669 13.7433L23 13L22.331 12.2567L12.331 21.2567L13 22Z" fill="white"/>
                                    </svg>
                                </a>
                                <p>{{ $news3->preview }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
    @endif
</main>
