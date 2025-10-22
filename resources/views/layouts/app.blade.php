<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

<body>
<header>
    <div class="container">
        <div class="_flex-display _justify-content-between _align-center header">
            <div class="header_logo">
                <a href="/home.php"><img src="image/logo.png" /></a>
            </div>
            <div class="header_menu">
                <ul class="_width100 _flex-display _justify-content-between _align-center">
                    <li><a href="/search.php">Мапа косметологів</a></li>
                    <li class="submenu"><a class="submenu_a" href="#">Обрати процедуру <span><svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21906 14.5423C8.03153 14.7298 7.77723 14.8351 7.51206 14.8351C7.2469 14.8351 6.99259 14.7298 6.80506 14.5423L1.14806 8.8853C1.05255 8.79306 0.976369 8.68271 0.92396 8.56071C0.871551 8.4387 0.843965 8.30748 0.842811 8.17471C0.841657 8.04193 0.866959 7.91025 0.91724 7.78735C0.967521 7.66445 1.04177 7.5528 1.13567 7.45891C1.22956 7.36502 1.34121 7.29076 1.46411 7.24048C1.587 7.1902 1.71868 7.1649 1.85146 7.16605C1.98424 7.16721 2.11546 7.19479 2.23747 7.2472C2.35947 7.29961 2.46982 7.37579 2.56206 7.4713L7.51206 12.4213L12.4621 7.4713C12.6507 7.28915 12.9033 7.18835 13.1655 7.19063C13.4277 7.19291 13.6785 7.29808 13.8639 7.48348C14.0493 7.66889 14.1545 7.91971 14.1567 8.1819C14.159 8.4441 14.0582 8.6967 13.8761 8.8853L8.21906 14.5423Z" fill="black"/>
                </svg></span></a>
                        <ul class="ul_submenu">
                            <li><a href="#">Процедура1</a></li>
                            <li><a href="#">Процедура2</a></li>
                            <li><a href="#">Процедура3</a></li>
                        </ul>
                    </li>
                    <li><a href="/about.php">Про сервіс</a></li>
                    <li><a href="/photobank.php">Фотобанк</a></li>
                    <li><a href="#">Новини</a></li>
                </ul>
            </div>
            <div class="_flex-display _justify-content-between _align-center header_button">
                <a class="btn white_btn login_btn _display_none">Вхід</a>
                <a  class="btn rose_btn register_btn _display_none">Реєстрація</a>
                <a href="#"  class="_flex-display _align-center cab_btn">
                    <img class="_display_none" src="image/cab.png"><img class="_display_non" src="image/cabimg.png"><span>Особистий кабінет</span>
                </a>
            </div>
        </div>
        <div class="_flex-display _justify-content-between _align-center header_mob">
            <div class="header_logo">
                <a href="/"><img src="image/logomob.png" /></a>
            </div>
            <div class="_flex-display _align-center header_mob_buttons">
                <div class="_flex-display _justify-content-between _align-center header_button">
                    <a href="#" class="btn white_btn login_btn _display_none">Вхід</a>
                    <a href="#"  class="btn rose_btn register_btn _display_none">Реєстрація</a>
                    <a href="#"  class="_flex-display _align-center cab_btn">
                        <img class="_display_none" src="image/cab.png"><img class="_display_non" src="image/cabimg.png">
                    </a>
                </div>
                <div class="menu-toggle"><svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
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
    <div class="mob_menu_close"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="30" height="30" rx="15" fill="white"/>
            <path d="M15.0002 16.1668L10.9168 20.2502C10.7641 20.4029 10.5696 20.4793 10.3335 20.4793C10.0974 20.4793 9.90294 20.4029 9.75016 20.2502C9.59738 20.0974 9.521 19.9029 9.521 19.6668C9.521 19.4307 9.59738 19.2363 9.75016 19.0835L13.8335 15.0002L9.75016 10.9168C9.59738 10.7641 9.521 10.5696 9.521 10.3335C9.521 10.0974 9.59738 9.90294 9.75016 9.75016C9.90294 9.59738 10.0974 9.521 10.3335 9.521C10.5696 9.521 10.7641 9.59738 10.9168 9.75016L15.0002 13.8335L19.0835 9.75016C19.2363 9.59738 19.4307 9.521 19.6668 9.521C19.9029 9.521 20.0974 9.59738 20.2502 9.75016C20.4029 9.90294 20.4793 10.0974 20.4793 10.3335C20.4793 10.5696 20.4029 10.7641 20.2502 10.9168L16.1668 15.0002L20.2502 19.0835C20.4029 19.2363 20.4793 19.4307 20.4793 19.6668C20.4793 19.9029 20.4029 20.0974 20.2502 20.2502C20.0974 20.4029 19.9029 20.4793 19.6668 20.4793C19.4307 20.4793 19.2363 20.4029 19.0835 20.2502L15.0002 16.1668Z" fill="black"/>
        </svg>
    </div>
    <div class="header_menu">
        <ul class="_width100 _flex-display _justify-content-between _align-center">
            <li><a href="/search.php">Мапа косметологів</a></li>
            <li class="submenu"><a class="submenu_a" href="#">Обрати процедуру <span><svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21906 14.5423C8.03153 14.7298 7.77723 14.8351 7.51206 14.8351C7.2469 14.8351 6.99259 14.7298 6.80506 14.5423L1.14806 8.8853C1.05255 8.79306 0.976369 8.68271 0.92396 8.56071C0.871551 8.4387 0.843965 8.30748 0.842811 8.17471C0.841657 8.04193 0.866959 7.91025 0.91724 7.78735C0.967521 7.66445 1.04177 7.5528 1.13567 7.45891C1.22956 7.36502 1.34121 7.29076 1.46411 7.24048C1.587 7.1902 1.71868 7.1649 1.85146 7.16605C1.98424 7.16721 2.11546 7.19479 2.23747 7.2472C2.35947 7.29961 2.46982 7.37579 2.56206 7.4713L7.51206 12.4213L12.4621 7.4713C12.6507 7.28915 12.9033 7.18835 13.1655 7.19063C13.4277 7.19291 13.6785 7.29808 13.8639 7.48348C14.0493 7.66889 14.1545 7.91971 14.1567 8.1819C14.159 8.4441 14.0582 8.6967 13.8761 8.8853L8.21906 14.5423Z" fill="black"/>
                </svg></span></a>
                <ul class="ul_submenu">
                    <li><a href="#">Процедура1</a></li>
                    <li><a href="#">Процедура2</a></li>
                    <li><a href="#">Процедура3</a></li>
                </ul>
            </li>
            <li><a href="/about.php">Про сервіс</a></li>
            <li><a href="/photobank.php">Фотобанк</a></li>
            <li><a href="#">Новини</a></li>
        </ul>
    </div>
