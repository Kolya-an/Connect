<main>
    <div class="search_content">
        <div class="search_map">
            <div>
                <div wire:ignore id="map" style="height: 100vh;"></div>
            </div>
            <script>
                document.addEventListener('livewire:init', () => {
                    let mapInitialized = false;
                    let map;
                    let markersLayer = L.layerGroup();

                    // Координаты Киева (Default)
                    const defaultLat = 50.4501;
                    const defaultLng = 30.5234;

                    /**
                     * Преобразует радиус поиска (в км) в соответствующий уровень масштабирования карты.
                     * @param {number} radiusKm - Радиус в километрах.
                     * @returns {number} Уровень масштабирования (zoom level).
                     */
                    function getZoomForRadius(radiusKm) {
                        if (radiusKm <= 1) return 15;
                        if (radiusKm <= 3) return 14;
                        if (radiusKm <= 5) return 13; // Стандартный для 5 км
                        if (radiusKm <= 10) return 12;
                        if (radiusKm <= 25) return 11;
                        if (radiusKm <= 50) return 10;
                        if (radiusKm <= 100) return 9;
                        return 7; // Для радиусов > 100 км
                    }

                    // --- 1. ФУНКЦИИ КАРТЫ (Оставить как есть) ---

                    function initMap(lat, lng, zoom = 13) {
                        if (mapInitialized) return;
                        map = L.map('map').setView([lat, lng], zoom);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
                        markersLayer.addTo(map);
                        mapInitialized = true;
                    }

                    function updateMapCenter(lat, lng, zoom = 13) {
                        if (!mapInitialized) return;
                        map.setView([lat, lng], zoom);
                    }
                    Livewire.on('updateMapMarkers', (event) => {
                        const data = event.detail || event;
                        const doctors = data.doctors;
                        if (!doctors || doctors.length === 0) {
                            markersLayer.clearLayers();
                            return;
                        }
                        markersLayer.clearLayers();

                        console.log('Doctors data:', doctors); // DEBUG

                        doctors.forEach(doc => {
                            console.log('Doctor:', doc.user_id, 'Promotions:', doc.promotions); // DEBUG

                            const marker = L.marker([doc.latitude, doc.longitude]);
                            const giftIcon = doc.gift === 1 ? '&#127873;' : '';
                            const hasActivePromotions = doc.promotions && doc.promotions.some(promo => {
                                const now = new Date();
                                const dateFrom = new Date(promo.date_from);
                                const dateTo = new Date(promo.date_to);
                                return now >= dateFrom && now <= dateTo;
                            });

                            const actionIcon = hasActivePromotions ? '&#37;' : '';

                            // Додаємо назви акцій, у яких map=1 і входять в діапазон дат
                            let promotionsHtml = '';
                            if (doc.promotions) {
                                const now = new Date();
                                console.log('Checking promotions for doctor:', doc.user_id); // DEBUG
                                const mapPromotions = doc.promotions.filter(promo => {
                                    console.log('Promo:', promo.title, 'map:', promo.map, 'date_from:', promo.date_from, 'date_to:', promo.date_to); // DEBUG
                                    const dateFrom = new Date(promo.date_from);
                                    const dateTo = new Date(promo.date_to);
                                    return promo.map == 1 && now >= dateFrom && now <= dateTo;
                                });

                                console.log('Map promotions:', mapPromotions); // DEBUG

                                if (mapPromotions.length > 0) {
                                    promotionsHtml = '<div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #eee;">';
                                    mapPromotions.forEach(promo => {
                                        promotionsHtml += '<div style="margin-bottom: 4px;"><b style="color: #f396a2;">' + promo.title + '</b>';
                                        if (promo.new_price && promo.old_price) {
                                            promotionsHtml += '<br><span style="text-decoration: line-through; color: #999;">' + promo.old_price + '₴</span> <b>' + promo.new_price + '₴</b>';
                                        }
                                        promotionsHtml += '</div>';
                                    });
                                    promotionsHtml += '</div>';
                                }
                            }

                            const info = `<a href="/doctors/${doc.user_id}"><b>${doc.user.name} ${doc.second_name}</b></a>
                            <br>${doc.address}<br>{{__("Рейтинг")}}: ${doc.rating}
                            <br>${giftIcon} ${actionIcon}${promotionsHtml}`;
                            marker.bindPopup(info);
                            markersLayer.addLayer(marker);
                        });
                    });
                    // --- 2. ПОЛУЧЕНИЕ НАЧАЛЬНЫХ КООРДИНАТ ИЗ LIVEWIRE (НОВЫЙ БЛОК) ---

                    // @this.get('userLat') возвращает текущее значение свойства $userLat из PHP.
                    const initialLat = @js($this->userLat) || defaultLat;
                    const initialLng = @js($this->userLng) || defaultLng;
                    const initialRadius = @js($this->radius) || 5;
                    const city = @js($this->city);
                    const doctorId = @js($this->doctorId);
                    const initialZoom = getZoomForRadius(initialRadius);

                    // 2.1. Инициализация карты
                    initMap(initialLat, initialLng, initialZoom);

                    // 2.2. Если координаты установлены городом, пропускаем геолокацию.
                    if (initialLat !== defaultLat) {
                        console.log("Map initialized by city coordinates.");
                        // Карта центрирована на городе, геолокацию не запрашиваем.
                        return;
                    }

                    // 2.3. Если карта инициализирована Киевом, запрашиваем геолокацию
                    navigator.geolocation.getCurrentPosition(pos => {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;

                        // Отправляем геолокацию в Livewire (для обновления $userLat/Lng и DoctorsList)
                        // Используем правильный синтаксис Livewire v3 для setUserLocation:
                        Livewire.dispatch('setUserLocation', { lat: lat, lng: lng });

                        // Если город не выбран (т.е. мы начали с defaultLat/Lng), центрируем на геолокации
                        if (!city) {
                            updateMapCenter(lat, lng, getZoomForRadius(initialRadius));
                        }

                    }, error => {
                        // Если геолокация недоступна, отправляем Киев в Livewire
                        Livewire.dispatch('setUserLocation', { lat: defaultLat, lng: defaultLng });
                    });

                    // --- 3. СЛУШАТЕЛИ (Оставить как есть) ---

                    Livewire.on('updateMapCenter', (coordinates) => {
                        const radius = coordinates.radius || 5; // Берем радиус из события, по умолчанию 5
                        const zoom = getZoomForRadius(radius); // Вычисляем zoom
                        updateMapCenter(coordinates.lat, coordinates.lng, 13, zoom);
                    });



                });
            </script>
        </div>
        <div class="container">
            <div class="search_column">
                <div class="search_banner">
                    <div class="search_banner_title">
                        <h3>{{__('Записуйся')}} <span>{{__('зручно і швидко')}}</span></h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="319" height="12" viewBox="0 0 319 12" fill="none">
                            <path d="M1 10.5L318 2" stroke="#F396A2" stroke-width="3"/>
                        </svg>
                    </div>
                    <div class="_flex-display _align-center home_banner_bottom">
                        <div class="_flex-display _align-center home_banner_images"><img src="{{ asset('images/home_banner_images.png') }}" alt=""></div>
                        <div class="_flex-display home_banner_bottom_text">
                            <div class="_flex-display rating_stars">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="white"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="white"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="white"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="white"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="white"/>
                                </svg>
                            </div>
                            <p><b>+3000</b> {{__('перевіренних косметологів і фахівців естетичної медицини')}}</p>
                        </div>
                    </div>
                    <div class="home_search_bg _minwidth769"><img src="{{ asset('images/search_banner.png') }}" alt=""></div>
                </div>
                <livewire:map-search-form />
                <div class="_flex-display _align-center sort_block">
                    <p>{{__('Сортувати')}}: </p>
                    <div class="search_field sort">
                        <select class="sort" wire:model.live="sort">
                            <option value="rating">{{__('за рейтингом лікаря')}}</option>
                            <option value="cheaper">{{__('дешевше')}}</option>
                            <option value="expensive">{{__('дорожче')}}</option>
                            <option value="reviews">{{__('за відгуками')}}</option>
                        </select>
                    </div>
                </div>
                <div class="doctors">
                    @if(count($doctors) == 0)
                        <p>{{__('Немає лікарів у цьому радіусі')}}.</p>
                    @else
                        @foreach($doctors as $doc)


                    <div class="_flex-display _justify-content-between doctor">
                        <div class="doctor_left">
                            <div class="_flex-display _justify-content-between _align-center doctor_right_top _maxwidth768">
                                @if($doc->plate)
                                    <div class="doc-plate rose-plate">{{ $doc->plate }}</div>
                                @endif
                                @if($doc->share)
                                    <a href="{{ $doc->share }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17 22C16.1667 22 15.4583 21.7083 14.875 21.125C14.2917 20.5417 14 19.8333 14 19C14 18.9 14.025 18.6667 14.075 18.3L7.05 14.2C6.78333 14.45 6.475 14.646 6.125 14.788C5.775 14.93 5.4 15.0007 5 15C4.16667 15 3.45833 14.7083 2.875 14.125C2.29167 13.5417 2 12.8333 2 12C2 11.1667 2.29167 10.4583 2.875 9.875C3.45833 9.29167 4.16667 9 5 9C5.4 9 5.775 9.071 6.125 9.213C6.475 9.355 6.78333 9.55067 7.05 9.8L14.075 5.7C14.0417 5.58333 14.021 5.471 14.013 5.363C14.005 5.255 14.0007 5.134 14 5C14 4.16667 14.2917 3.45833 14.875 2.875C15.4583 2.29167 16.1667 2 17 2C17.8333 2 18.5417 2.29167 19.125 2.875C19.7083 3.45833 20 4.16667 20 5C20 5.83333 19.7083 6.54167 19.125 7.125C18.5417 7.70833 17.8333 8 17 8C16.6 8 16.225 7.929 15.875 7.787C15.525 7.645 15.2167 7.44933 14.95 7.2L7.925 11.3C7.95833 11.4167 7.97933 11.5293 7.988 11.638C7.99667 11.7467 8.00067 11.8673 8 12C7.99933 12.1327 7.99533 12.2537 7.988 12.363C7.98067 12.4723 7.95967 12.5847 7.925 12.7L14.95 16.8C15.2167 16.55 15.525 16.3543 15.875 16.213C16.225 16.0717 16.6 16.0007 17 16C17.8333 16 18.5417 16.2917 19.125 16.875C19.7083 17.4583 20 18.1667 20 19C20 19.8333 19.7083 20.5417 19.125 21.125C18.5417 21.7083 17.8333 22 17 22Z" fill="#F396A2"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            @if($doc->photo)
                                <div class="doctor_photo"><img src="{{ asset('uploads/' . $doc->photo) }}" alt="{{ $doc->user->name }} {{ $doc->second_name }}"></div>
                            @endif
                            <div class="doctor_left_bottom">
                                @if($doc->gift)
                                <div class="_flex-display _justify-content-center _align-center first_gift _maxwidth768">
                                    <div class="first_gift_icon"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.25 6.00001C6.24993 5.33164 6.45593 4.6795 6.83993 4.13245C7.22393 3.58539 7.76725 3.17004 8.39587 2.94297C9.02449 2.7159 9.70783 2.68817 10.3528 2.86354C10.9977 3.03892 11.5729 3.40888 12 3.92301C12.5438 3.2615 13.3267 2.84134 14.1785 2.75384C15.0303 2.66634 15.8823 2.91856 16.5492 3.4557C17.2161 3.99284 17.6441 4.77148 17.7401 5.6224C17.8361 6.47333 17.5924 7.32776 17.062 8.00001H18C18.3283 8.00001 18.6534 8.06467 18.9567 8.19031C19.26 8.31595 19.5356 8.5001 19.7678 8.73224C19.9999 8.96439 20.1841 9.23999 20.3097 9.5433C20.4353 9.84661 20.5 10.1717 20.5 10.5V11.75C20.5 11.9489 20.421 12.1397 20.2803 12.2803C20.1397 12.421 19.9489 12.5 19.75 12.5H13.05C13.0106 12.5 12.9716 12.4923 12.9352 12.4772C12.8988 12.4621 12.8657 12.44 12.8379 12.4121C12.81 12.3843 12.7879 12.3512 12.7728 12.3148C12.7578 12.2784 12.75 12.2394 12.75 12.2V8.74001C12.4677 8.55843 12.2148 8.33486 12 8.07701C11.7851 8.33451 11.5322 8.55774 11.25 8.73901V12.2C11.25 12.2796 11.2184 12.3559 11.1621 12.4121C11.1059 12.4684 11.0296 12.5 10.95 12.5H4.25C4.05109 12.5 3.86032 12.421 3.71967 12.2803C3.57902 12.1397 3.5 11.9489 3.5 11.75V10.5C3.5 10.1717 3.56466 9.84661 3.6903 9.5433C3.81594 9.23999 4.00009 8.96439 4.23223 8.73224C4.46438 8.5001 4.73998 8.31595 5.04329 8.19031C5.34661 8.06467 5.6717 8.00001 6 8.00001H6.938C6.4914 7.42907 6.24916 6.72487 6.25 6.00001ZM11.25 6.00001C11.25 5.53588 11.0656 5.09076 10.7374 4.76257C10.4092 4.43438 9.96413 4.25001 9.5 4.25001C9.03587 4.25001 8.59075 4.43438 8.26256 4.76257C7.93437 5.09076 7.75 5.53588 7.75 6.00001C7.75 6.46414 7.93437 6.90926 8.26256 7.23745C8.59075 7.56563 9.03587 7.75001 9.5 7.75001C9.96413 7.75001 10.4092 7.56563 10.7374 7.23745C11.0656 6.90926 11.25 6.46414 11.25 6.00001ZM12.75 6.00001C12.75 6.22982 12.7953 6.45739 12.8832 6.66971C12.9712 6.88202 13.1001 7.07494 13.2626 7.23745C13.4251 7.39995 13.618 7.52885 13.8303 7.6168C14.0426 7.70474 14.2702 7.75001 14.5 7.75001C14.7298 7.75001 14.9574 7.70474 15.1697 7.6168C15.382 7.52885 15.5749 7.39995 15.7374 7.23745C15.8999 7.07494 16.0288 6.88202 16.1168 6.66971C16.2047 6.45739 16.25 6.22982 16.25 6.00001C16.25 5.53588 16.0656 5.09076 15.7374 4.76257C15.4092 4.43438 14.9641 4.25001 14.5 4.25001C14.0359 4.25001 13.5908 4.43438 13.2626 4.76257C12.9344 5.09076 12.75 5.53588 12.75 6.00001Z" fill="#F396A2"/>
                                            <path d="M11.25 14.1501C11.25 14.0705 11.2184 13.9942 11.1622 13.938C11.1059 13.8817 11.0296 13.8501 10.95 13.8501H5.64904C5.45257 13.8497 5.26234 13.9191 5.11219 14.0458C4.96204 14.1725 4.86171 14.3484 4.82904 14.5421C4.60712 15.838 4.60712 17.1622 4.82904 18.4581L5.05304 19.7671C5.12692 20.1959 5.33794 20.5891 5.6544 20.8877C5.97087 21.1864 6.37569 21.3742 6.80804 21.4231L7.87304 21.5421C8.89504 21.6561 9.91871 21.7278 10.944 21.7571C10.9839 21.7579 11.0234 21.7508 11.0605 21.7361C11.0975 21.7214 11.1312 21.6996 11.1597 21.6717C11.1882 21.6439 11.2108 21.6107 11.2264 21.574C11.2419 21.5373 11.2499 21.4979 11.25 21.4581V14.1501ZM13.056 21.7571C13.0162 21.7579 12.9767 21.7508 12.9396 21.7361C12.9026 21.7214 12.8689 21.6996 12.8404 21.6717C12.8119 21.6439 12.7892 21.6107 12.7737 21.574C12.7582 21.5373 12.7502 21.4979 12.75 21.4581V14.1501C12.75 14.0705 12.7816 13.9942 12.8379 13.938C12.8942 13.8817 12.9705 13.8501 13.05 13.8501H18.351C18.757 13.8501 19.103 14.1421 19.171 14.5421C19.394 15.8381 19.394 17.1621 19.171 18.4581L18.948 19.7671C18.8741 20.196 18.6629 20.5894 18.3463 20.888C18.0296 21.1867 17.6246 21.3744 17.192 21.4231L16.127 21.5421C15.1068 21.6563 14.0822 21.7281 13.056 21.7571Z" fill="#F396A2"/>
                                        </svg>
                                    </div>
                                    <p>{{__('Подарунок за першій візіт')}}</p>
                                </div>
                                @endif
                                <div class="_flex-display _justify-content-between _align-top doctor_right_title _maxwidth768">
                                    <div class="doctor_right_name">
                                        <h5>{{ $doc->second_name }} {{ $doc->user->name }}</h5>
                                        <p>@foreach($doc->types as $key=>$type)
                                                {{$type}}
                                                @if($key <  count($doc->types)-1)
                                                    {{', '}}
                                                @endif
                                            @endforeach</p>
                                    </div>
                                    <div class="_flex-display _align-center top_docs-city">
                                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        @if($doc->plate)
                                            <p><b>{{ $doc->city }}</b></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="city_map _minwidth769">
                                    @if ($doc->reviews_count > 0)
                                        <div class="_flex-display _justify-content-center _align-center top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                            </svg>
                                            <p><b>@if ($doc->rating)
                                                        {{ $doc->rating }}
                                                    @else
                                                        4.8
                                                    @endif</b> ({{ $doc->reviews_count }})</p>
                                        </div>
                                        <a class="doctor_left_link" href="{{ route('doctor.profile', ['id' => $doc->user_id, 'tab' => 6]) }}">{{__('Відгуки')}}</a>
                                    @endif
                                    @auth
                                        <div class="_flex-display _align-center doctor_left_address">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.875 8.37538C10.875 7.33943 10.0356 6.5 9.00038 6.5C7.96443 6.5 7.125 7.33943 7.125 8.37538C7.125 9.41057 7.96443 10.25 9.00038 10.25C10.0356 10.25 10.875 9.41057 10.875 8.37538Z" stroke="#F396A2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99963 16.25C8.10078 16.25 3.375 12.4238 3.375 8.42247C3.375 5.28998 5.89283 2.75 8.99963 2.75C12.1064 2.75 14.625 5.28998 14.625 8.42247C14.625 12.4238 9.89849 16.25 8.99963 16.25Z" stroke="#F396A2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <span>@if ($doc->city)
                                                    {{ $doc->city}}
                                                    {{', '}}
                                                @endif
                                                @if ($doc->address)
                                                    {{ $doc->address}}
                                                @endif</span>
                                        </div>
                                        <a class="doctor_left_link" href="{{route('map')}}?doctor_id={{ $doc->id}}">{{__('Дивитись на карті')}}</a>
                                    @endauth
                                </div>
                                <div class="_flex-display _justify-content-between _align-center city_map _maxwidth768">
                                    @auth
                                        <div class="mob_address">
                                            <div class="_flex-display _align-center doctor_left_address">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.875 8.37538C10.875 7.33943 10.0356 6.5 9.00038 6.5C7.96443 6.5 7.125 7.33943 7.125 8.37538C7.125 9.41057 7.96443 10.25 9.00038 10.25C10.0356 10.25 10.875 9.41057 10.875 8.37538Z" stroke="#F396A2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99963 16.25C8.10078 16.25 3.375 12.4238 3.375 8.42247C3.375 5.28998 5.89283 2.75 8.99963 2.75C12.1064 2.75 14.625 5.28998 14.625 8.42247C14.625 12.4238 9.89849 16.25 8.99963 16.25Z" stroke="#F396A2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <span>@if ($doc->city)
                                                        {{ $doc->city}}
                                                        {{', '}}
                                                    @endif
                                                    @if ($doc->address)
                                                        {{ $doc->address}}
                                                    @endif</span>
                                            </div>
                                            <a class="doctor_left_link" href="{{route('map')}}?doctor_id={{ $doc->id}}">{{__('Дивитись на карті')}}</a>
                                        </div>
                                    @endauth
                                    @if ($doc->reviews_count > 0)
                                        <div class="mob_rating">
                                            <div class="_flex-display _justify-content-center _align-center top_docs-rating"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"/>
                                                </svg>
                                                <p><b>@if ($doc->rating)
                                                            {{ $doc->rating }}
                                                        @else
                                                            4.8
                                                        @endif</b> ({{ $doc->reviews_count }})</p>
                                            </div>
                                            <a class="doctor_left_link" href="{{ route('doctor.profile', ['id' => $doc->user_id, 'tab' => 6]) }}">{{__('Відгуки')}}</a>
                                        </div>
                                    @endif
                                </div>
                                @if($doc->gift)
                                    <div class="first_gift _minwidth769">
                                        <div class="_flex-display _justify-content-center _align-center first_gift_icon"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.25 6.00001C6.24993 5.33164 6.45593 4.6795 6.83993 4.13245C7.22393 3.58539 7.76725 3.17004 8.39587 2.94297C9.02449 2.7159 9.70783 2.68817 10.3528 2.86354C10.9977 3.03892 11.5729 3.40888 12 3.92301C12.5438 3.2615 13.3267 2.84134 14.1785 2.75384C15.0303 2.66634 15.8823 2.91856 16.5492 3.4557C17.2161 3.99284 17.6441 4.77148 17.7401 5.6224C17.8361 6.47333 17.5924 7.32776 17.062 8.00001H18C18.3283 8.00001 18.6534 8.06467 18.9567 8.19031C19.26 8.31595 19.5356 8.5001 19.7678 8.73224C19.9999 8.96439 20.1841 9.23999 20.3097 9.5433C20.4353 9.84661 20.5 10.1717 20.5 10.5V11.75C20.5 11.9489 20.421 12.1397 20.2803 12.2803C20.1397 12.421 19.9489 12.5 19.75 12.5H13.05C13.0106 12.5 12.9716 12.4923 12.9352 12.4772C12.8988 12.4621 12.8657 12.44 12.8379 12.4121C12.81 12.3843 12.7879 12.3512 12.7728 12.3148C12.7578 12.2784 12.75 12.2394 12.75 12.2V8.74001C12.4677 8.55843 12.2148 8.33486 12 8.07701C11.7851 8.33451 11.5322 8.55774 11.25 8.73901V12.2C11.25 12.2796 11.2184 12.3559 11.1621 12.4121C11.1059 12.4684 11.0296 12.5 10.95 12.5H4.25C4.05109 12.5 3.86032 12.421 3.71967 12.2803C3.57902 12.1397 3.5 11.9489 3.5 11.75V10.5C3.5 10.1717 3.56466 9.84661 3.6903 9.5433C3.81594 9.23999 4.00009 8.96439 4.23223 8.73224C4.46438 8.5001 4.73998 8.31595 5.04329 8.19031C5.34661 8.06467 5.6717 8.00001 6 8.00001H6.938C6.4914 7.42907 6.24916 6.72487 6.25 6.00001ZM11.25 6.00001C11.25 5.53588 11.0656 5.09076 10.7374 4.76257C10.4092 4.43438 9.96413 4.25001 9.5 4.25001C9.03587 4.25001 8.59075 4.43438 8.26256 4.76257C7.93437 5.09076 7.75 5.53588 7.75 6.00001C7.75 6.46414 7.93437 6.90926 8.26256 7.23745C8.59075 7.56563 9.03587 7.75001 9.5 7.75001C9.96413 7.75001 10.4092 7.56563 10.7374 7.23745C11.0656 6.90926 11.25 6.46414 11.25 6.00001ZM12.75 6.00001C12.75 6.22982 12.7953 6.45739 12.8832 6.66971C12.9712 6.88202 13.1001 7.07494 13.2626 7.23745C13.4251 7.39995 13.618 7.52885 13.8303 7.6168C14.0426 7.70474 14.2702 7.75001 14.5 7.75001C14.7298 7.75001 14.9574 7.70474 15.1697 7.6168C15.382 7.52885 15.5749 7.39995 15.7374 7.23745C15.8999 7.07494 16.0288 6.88202 16.1168 6.66971C16.2047 6.45739 16.25 6.22982 16.25 6.00001C16.25 5.53588 16.0656 5.09076 15.7374 4.76257C15.4092 4.43438 14.9641 4.25001 14.5 4.25001C14.0359 4.25001 13.5908 4.43438 13.2626 4.76257C12.9344 5.09076 12.75 5.53588 12.75 6.00001Z" fill="#F396A2"/>
                                                <path d="M11.25 14.1501C11.25 14.0705 11.2184 13.9942 11.1622 13.938C11.1059 13.8817 11.0296 13.8501 10.95 13.8501H5.64904C5.45257 13.8497 5.26234 13.9191 5.11219 14.0458C4.96204 14.1725 4.86171 14.3484 4.82904 14.5421C4.60712 15.838 4.60712 17.1622 4.82904 18.4581L5.05304 19.7671C5.12692 20.1959 5.33794 20.5891 5.6544 20.8877C5.97087 21.1864 6.37569 21.3742 6.80804 21.4231L7.87304 21.5421C8.89504 21.6561 9.91871 21.7278 10.944 21.7571C10.9839 21.7579 11.0234 21.7508 11.0605 21.7361C11.0975 21.7214 11.1312 21.6996 11.1597 21.6717C11.1882 21.6439 11.2108 21.6107 11.2264 21.574C11.2419 21.5373 11.2499 21.4979 11.25 21.4581V14.1501ZM13.056 21.7571C13.0162 21.7579 12.9767 21.7508 12.9396 21.7361C12.9026 21.7214 12.8689 21.6996 12.8404 21.6717C12.8119 21.6439 12.7892 21.6107 12.7737 21.574C12.7582 21.5373 12.7502 21.4979 12.75 21.4581V14.1501C12.75 14.0705 12.7816 13.9942 12.8379 13.938C12.8942 13.8817 12.9705 13.8501 13.05 13.8501H18.351C18.757 13.8501 19.103 14.1421 19.171 14.5421C19.394 15.8381 19.394 17.1621 19.171 18.4581L18.948 19.7671C18.8741 20.196 18.6629 20.5894 18.3463 20.888C18.0296 21.1867 17.6246 21.3744 17.192 21.4231L16.127 21.5421C15.1068 21.6563 14.0822 21.7281 13.056 21.7571Z" fill="#F396A2"/>
                                            </svg>
                                        </div>
                                            <p>{{__('Подарунок за першій візіт')}}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="doctor_right">
                            <div class="_flex-display _justify-content-between _align-center doctor_right_top _minwidth769">
                                @if($doc->plate)
                                    <div class="doc-plate rose-plate">{{ $doc->plate }}</div>
                                @endif
                                @if($doc->share)
                                    <a href="{{ $doc->share }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17 22C16.1667 22 15.4583 21.7083 14.875 21.125C14.2917 20.5417 14 19.8333 14 19C14 18.9 14.025 18.6667 14.075 18.3L7.05 14.2C6.78333 14.45 6.475 14.646 6.125 14.788C5.775 14.93 5.4 15.0007 5 15C4.16667 15 3.45833 14.7083 2.875 14.125C2.29167 13.5417 2 12.8333 2 12C2 11.1667 2.29167 10.4583 2.875 9.875C3.45833 9.29167 4.16667 9 5 9C5.4 9 5.775 9.071 6.125 9.213C6.475 9.355 6.78333 9.55067 7.05 9.8L14.075 5.7C14.0417 5.58333 14.021 5.471 14.013 5.363C14.005 5.255 14.0007 5.134 14 5C14 4.16667 14.2917 3.45833 14.875 2.875C15.4583 2.29167 16.1667 2 17 2C17.8333 2 18.5417 2.29167 19.125 2.875C19.7083 3.45833 20 4.16667 20 5C20 5.83333 19.7083 6.54167 19.125 7.125C18.5417 7.70833 17.8333 8 17 8C16.6 8 16.225 7.929 15.875 7.787C15.525 7.645 15.2167 7.44933 14.95 7.2L7.925 11.3C7.95833 11.4167 7.97933 11.5293 7.988 11.638C7.99667 11.7467 8.00067 11.8673 8 12C7.99933 12.1327 7.99533 12.2537 7.988 12.363C7.98067 12.4723 7.95967 12.5847 7.925 12.7L14.95 16.8C15.2167 16.55 15.525 16.3543 15.875 16.213C16.225 16.0717 16.6 16.0007 17 16C17.8333 16 18.5417 16.2917 19.125 16.875C19.7083 17.4583 20 18.1667 20 19C20 19.8333 19.7083 20.5417 19.125 21.125C18.5417 21.7083 17.8333 22 17 22Z" fill="#F396A2"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            <div class="_flex-display _justify-content-between doctor_right_title _minwidth769">
                                <div class="doctor_right_name">
                                    <h5>{{ $doc->second_name }} {{ $doc->user->name }}</h5>
                                    <p>@foreach($doc->types as $key=>$type)
                                            {{$type}}
                                            @if($key <  count($doc->types)-1)
                                                {{', '}}
                                            @endif
                                        @endforeach</p>
                                </div>
                                {{--<div class="_flex-display _align-top top_docs-city">
                                    <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 4.77164 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    @if($doc->plate)
                                        <p><b>{{ $doc->city }}</b></p>
                                    @endif
                                </div>--}}
                            </div>
                            @if($doc->services->count())
                                <div class="_flex-display doctor_right_services">
                                    @foreach($doc->services as $service)
                                        <div class="_flex-display _justify-content-center _align-center doctor_right_service">{{ $service->name }}</div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="_flex-display _justify-content-between doctor_right_prices_actions">
                                @if($doc->services->count())
                                    <div class="doctor_right_prices">
                                        @foreach($doc->services as $service)
                                            <div class="_flex-display _justify-content-between _align-center doctor_right_price">
                                                <span>{{ $service->name }}</span>
                                                <span>
                                                    @if($service->pivot->prefix === 'for')
                                                        {{__('від ')}}
                                                    @endif
                                                {{ $service->pivot->price }}₴</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @if($doc->promotions->count() > 0)
                                <div class="doctor_right_actions">
                                    @foreach($doc->promotions as $promo)
                                        <div class="_flex-display _justify-content-between _align-center doctor_right_action">
                                            <span>{{ $promo->title }}</span>
                                            <span>{{ $promo->new_price }}₴</span>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @if($doc->photos->count())
                                <div class="_flex-display _justify-content-between _align-stretch doctor_right_images">
                                    @foreach($doc->photos->take(3) as $photo)
                                        <div class="photo_item">
                                            <div class="photo_item_img">
                                                <div class="_flex-display comparison-container {{ $photo->orientation === 'vertical' ? '_flex-column' : '_flex-row' }}">
                                                    <img src="{{ asset('uploads/'.$photo->photo_before) }}">
                                                    <img src="{{ asset('uploads/'.$photo->photo_after) }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <a class="_flex-display _justify-content-center _align-center more_images" href="{{ route('doctor.profile', ['id' => $doc->user_id, 'tab' => 4]) }}"><span>{{__('Більше фото')}}</span></a>
                                </div>
                            @endif
                            <div class="_flex-display _justify-content-between _align-center doctors_buttons">
                                @auth
                                    <a href="{{ route('doctor.profile', ['id' => $doc->user_id, 'tab' => 2]) }}" class="btn white_rose_btn all_services_button">{{__('Усі послуги')}}</a>
                                    <a href="{{ route('doctor.profile', ['id' => $doc->user_id, 'tab' => 3]) }}" class="btn rose_btn save_button">{{__('Записатись')}}</a>
                                @endauth

                                @guest
                                    <a wire:click="$dispatch('openLoginModal')" class="btn white_rose_btn all_services_button">{{__('Усі послуги')}}</a>
                                    <a wire:click="$dispatch('openLoginModal')" class="btn rose_btn save_button">{{__('Записатись')}}</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                        @endforeach
                    @endif




                    {{--<ul class="_flex-display _justify-content-center _align-center pagination">
                        <li><a class="_flex-display _justify-content-center _align-center" href="#"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                    <rect id="Icon / Pagination / First" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                    <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(51,51,51)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,12.6665,12)" />
                                    <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(51,51,51)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,8.27344,12)" />
                                </svg></a></li>
                        <li><a class="_flex-display _justify-content-center _align-center" href="#"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                    <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                    <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                                </svg>
                            </a></li>
                        <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">1</a></li>
                        <li><a class="_flex-display _justify-content-center _align-center" href="#">2</a></li>
                        <li><a class="_flex-display _justify-content-center _align-center" href="#">3</a></li>
                        <li class="pagination_dots"><a class="_flex-display _justify-content-center _align-center">...</a></li>
                        <li><a class="_flex-display _justify-content-center _align-center" href="#">10</a></li>
                        <li><a class="_flex-display _justify-content-center _align-center" href="#"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                    <rect id="Icon / Pagination / Next" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                    <path id="Vector" d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                                </svg>
                            </a></li>
                        <li><a class="_flex-display _justify-content-center _align-center" href="#"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                    <rect id="Icon / Pagination / Last" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                    <path id="Vector" d="M4.2735 4L3.3335 4.94L6.38683 8L3.3335 11.06L4.2735 12L8.2735 8L4.2735 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                                    <path id="Vector" d="M8.66656 4L7.72656 4.94L10.7799 8L7.72656 11.06L8.66656 12L12.6666 8L8.66656 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                                </svg>
                            </a></li>
                    </ul>--}}
                </div>
            </div>
        </div>
    </div>
</main>
