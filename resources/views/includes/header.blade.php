<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page.title', config('app.name'))</title>
    <meta name="description" content="@yield('page.description', $pageDescription ?? '')">
    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
            <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
<header>
    <div class="container">
        <div class="_flex-display _justify-content-between _align-center header">
            <div class="header_logo">
                <a href="{{route('home')}}"><img src="{{asset('images/logo.png')}}" alt="Logo"/></a>
            </div>
            <div class="header_menu">
                <ul class="_width100 _flex-display _justify-content-between _align-center">
                    <li><a href="{{route('map')}}">{{__('Мапа косметологів')}}</a></li>
                    <li class="submenu"><a class="submenu_a" href="#">{{__('Обрати процедуру')}} <span><svg width="15" height="19"
                                                                                                  viewBox="0 0 15 19"
                                                                                                  fill="none"
                                                                                                  xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M8.21906 14.5423C8.03153 14.7298 7.77723 14.8351 7.51206 14.8351C7.2469 14.8351 6.99259 14.7298 6.80506 14.5423L1.14806 8.8853C1.05255 8.79306 0.976369 8.68271 0.92396 8.56071C0.871551 8.4387 0.843965 8.30748 0.842811 8.17471C0.841657 8.04193 0.866959 7.91025 0.91724 7.78735C0.967521 7.66445 1.04177 7.5528 1.13567 7.45891C1.22956 7.36502 1.34121 7.29076 1.46411 7.24048C1.587 7.1902 1.71868 7.1649 1.85146 7.16605C1.98424 7.16721 2.11546 7.19479 2.23747 7.2472C2.35947 7.29961 2.46982 7.37579 2.56206 7.4713L7.51206 12.4213L12.4621 7.4713C12.6507 7.28915 12.9033 7.18835 13.1655 7.19063C13.4277 7.19291 13.6785 7.29808 13.8639 7.48348C14.0493 7.66889 14.1545 7.91971 14.1567 8.1819C14.159 8.4441 14.0582 8.6967 13.8761 8.8853L8.21906 14.5423Z"
                          fill="black"/>
                    </svg></span></a>
                        <livewire:header-service />
                    </li>
                    <li><a href="{{route('about')}}">{{__('Про сервіс')}}</a></li>
                    <li><a href="{{route('photobank')}}">{{__('Фотобанк')}}</a></li>
                    <li><a href="{{route('news')}}">{{__('Новини')}}</a></li>
                </ul>
            </div>
            <div class="_flex-display _justify-content-between _align-center header_button">
                @guest
                    <livewire:login-modal />
                    <livewire:auth-modal />
                @endguest
                @auth
                        @if(in_array(Auth::user()->role, ['doctor', 'patient']))
                            <livewire:header-component />
                        @endif
                        @if(in_array(Auth::user()->role, ['admin']))
                            <a class="_flex-display _align-center cab_btn" style="cursor: default">
                                <img src="{{asset('images/cab.png')}}" alt="Connect">
                            </a>
                        @endif
                @endauth
                @guest
                    <a class="_flex-display _align-center cab_btn" style="cursor: default">
                        <img src="{{asset('images/cab.png')}}" alt="Connect">
                    </a>
                @endguest
            </div>
        </div>
        <div class="_flex-display _justify-content-between _align-center header_mob">
            <div class="header_logo">
                <a href="/"><img src="{{asset('images/logomob.png')}}" alt="Connect" /></a>
            </div>
            <div class="_flex-display _align-center header_mob_buttons">
                <div class="_flex-display _justify-content-between _align-center header_button">
                    @guest
                        <livewire:login-modal />
                        <livewire:auth-modal />
                    @endguest
                    @auth
                        @if(in_array(Auth::user()->role, ['doctor', 'patient']))
                            <livewire:header-component />
                        @endif
                        @if(in_array(Auth::user()->role, ['admin']))
                            <a class="_flex-display _align-center cab_btn" style="cursor: default">
                                <img src="{{asset('images/cab.png')}}" alt="Connect">
                            </a>
                        @endif
                    @endauth
                    @guest
                        <a class="_flex-display _align-center cab_btn" style="cursor: default">
                            <img src="{{asset('images/cab.png')}}" alt="Connect">
                        </a>
                    @endguest
                </div>
                <div class="menu-toggle">
                    <svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.5" width="30" height="4" rx="2" fill="black"/>
                        <rect y="10.5" width="30" height="4" rx="2" fill="black"/>
                        <rect y="20.5" width="30" height="4" rx="2" fill="black"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="header_mob_block">
    <div class="mob_menu_close">
        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="30" height="30" rx="15" fill="white"/>
            <path
                d="M15.0002 16.1668L10.9168 20.2502C10.7641 20.4029 10.5696 20.4793 10.3335 20.4793C10.0974 20.4793 9.90294 20.4029 9.75016 20.2502C9.59738 20.0974 9.521 19.9029 9.521 19.6668C9.521 19.4307 9.59738 19.2363 9.75016 19.0835L13.8335 15.0002L9.75016 10.9168C9.59738 10.7641 9.521 10.5696 9.521 10.3335C9.521 10.0974 9.59738 9.90294 9.75016 9.75016C9.90294 9.59738 10.0974 9.521 10.3335 9.521C10.5696 9.521 10.7641 9.59738 10.9168 9.75016L15.0002 13.8335L19.0835 9.75016C19.2363 9.59738 19.4307 9.521 19.6668 9.521C19.9029 9.521 20.0974 9.59738 20.2502 9.75016C20.4029 9.90294 20.4793 10.0974 20.4793 10.3335C20.4793 10.5696 20.4029 10.7641 20.2502 10.9168L16.1668 15.0002L20.2502 19.0835C20.4029 19.2363 20.4793 19.4307 20.4793 19.6668C20.4793 19.9029 20.4029 20.0974 20.2502 20.2502C20.0974 20.4029 19.9029 20.4793 19.6668 20.4793C19.4307 20.4793 19.2363 20.4029 19.0835 20.2502L15.0002 16.1668Z"
                fill="black"/>
        </svg>
    </div>
    <div class="header_menu">
        <ul class="_width100 _flex-display _justify-content-between _align-center">
            <li><a href="{{route('map')}}">{{__('Мапа косметологів')}}</a></li>
            <li class="submenu"><a class="submenu_a" href="#">{{__('Обрати процедуру')}} <span><svg width="15" height="19"
                                                                                          viewBox="0 0 15 19"
                                                                                          fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M8.21906 14.5423C8.03153 14.7298 7.77723 14.8351 7.51206 14.8351C7.2469 14.8351 6.99259 14.7298 6.80506 14.5423L1.14806 8.8853C1.05255 8.79306 0.976369 8.68271 0.92396 8.56071C0.871551 8.4387 0.843965 8.30748 0.842811 8.17471C0.841657 8.04193 0.866959 7.91025 0.91724 7.78735C0.967521 7.66445 1.04177 7.5528 1.13567 7.45891C1.22956 7.36502 1.34121 7.29076 1.46411 7.24048C1.587 7.1902 1.71868 7.1649 1.85146 7.16605C1.98424 7.16721 2.11546 7.19479 2.23747 7.2472C2.35947 7.29961 2.46982 7.37579 2.56206 7.4713L7.51206 12.4213L12.4621 7.4713C12.6507 7.28915 12.9033 7.18835 13.1655 7.19063C13.4277 7.19291 13.6785 7.29808 13.8639 7.48348C14.0493 7.66889 14.1545 7.91971 14.1567 8.1819C14.159 8.4441 14.0582 8.6967 13.8761 8.8853L8.21906 14.5423Z"
                          fill="black"/>
                    </svg></span></a>
                <livewire:header-service />
            </li>
            <li><a href="{{route('about')}}">{{__('Про сервіс')}}</a></li>
            <li><a href="{{route('photobank')}}">{{__('Фотобанк')}}</a></li>
            <li><a href="{{route('news')}}">{{__('Новини')}}</a></li>
        </ul>
    </div>
</div>