</div>
<main>
    <div id="home_search">
        <div class="container">
            <div class="home_search_block">
                <div class="home_search_bg _minwidth769"><img src="image/home_search_bg.png" alt=""></div>
                <div class="home_banner">
                    <svg width="59" height="59" viewBox="0 0 59 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.529785" width="58" height="58" rx="29" fill="#FFE7E8"/>
                        <path d="M29.5 38.8798L28.05 37.5598C22.9 32.8898 19.5 29.7998 19.5 26.0298C19.5 22.9398 21.92 20.5298 25 20.5298C26.74 20.5298 28.41 21.3398 29.5 22.6098C30.59 21.3398 32.26 20.5298 34 20.5298C37.08 20.5298 39.5 22.9398 39.5 26.0298C39.5 29.7998 36.1 32.8898 30.95 37.5598L29.5 38.8798Z" fill="black"/>
                    </svg>
                    <p class="home_banner_title">Знайди свого <span>перевіренного лікаря-косметолога</span></p>
                    <svg width="515" height="21" viewBox="0 0 515 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 19.4702L514 2.47021" stroke="#F396A2" stroke-width="3"/>
                    </svg>
                    <div class="_flex-display _justify-content-center home_banner_bottom">
                        <div class="home_banner_images"><img src="image/home_banner_images.png" alt=""></div>
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
                            <p><b>+3000</b> перевіренних косметологів</p>
                        </div>
                    </div>
                    <div class="home_search_bg_mob _maxwidth768"><img src="image/home_search_bg_mob.png" alt=""></div>
                </div>
                <div class="home_search_form">
                    <form id="doc_search_form" class="_flex-display _justify-content-between _align-center">
                        <div class="_flex-display field_section spec_field_section">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.5 16.5C7.68333 16.5 6.146 15.8707 4.888 14.612C3.63 13.3533 3.00067 11.816 3 10C2.99933 8.184 3.62867 6.64667 4.888 5.388C6.14733 4.12933 7.68467 3.5 9.5 3.5C11.3153 3.5 12.853 4.12933 14.113 5.388C15.373 6.64667 16.002 8.184 16 10C16 10.7333 15.8833 11.425 15.65 12.075C15.4167 12.725 15.1 13.3 14.7 13.8L20.3 19.4C20.4833 19.5833 20.575 19.8167 20.575 20.1C20.575 20.3833 20.4833 20.6167 20.3 20.8C20.1167 20.9833 19.8833 21.075 19.6 21.075C19.3167 21.075 19.0833 20.9833 18.9 20.8L13.3 15.2C12.8 15.6 12.225 15.9167 11.575 16.15C10.925 16.3833 10.2333 16.5 9.5 16.5ZM9.5 14.5C10.75 14.5 11.8127 14.0627 12.688 13.188C13.5633 12.3133 14.0007 11.2507 14 10C13.9993 8.74933 13.562 7.687 12.688 6.813C11.814 5.939 10.7513 5.50133 9.5 5.5C8.24867 5.49867 7.18633 5.93633 6.313 6.813C5.43967 7.68967 5.002 8.752 5 10C4.998 11.248 5.43567 12.3107 6.313 13.188C7.19033 14.0653 8.25267 14.5027 9.5 14.5Z" fill="black"/>
                            </svg>
                            <input id="spec_field" class="spec_field" type="text" placeholder="Кислотний пілінг" name="service" />
                        </div>
                        <div class="_flex-display field_section city_field_section">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 11.0005C14.5 9.61924 13.3808 8.5 12.0005 8.5C10.6192 8.5 9.5 9.61924 9.5 11.0005C9.5 12.3808 10.6192 13.5 12.0005 13.5C13.3808 13.5 14.5 12.3808 14.5 11.0005Z" stroke="#25324B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9995 21.5C10.801 21.5 4.5 16.3984 4.5 11.0633C4.5 6.88664 7.8571 3.5 11.9995 3.5C16.1419 3.5 19.5 6.88664 19.5 11.0633C19.5 16.3984 13.198 21.5 11.9995 21.5Z" stroke="#25324B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <select id="city_field" class="city_field" name="city">
                                <option value="Київ">Київ</option>
                            </select>
                        </div>
                        <div class="_flex-display field_section radius_field_section">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                <path d="M12 4.5C14.2 4.5 16 6.3 16 8.5C16 10.6 13.9 14 12 16.4C10.1 13.9 8 10.6 8 8.5C8 6.3 9.8 4.5 12 4.5ZM12 2.5C8.7 2.5 6 5.2 6 8.5C6 13 12 19.5 12 19.5C12 19.5 18 12.9 18 8.5C18 5.2 15.3 2.5 12 2.5ZM12 6.5C10.9 6.5 10 7.4 10 8.5C10 9.6 10.9 10.5 12 10.5C13.1 10.5 14 9.6 14 8.5C14 7.4 13.1 6.5 12 6.5ZM20 19.5C20 21.7 16.4 23.5 12 23.5C7.6 23.5 4 21.7 4 19.5C4 18.2 5.2 17.1 7.1 16.3L7.7 17.2C6.7 17.7 6 18.3 6 19C6 20.4 8.7 21.5 12 21.5C15.3 21.5 18 20.4 18 19C18 18.3 17.3 17.7 16.2 17.2L16.8 16.3C18.8 17.1 20 18.2 20 19.5Z" fill="black"/>
                            </svg>
                            <select id="radius_field" class="radius_field" name="radius">
                                <option value="5">5 км</option>
                                <option value="10">10 км</option>
                                <option value="15">15 км</option>
                                <option value="20">20 км</option>
                                <option value="25">25 км</option>
                                <option value="30">30 км</option>
                                <option value="35">35 км</option>
                                <option value="40">40 км</option>
                            </select>
                        </div>
                        <button type="submit" class="btn rose_btn">Знайти</button>
                    </form>
                </div>
                <div class="_flex-display home_search_specials">
                    <div class="home_search_specials_text">Популярне :</div>
                    <div class="home_search_specials_value">Збільшення губ,</div>
                    <div class="home_search_specials_value">Біоревіталізація,</div>
                    <div class="home_search_specials_value">Чистка,</div>
                    <div class="home_search_specials_value">Пілінг</div>
                </div>
            </div>
        </div>
    </div>
    <div id="top_docs">
        <div class="container">
            <div class="_flex-display _justify-content-between _align-stretch top_docs">
                <div class="top_docs_preview doc_number_one">
                    <div class="doc_number_one_image">
                        <img src="image/number-one.png" alt="">
                    </div>
                    <div class="fio_doc_spec">
                        <p class="fio_doc">Некрасова Анна</p>
                        <p class="spec_doc">Лікар дермовенеролог, косметолог</p>
                    </div>
                    <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                        <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                            </svg>
                            <p><b>4.8</b> (105)</p>
                        </div>
                        <div class="_flex-display _align-bottom top_docs-city">
                            <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p><b>м. Київ</b></p>
                        </div>
                    </div>
                    <div class="top_docs-spec">
                        <p>Послуги: <span>Збільшення губ, Біоревіталізація, Чистка, Пілінг</span></p>
                    </div>
                    <a href="#" class="btn rose_btn doc_more">Докладніше про лікаря</a>
                    <div class="doc-plate rose-plate">№1 у києві</div>
                </div>
                <div class="doc_carousel">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide top_docs_preview">
                                <div class="doc_number_one_image">
                                    <img src="image/top_slider1.png" alt="">
                                </div>
                                <div class="fio_doc_spec">
                                    <p class="fio_doc">Некрасова Анна</p>
                                    <p class="spec_doc">Лікар дермовенеролог, косметолог</p>
                                </div>
                                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                    <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                        </svg>
                                        <p><b>4.8</b> (105)</p>
                                    </div>
                                    <div class="_flex-display _align-bottom top_docs-city">
                                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p><b>м. Київ</b></p>
                                    </div>
                                </div>
                                <div class="top_docs-spec">
                                    <p>Послуги: <span>Збільшення губ, Біоревіталізація, Чистка, Пілінг</span></p>
                                </div>
                                <a href="#" class="btn rose_btn doc_more">Докладніше про лікаря</a>
                                <div class="doc-plate">TOП Лікар</div>
                            </div>


                            <div class="swiper-slide top_docs_preview">
                                <div class="doc_number_one_image">
                                    <img src="image/number-one.png" alt="">
                                </div>
                                <div class="fio_doc_spec">
                                    <p class="fio_doc">Некрасова Анна</p>
                                    <p class="spec_doc">Лікар дермовенеролог, косметолог</p>
                                </div>
                                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                    <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                        </svg>
                                        <p><b>4.8</b> (105)</p>
                                    </div>
                                    <div class="_flex-display _align-bottom top_docs-city">
                                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p><b>м. Київ</b></p>
                                    </div>
                                </div>
                                <div class="top_docs-spec">
                                    <p>Послуги: <span>Збільшення губ, Біоревіталізація, Чистка, Пілінг</span></p>
                                </div>
                                <a href="#" class="btn rose_btn doc_more">Докладніше про лікаря</a>
                                <div class="doc-plate rose-plate">Акція</div>
                            </div>

                            <div class="swiper-slide top_docs_preview">
                                <div class="doc_number_one_image">
                                    <img src="image/top_slider1.png" alt="">
                                </div>
                                <div class="fio_doc_spec">
                                    <p class="fio_doc">Некрасова Анна</p>
                                    <p class="spec_doc">Лікар дермовенеролог, косметолог</p>
                                </div>
                                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                    <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                        </svg>
                                        <p><b>4.8</b> (105)</p>
                                    </div>
                                    <div class="_flex-display _align-bottom top_docs-city">
                                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p><b>м. Київ</b></p>
                                    </div>
                                </div>
                                <div class="top_docs-spec">
                                    <p>Послуги: <span>Збільшення губ, Біоревіталізація, Чистка, Пілінг</span></p>
                                </div>
                                <a href="#" class="btn rose_btn doc_more">Докладніше про лікаря</a>
                            </div>

                            <div class="swiper-slide top_docs_preview">
                                <div class="doc_number_one_image">
                                    <img src="image/number-one.png" alt="">
                                </div>
                                <div class="fio_doc_spec">
                                    <p class="fio_doc">Некрасова Анна</p>
                                    <p class="spec_doc">Лікар дермовенеролог, косметолог</p>
                                </div>
                                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                    <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                        </svg>
                                        <p><b>4.8</b> (105)</p>
                                    </div>
                                    <div class="_flex-display _align-bottom top_docs-city">
                                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p><b>м. Київ</b></p>
                                    </div>
                                </div>
                                <div class="top_docs-spec">
                                    <p>Послуги: <span>Збільшення губ, Біоревіталізація, Чистка, Пілінг</span></p>
                                </div>
                                <a href="#" class="btn rose_btn doc_more">Докладніше про лікаря</a>
                                <div class="doc-plate rose-plate">Акція</div>
                            </div>

                            <div class="swiper-slide top_docs_preview">
                                <div class="doc_number_one_image">
                                    <img src="image/top_slider1.png" alt="">
                                </div>
                                <div class="fio_doc_spec">
                                    <p class="fio_doc">Некрасова Анна</p>
                                    <p class="spec_doc">Лікар дермовенеролог, косметолог</p>
                                </div>
                                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                    <div class="_flex-display _align-bottom top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                        </svg>
                                        <p><b>4.8</b> (105)</p>
                                    </div>
                                    <div class="_flex-display _align-bottom top_docs-city">
                                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p><b>м. Київ</b></p>
                                    </div>
                                </div>
                                <div class="top_docs-spec">
                                    <p>Послуги: <span>Збільшення губ, Біоревіталізація, Чистка, Пілінг</span></p>
                                </div>
                                <a href="#" class="btn rose_btn doc_more">Докладніше про лікаря</a>
                            </div>

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
            <p class="subtitle">Про нас</p>
            <h1><span class="h1-title">Connect Cosmetology <span class="h1-line"><svg xmlns="http://www.w3.org/2000/svg" width="255" height="14" viewBox="0 0 255 14" fill="none">
  <path d="M0.5 12L254 2" stroke="#F396A2" stroke-width="3"/>
</svg></span></span>- це твоя платформа з пошуку свого косметолога</h1>
            <div class="_flex-display _justify-content-between _align-stretch platform-block">
                <div class="platform-modals">
                    <div class="_flex-display _justify-content-between _align-stretch platform-modal platform-modal-top">
                        <div class="_flex-display _justify-content-between platform-modal-grey">
                            <div class="_flex-display _justify-content-between _align-center">
                                <div class="_flex-display _justify-content-center _align-center platform-about_plate">Про нас</div>
                                <a href="#"><svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                        <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                                    </svg></a>
                            </div>
                            <div class="platform-about-text">
                                <p>Відкривай мапу, вводь необхідні параметри у фільтр, шукай свого косметолога за рейтингом, процедурою або по фото його робіт. </p>
                                <p>Заходь у фотобанк, дивись роботи фахівців, обери зміни, які ти прагнеш побачити у себе на обличчі, читай, що було зроблено, клікай на надпис під фото і переходь на сторінку фахівця, автора змін.</p>
                            </div>
                        </div>
                        <div class="platform-modal-rose"></div>
                    </div>
                    <div class="_flex-display _justify-content-between _align-stretch platform-modal platform-modal-bottom _minwidth769">
                        <div class="_flex-display _justify-content-between _align-bottom platform-modal-rose">
                            <div class="_flex-display _justify-content-center _align-center platform-photo_plate">Фотобанк</div>
                            <a href="#"><svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                    <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                                </svg></a>
                        </div>
                        <div class="platform-modal-grey">
                            <div class="_flex-display _justify-content-between _align-center">
                                <div class="_flex-display _justify-content-center _align-center platform-action_plate">Акція</div>
                                <a href="#"><svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                        <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                                    </svg></a>
                            </div>
                            <div class="_flex-display _justify-content-between _align-center platform-action-bottom">
                                <div class="platform-action-image"><img src="image/platform-action-image.png" alt="" /></div>
                                <div class="platform-action-text">
                                    <p class="platform-action-title">-20% на першу процедуру</p>
                                    <p>Збільшення губ, Біоревіталізація, Чистка, Пілінг</p>
                                    <div class="fio_doc_spec">
                                        <p class="fio_doc">Некрасова Анна</p>
                                        <p class="spec_doc">Лікар дермовенеролог, косметолог</p>
                                    </div>
                                    <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                        <div class="_flex-display _align-center top_docs-rating"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                            </svg>
                                            <p><b>4.8</b> (105)</p>
                                        </div>
                                        <div class="_flex-display _align-center top_docs-city">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="13" viewBox="0 0 11 13" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.60028C7 4.77152 6.32846 4.09998 5.5003 4.09998C4.67154 4.09998 4 4.77152 4 5.60028C4 6.42843 4.67154 7.09998 5.5003 7.09998C6.32846 7.09998 7 6.42843 7 5.60028Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9C4.78062 11.9 1 8.839 1 5.63795C1 3.13196 3.01426 1.09998 5.49971 1.09998C7.98515 1.09998 10 3.13196 10 5.63795C10 8.839 6.21879 11.9 5.49971 11.9Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p><b>м. Київ</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="platform-services">
                    <div class="platform-services-plate">Популярні послуги</div>
                    <ul class="platform-services-list">
                        <li><a href="">Біоревіталізація</a></li>
                        <li><a href="">Контурна пластика обличчя</a></li>
                        <li><a href="">Збільшення губ (контурна пластика губ)</a></li>
                        <li><a href="">Ультразвукова чистка</a></li>
                        <li><a href="">Корекція зморшок ботулотоксином</a></li>
                        <li><a href="">RF-ліфтинг</a></li>
                        <li><a href="">Екзосоми</a></li>
                        <li><a href="">SMAS-ліфтинг</a></li>
                        <li><a href="">Лікування стрій</a></li>
                    </ul>
                </div>
                <div class="_flex-display _justify-content-between _align-stretch platform-modal platform-modal-bottom _maxwidth768">
                    <div class="platform-modal-grey">
                        <div class="_flex-display _justify-content-between _align-center">
                            <div class="_flex-display _justify-content-center _align-center platform-action_plate">Акція</div>
                            <a href="#"><svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                    <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                                </svg></a>
                        </div>
                        <div class="_flex-display _justify-content-between _align-center platform-action-bottom">
                            <div class="platform-action-image"><img src="image/platform-action-image.png" alt="" /></div>
                            <div class="platform-action-text">
                                <p class="platform-action-title">-20% на першу процедуру</p>
                                <p>Збільшення губ, Біоревіталізація, Чистка, Пілінг</p>
                                <div class="fio_doc_spec">
                                    <p class="fio_doc">Некрасова Анна</p>
                                    <p class="spec_doc">Лікар дермовенеролог, косметолог</p>
                                </div>
                                <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">
                                    <div class="_flex-display _align-center top_docs-rating"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                        </svg>
                                        <p><b>4.8</b> (105)</p>
                                    </div>
                                    <div class="_flex-display _align-center top_docs-city">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="13" viewBox="0 0 11 13" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.60028C7 4.77152 6.32846 4.09998 5.5003 4.09998C4.67154 4.09998 4 4.77152 4 5.60028C4 6.42843 4.67154 7.09998 5.5003 7.09998C6.32846 7.09998 7 6.42843 7 5.60028Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9C4.78062 11.9 1 8.839 1 5.63795C1 3.13196 3.01426 1.09998 5.49971 1.09998C7.98515 1.09998 10 3.13196 10 5.63795C10 8.839 6.21879 11.9 5.49971 11.9Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p><b>м. Київ</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_flex-display _justify-content-center _align-bottom platform-modal-rose">
                        <div class="_flex-display _justify-content-center _align-center platform-photo_plate">Фотобанк</div>
                        <a href="#"><svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 12.5C0 5.59644 5.59644 0 12.5 0H13.5C20.4036 0 26 5.59644 26 12.5C26 19.4036 20.4036 25 13.5 25H12.5C5.59644 25 0 19.4036 0 12.5Z" fill="white"/>
                                <path d="M7.33104 16.2567C6.92053 16.6262 6.88725 17.2585 7.25671 17.669C7.62616 18.0795 8.25845 18.1128 8.66896 17.7433L7.33104 16.2567ZM18.9986 8.05256C19.0276 7.50104 18.6041 7.03041 18.0526 7.00138L9.065 6.52835C8.51348 6.49932 8.04285 6.92289 8.01382 7.47441C7.98479 8.02593 8.40836 8.49656 8.95988 8.52559L16.9488 8.94606L16.5284 16.935C16.4993 17.4865 16.9229 17.9572 17.4744 17.9862C18.0259 18.0152 18.4966 17.5916 18.5256 17.0401L18.9986 8.05256ZM8 17L8.66896 17.7433L18.669 8.74329L18 8L17.331 7.25671L7.33104 16.2567L8 17Z" fill="black"/>
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="home-articles">
        <div class="container">
            <div class="_flex-display _justify-content-between _align-stretch home-articles-list">
                <div class="article first-article _minwidth769">
                    <div class="article-image">
                        <img src="image/a1.jpg" alt="" />
                    </div>
                    <a class="_flex-display _justify-content-between _align-center article_title" href="#"><h5>SPF, як обрати? Поради лікаря</h5><svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 17.5C0 7.83502 7.83502 0 17.5 0H18.5C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35H17.5C7.83502 35 0 27.165 0 17.5Z" fill="#F396A2"/>
                            <path d="M12.331 21.2567C11.9205 21.6262 11.8872 22.2585 12.2567 22.669C12.6262 23.0795 13.2585 23.1128 13.669 22.7433L12.331 21.2567ZM23.9986 13.0526C24.0276 12.501 23.6041 12.0304 23.0526 12.0014L14.065 11.5284C13.5135 11.4993 13.0428 11.9229 13.0138 12.4744C12.9848 13.0259 13.4084 13.4966 13.9599 13.5256L21.9488 13.9461L21.5284 21.935C21.4993 22.4865 21.9229 22.9572 22.4744 22.9862C23.0259 23.0152 23.4966 22.5916 23.5256 22.0401L23.9986 13.0526ZM13 22L13.669 22.7433L23.669 13.7433L23 13L22.331 12.2567L12.331 21.2567L13 22Z" fill="white"/>
                        </svg>
                    </a>
                    <p>Lorem ipsum dolor sit amet consectetur. Neque leo morbi viverra cursus quam quam malesuada.</p>
                </div>
                <div class="home-articles-right">
                    <p class="subtitle">Корисні статті</p>
                    <h2>Дізнайся про <span>важливе</span></h2>
                    <div class="_flex-display _justify-content-between _align-stretch home-articles-23">
                        <div class="article _maxwidth768">
                            <div class="article-image">
                                <img src="image/a1.jpg" alt="" />
                            </div>
                            <a class="_flex-display _justify-content-between _align-center article_title" href="#"><h5>SPF, як обрати? Поради лікаря</h5><svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 17.5C0 7.83502 7.83502 0 17.5 0H18.5C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35H17.5C7.83502 35 0 27.165 0 17.5Z" fill="#F396A2"/>
                                    <path d="M12.331 21.2567C11.9205 21.6262 11.8872 22.2585 12.2567 22.669C12.6262 23.0795 13.2585 23.1128 13.669 22.7433L12.331 21.2567ZM23.9986 13.0526C24.0276 12.501 23.6041 12.0304 23.0526 12.0014L14.065 11.5284C13.5135 11.4993 13.0428 11.9229 13.0138 12.4744C12.9848 13.0259 13.4084 13.4966 13.9599 13.5256L21.9488 13.9461L21.5284 21.935C21.4993 22.4865 21.9229 22.9572 22.4744 22.9862C23.0259 23.0152 23.4966 22.5916 23.5256 22.0401L23.9986 13.0526ZM13 22L13.669 22.7433L23.669 13.7433L23 13L22.331 12.2567L12.331 21.2567L13 22Z" fill="white"/>
                                </svg>
                            </a>
                            <p>Lorem ipsum dolor sit amet consectetur. Neque leo morbi viverra cursus quam quam malesuada.</p>
                        </div>
                        <div class="article">
                            <div class="article-image">
                                <img src="image/a2.jpg" alt="" />
                            </div>
                            <a class="_flex-display _justify-content-between _align-center article_title" href="#"><h5>Збільшення губ</h5><svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 17.5C0 7.83502 7.83502 0 17.5 0H18.5C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35H17.5C7.83502 35 0 27.165 0 17.5Z" fill="#F396A2"/>
                                    <path d="M12.331 21.2567C11.9205 21.6262 11.8872 22.2585 12.2567 22.669C12.6262 23.0795 13.2585 23.1128 13.669 22.7433L12.331 21.2567ZM23.9986 13.0526C24.0276 12.501 23.6041 12.0304 23.0526 12.0014L14.065 11.5284C13.5135 11.4993 13.0428 11.9229 13.0138 12.4744C12.9848 13.0259 13.4084 13.4966 13.9599 13.5256L21.9488 13.9461L21.5284 21.935C21.4993 22.4865 21.9229 22.9572 22.4744 22.9862C23.0259 23.0152 23.4966 22.5916 23.5256 22.0401L23.9986 13.0526ZM13 22L13.669 22.7433L23.669 13.7433L23 13L22.331 12.2567L12.331 21.2567L13 22Z" fill="white"/>
                                </svg>
                            </a>
                            <p>Lorem ipsum dolor sit amet consectetur. Neque leo morbi viverra cursus quam quam malesuada.</p>
                        </div>
                        <div class="article">
                            <div class="article-image">
                                <img src="image/a3.jpg" alt="" />
                            </div>
                            <a class="_flex-display _justify-content-between _align-center article_title" href="#"><h5>Ультразвукова чистка</h5><svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 17.5C0 7.83502 7.83502 0 17.5 0H18.5C28.165 0 36 7.83502 36 17.5C36 27.165 28.165 35 18.5 35H17.5C7.83502 35 0 27.165 0 17.5Z" fill="#F396A2"/>
                                    <path d="M12.331 21.2567C11.9205 21.6262 11.8872 22.2585 12.2567 22.669C12.6262 23.0795 13.2585 23.1128 13.669 22.7433L12.331 21.2567ZM23.9986 13.0526C24.0276 12.501 23.6041 12.0304 23.0526 12.0014L14.065 11.5284C13.5135 11.4993 13.0428 11.9229 13.0138 12.4744C12.9848 13.0259 13.4084 13.4966 13.9599 13.5256L21.9488 13.9461L21.5284 21.935C21.4993 22.4865 21.9229 22.9572 22.4744 22.9862C23.0259 23.0152 23.4966 22.5916 23.5256 22.0401L23.9986 13.0526ZM13 22L13.669 22.7433L23.669 13.7433L23 13L22.331 12.2567L12.331 21.2567L13 22Z" fill="white"/>
                                </svg>
                            </a>
                            <p>Lorem ipsum dolor sit amet consectetur. Neque leo morbi viverra cursus quam quam malesuada.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="container">
        <div class="_flex-display _justify-content-between _align-stretch footer">
            <div class="_flex-display _justify-content-between footer_left">
                <div class="footer_logo"><a href="/home.php"><img src="image/footer_logo.png" /></a></div>
                <div class="_flex-display _align-center footer_share _minwidth769">
                    <a href="#"><svg width="29" height="30" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.55016 0.833496H20.4502C24.9835 0.833496 28.6668 4.51683 28.6668 9.05016V20.9502C28.6668 23.1294 27.8011 25.2193 26.2602 26.7602C24.7193 28.3011 22.6294 29.1668 20.4502 29.1668H8.55016C4.01683 29.1668 0.333496 25.4835 0.333496 20.9502V9.05016C0.333496 6.87097 1.19918 4.78103 2.7401 3.2401C4.28103 1.69918 6.37097 0.833496 8.55016 0.833496ZM8.26683 3.66683C6.91423 3.66683 5.61702 4.20415 4.66059 5.16059C3.70415 6.11702 3.16683 7.41423 3.16683 8.76683V21.2335C3.16683 24.0527 5.44766 26.3335 8.26683 26.3335H20.7335C22.0861 26.3335 23.3833 25.7962 24.3397 24.8397C25.2962 23.8833 25.8335 22.5861 25.8335 21.2335V8.76683C25.8335 5.94766 23.5527 3.66683 20.7335 3.66683H8.26683ZM21.9377 5.79183C22.4073 5.79183 22.8577 5.9784 23.1898 6.31049C23.5219 6.64259 23.7085 7.09301 23.7085 7.56266C23.7085 8.03232 23.5219 8.48274 23.1898 8.81483C22.8577 9.14693 22.4073 9.3335 21.9377 9.3335C21.468 9.3335 21.0176 9.14693 20.6855 8.81483C20.3534 8.48274 20.1668 8.03232 20.1668 7.56266C20.1668 7.09301 20.3534 6.64259 20.6855 6.31049C21.0176 5.9784 21.468 5.79183 21.9377 5.79183ZM14.5002 7.91683C16.3788 7.91683 18.1805 8.66311 19.5088 9.99149C20.8372 11.3199 21.5835 13.1215 21.5835 15.0002C21.5835 16.8788 20.8372 18.6805 19.5088 20.0088C18.1805 21.3372 16.3788 22.0835 14.5002 22.0835C12.6215 22.0835 10.8199 21.3372 9.49149 20.0088C8.16311 18.6805 7.41683 16.8788 7.41683 15.0002C7.41683 13.1215 8.16311 11.3199 9.49149 9.99149C10.8199 8.66311 12.6215 7.91683 14.5002 7.91683ZM14.5002 10.7502C13.373 10.7502 12.292 11.1979 11.495 11.995C10.6979 12.792 10.2502 13.873 10.2502 15.0002C10.2502 16.1273 10.6979 17.2083 11.495 18.0054C12.292 18.8024 13.373 19.2502 14.5002 19.2502C15.6273 19.2502 16.7083 18.8024 17.5054 18.0054C18.3024 17.2083 18.7502 16.1273 18.7502 15.0002C18.7502 13.873 18.3024 12.792 17.5054 11.995C16.7083 11.1979 15.6273 10.7502 14.5002 10.7502Z" fill="black"/>
                        </svg>
                    </a>
                    <a href="#"><svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.7083 23.3335L28.25 2.0835L11.25 14.1252" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M28.2502 2.0835L1.3335 12.7085" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24.7083 23.3333L11.25 14.125" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1.3335 12.7085L11.2502 14.1252" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.5 17.6667L11.25 21.9167V14.125" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="footer_proc">
                <h6>Обрати процедуру</h6>
                <ul>
                    <li><a href="#">Якість шкіри</a></li>
                    <li><a href="#">Контурна пластика</a></li>
                    <li><a href="#">Ботулінотерапія</a></li>
                    <li><a href="#">Колагеностимуляція</a></li>
                    <li><a href="#">Апаратна косметологія</a></li>
                    <li><a href="#">Чистки та базовий догляд</a></li>
                    <li><a href="#">Anti-age програми</a></li>
                    <li><a href="#">Лікування проблемної шкіри</a></li>
                    <li><a href="#">Догляд за тілом </a></li>
                    <li><a href="#">Дерматологія</a></li>
                    <li><a href="#">Підліткова косметологія</a></li>
                    <li><a href="#">Навчання косметологів</a></li>
                </ul>
            </div>
            <div class="footer_menu">
                <ul>
                    <li><a href="/search.php">Мапа косметологів</a></li>
                    <li><a href="/about.php">Про сервіс</a></li>
                    <li><a href="/photobank.php">Фотобанк</a></li>
                    <li><a href="/news.php">Новини</a></li>
                    <li><a href="#">Корисні статті</a></li>
                </ul>
            </div>
            <div class="_flex-display _justify-content-between footer_right">
                <div class="_flex-display _align-center footer_share _maxwidth768">
                    <a href="#"><svg width="29" height="30" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.55016 0.833496H20.4502C24.9835 0.833496 28.6668 4.51683 28.6668 9.05016V20.9502C28.6668 23.1294 27.8011 25.2193 26.2602 26.7602C24.7193 28.3011 22.6294 29.1668 20.4502 29.1668H8.55016C4.01683 29.1668 0.333496 25.4835 0.333496 20.9502V9.05016C0.333496 6.87097 1.19918 4.78103 2.7401 3.2401C4.28103 1.69918 6.37097 0.833496 8.55016 0.833496ZM8.26683 3.66683C6.91423 3.66683 5.61702 4.20415 4.66059 5.16059C3.70415 6.11702 3.16683 7.41423 3.16683 8.76683V21.2335C3.16683 24.0527 5.44766 26.3335 8.26683 26.3335H20.7335C22.0861 26.3335 23.3833 25.7962 24.3397 24.8397C25.2962 23.8833 25.8335 22.5861 25.8335 21.2335V8.76683C25.8335 5.94766 23.5527 3.66683 20.7335 3.66683H8.26683ZM21.9377 5.79183C22.4073 5.79183 22.8577 5.9784 23.1898 6.31049C23.5219 6.64259 23.7085 7.09301 23.7085 7.56266C23.7085 8.03232 23.5219 8.48274 23.1898 8.81483C22.8577 9.14693 22.4073 9.3335 21.9377 9.3335C21.468 9.3335 21.0176 9.14693 20.6855 8.81483C20.3534 8.48274 20.1668 8.03232 20.1668 7.56266C20.1668 7.09301 20.3534 6.64259 20.6855 6.31049C21.0176 5.9784 21.468 5.79183 21.9377 5.79183ZM14.5002 7.91683C16.3788 7.91683 18.1805 8.66311 19.5088 9.99149C20.8372 11.3199 21.5835 13.1215 21.5835 15.0002C21.5835 16.8788 20.8372 18.6805 19.5088 20.0088C18.1805 21.3372 16.3788 22.0835 14.5002 22.0835C12.6215 22.0835 10.8199 21.3372 9.49149 20.0088C8.16311 18.6805 7.41683 16.8788 7.41683 15.0002C7.41683 13.1215 8.16311 11.3199 9.49149 9.99149C10.8199 8.66311 12.6215 7.91683 14.5002 7.91683ZM14.5002 10.7502C13.373 10.7502 12.292 11.1979 11.495 11.995C10.6979 12.792 10.2502 13.873 10.2502 15.0002C10.2502 16.1273 10.6979 17.2083 11.495 18.0054C12.292 18.8024 13.373 19.2502 14.5002 19.2502C15.6273 19.2502 16.7083 18.8024 17.5054 18.0054C18.3024 17.2083 18.7502 16.1273 18.7502 15.0002C18.7502 13.873 18.3024 12.792 17.5054 11.995C16.7083 11.1979 15.6273 10.7502 14.5002 10.7502Z" fill="black"/>
                        </svg>
                    </a>
                    <a href="#"><svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.7083 23.3335L28.25 2.0835L11.25 14.1252" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M28.2502 2.0835L1.3335 12.7085" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24.7083 23.3333L11.25 14.125" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1.3335 12.7085L11.2502 14.1252" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.5 17.6667L11.25 21.9167V14.125" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
                <div class="footer_subscribe">
                    <div class="footer_subscribe_block">
                        <p>Підписатись <br>на новини</p>
                        <form>
                            <input type="email" class="subscribe_email" value="" placeholder="E-mail">
                            <button class="btn rose_btn send_button" type="submit">Надіслати</button>
                        </form>
                    </div>
                </div>
                <div class="_flex-display _align-center footer_links">
                    <a href="#">Privacy policy</a>
                    <a href="#">Cookie policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="login_window" class="_flex-display _justify-content-center _align-center screen _display_none">
    <div class="window login_appointment_window">
        <div class="_flex-display _justify-content-between _align-center window_top">
            <h4>Увійдіть до вашого аккаунту</h4>
            <div id="window_close">
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
        <form id="login">
            <div class="search_field search_field_input"><input type="email" placeholder="Ваш e-mail"></div>
            <div class="search_field search_field_input"><input type="password" placeholder="Пароль"></div>
            <label class="_flex-display _align-center more_filter_checkbox">
                <input id="check_discount" type="checkbox" name="discount">
                <span class="checkmark"></span>
                <span class="check_title">Запам’ятати мене</span>
            </label>
            <button type="submit" class="btn rose_btn">Увійти</button>
        </form>
        <p class="or">Або</p>
        <a class="btn google_btn">Вхід за допомогою Google</a>
        <a class="btn facebook_btn">Вхід за допомогою Facebook</a>
        <a class="forgot_link">Забули пароль?</a>
    </div>
</div>
<div id="register_window" class="_flex-display _justify-content-center _align-center screen _display_none">
    <div class="window login_appointment_window">
        <div class="_flex-display _justify-content-between _align-center window_top">
            <h4>Увійдіть до вашого аккаунту</h4>
            <div id="window_close">
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
        <form id="register" class="_flex-display _justify-content-between _align-center">
            <div class="_flex-display _align-center form_spec_client">
                <span>Ви:</span><a class="btn white_rose_btn">Клієнт</a><a href="#" class="btn rose_btn">Спеціаліст</a>
            </div>
            <div class="search_field search_field_input"><input type="text" placeholder="Ваше ім’я"></div>
            <div class="search_field search_field_input"><input type="text" placeholder="Ваше прізвище"></div>
            <div class="search_field search_field_input"><input type="email" placeholder="Ваш e-mail"></div>
            <div class="search_field search_field_input"><input type="tel" placeholder="Ваш номер телефону"></div>
            <div class="search_field search_field_sex">
                <select id="search_sex" class="search_sex" name="sex">
                    <option value="">Ваша стать</option>
                    <option value="Чоловік">Чоловік</option>
                    <option value="Жінка">Жінка</option>
                </select>
            </div>
            <div class="search_field search_field_city">
                <select id="search_city" class="search_city" name="city">
                    <option value="Київ">Київ</option>
                </select>
            </div>
            <div class="search_field search_field_experience">
                <select id="search_experience" class="search_experience" name="experience">
                    <option value="">Досвід</option>
                    <option value="1">1</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                </select>
            </div>
            <div class="search_field search_field_input"><input type="password" placeholder="Ваш пароль"></div>
            <div class="search_field search_field_input"><input type="password" placeholder="Повторіть пароль"></div>
            <label class="_flex-display _align-center more_filter_checkbox">
                <input id="check_discount" type="checkbox" name="discount">
                <span class="checkmark"></span>
                <span class="check_title">Я приймаю <a href="#">правила сайту</a></span>
            </label>
            <button type="submit" class="btn rose_btn">Зареєструватись</button>
        </form>
        <p class="or">Або</p>
        <a class="btn google_btn">Вхід за допомогою Google</a>
        <a class="btn facebook_btn">Вхід за допомогою Facebook</a>
        <p class="form_text_link">Вже маєте обліковий запис? <a class="form_text_login">Увійти</a></p>
    </div>
</div>
<div id="btn_top"><img src="image/top.png" /></div>
</body>
</html>
