<footer>
    <div class="container">
        <div class="_flex-display _justify-content-between _align-stretch footer">
            <div class="_flex-display _justify-content-between footer_left">
                <div class="footer_logo"><a href="{{route('home')}}"><img src="{{asset('images/footer_logo.png')}}" alt="Logo"/></a></div>
                <div class="_flex-display _align-center footer_share _minwidth769">
                    <a href="#" target="_blank">
                        <svg width="29" height="30" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.55016 0.833496H20.4502C24.9835 0.833496 28.6668 4.51683 28.6668 9.05016V20.9502C28.6668 23.1294 27.8011 25.2193 26.2602 26.7602C24.7193 28.3011 22.6294 29.1668 20.4502 29.1668H8.55016C4.01683 29.1668 0.333496 25.4835 0.333496 20.9502V9.05016C0.333496 6.87097 1.19918 4.78103 2.7401 3.2401C4.28103 1.69918 6.37097 0.833496 8.55016 0.833496ZM8.26683 3.66683C6.91423 3.66683 5.61702 4.20415 4.66059 5.16059C3.70415 6.11702 3.16683 7.41423 3.16683 8.76683V21.2335C3.16683 24.0527 5.44766 26.3335 8.26683 26.3335H20.7335C22.0861 26.3335 23.3833 25.7962 24.3397 24.8397C25.2962 23.8833 25.8335 22.5861 25.8335 21.2335V8.76683C25.8335 5.94766 23.5527 3.66683 20.7335 3.66683H8.26683ZM21.9377 5.79183C22.4073 5.79183 22.8577 5.9784 23.1898 6.31049C23.5219 6.64259 23.7085 7.09301 23.7085 7.56266C23.7085 8.03232 23.5219 8.48274 23.1898 8.81483C22.8577 9.14693 22.4073 9.3335 21.9377 9.3335C21.468 9.3335 21.0176 9.14693 20.6855 8.81483C20.3534 8.48274 20.1668 8.03232 20.1668 7.56266C20.1668 7.09301 20.3534 6.64259 20.6855 6.31049C21.0176 5.9784 21.468 5.79183 21.9377 5.79183ZM14.5002 7.91683C16.3788 7.91683 18.1805 8.66311 19.5088 9.99149C20.8372 11.3199 21.5835 13.1215 21.5835 15.0002C21.5835 16.8788 20.8372 18.6805 19.5088 20.0088C18.1805 21.3372 16.3788 22.0835 14.5002 22.0835C12.6215 22.0835 10.8199 21.3372 9.49149 20.0088C8.16311 18.6805 7.41683 16.8788 7.41683 15.0002C7.41683 13.1215 8.16311 11.3199 9.49149 9.99149C10.8199 8.66311 12.6215 7.91683 14.5002 7.91683ZM14.5002 10.7502C13.373 10.7502 12.292 11.1979 11.495 11.995C10.6979 12.792 10.2502 13.873 10.2502 15.0002C10.2502 16.1273 10.6979 17.2083 11.495 18.0054C12.292 18.8024 13.373 19.2502 14.5002 19.2502C15.6273 19.2502 16.7083 18.8024 17.5054 18.0054C18.3024 17.2083 18.7502 16.1273 18.7502 15.0002C18.7502 13.873 18.3024 12.792 17.5054 11.995C16.7083 11.1979 15.6273 10.7502 14.5002 10.7502Z"
                                fill="black"/>
                        </svg>
                    </a>
                    <a href="https://t.me/+380998402441" target="_blank">
                        <svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.7083 23.3335L28.25 2.0835L11.25 14.1252" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M28.2502 2.0835L1.3335 12.7085" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24.7083 23.3333L11.25 14.125" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1.3335 12.7085L11.2502 14.1252" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.5 17.6667L11.25 21.9167V14.125" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
            <livewire:footer-service />
            <div class="footer_menu">
                <ul>
                    <li><a href="{{route('map')}}">{{__('Мапа косметологів')}}</a></li>
                    <li><a href="{{route('about')}}">{{__('Про сервіс')}}</a></li>
                    <li><a href="{{route('photobank')}}">{{__('Фотобанк')}}</a></li>
                    <li><a href="{{route('news')}}">{{__('Новини')}}</a></li>
                </ul>
            </div>
            <div class="_flex-display _justify-content-between footer_right">
                <div class="_flex-display _align-center footer_share _maxwidth768">
                    <a href="#" target="_blank">
                        <svg width="29" height="30" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.55016 0.833496H20.4502C24.9835 0.833496 28.6668 4.51683 28.6668 9.05016V20.9502C28.6668 23.1294 27.8011 25.2193 26.2602 26.7602C24.7193 28.3011 22.6294 29.1668 20.4502 29.1668H8.55016C4.01683 29.1668 0.333496 25.4835 0.333496 20.9502V9.05016C0.333496 6.87097 1.19918 4.78103 2.7401 3.2401C4.28103 1.69918 6.37097 0.833496 8.55016 0.833496ZM8.26683 3.66683C6.91423 3.66683 5.61702 4.20415 4.66059 5.16059C3.70415 6.11702 3.16683 7.41423 3.16683 8.76683V21.2335C3.16683 24.0527 5.44766 26.3335 8.26683 26.3335H20.7335C22.0861 26.3335 23.3833 25.7962 24.3397 24.8397C25.2962 23.8833 25.8335 22.5861 25.8335 21.2335V8.76683C25.8335 5.94766 23.5527 3.66683 20.7335 3.66683H8.26683ZM21.9377 5.79183C22.4073 5.79183 22.8577 5.9784 23.1898 6.31049C23.5219 6.64259 23.7085 7.09301 23.7085 7.56266C23.7085 8.03232 23.5219 8.48274 23.1898 8.81483C22.8577 9.14693 22.4073 9.3335 21.9377 9.3335C21.468 9.3335 21.0176 9.14693 20.6855 8.81483C20.3534 8.48274 20.1668 8.03232 20.1668 7.56266C20.1668 7.09301 20.3534 6.64259 20.6855 6.31049C21.0176 5.9784 21.468 5.79183 21.9377 5.79183ZM14.5002 7.91683C16.3788 7.91683 18.1805 8.66311 19.5088 9.99149C20.8372 11.3199 21.5835 13.1215 21.5835 15.0002C21.5835 16.8788 20.8372 18.6805 19.5088 20.0088C18.1805 21.3372 16.3788 22.0835 14.5002 22.0835C12.6215 22.0835 10.8199 21.3372 9.49149 20.0088C8.16311 18.6805 7.41683 16.8788 7.41683 15.0002C7.41683 13.1215 8.16311 11.3199 9.49149 9.99149C10.8199 8.66311 12.6215 7.91683 14.5002 7.91683ZM14.5002 10.7502C13.373 10.7502 12.292 11.1979 11.495 11.995C10.6979 12.792 10.2502 13.873 10.2502 15.0002C10.2502 16.1273 10.6979 17.2083 11.495 18.0054C12.292 18.8024 13.373 19.2502 14.5002 19.2502C15.6273 19.2502 16.7083 18.8024 17.5054 18.0054C18.3024 17.2083 18.7502 16.1273 18.7502 15.0002C18.7502 13.873 18.3024 12.792 17.5054 11.995C16.7083 11.1979 15.6273 10.7502 14.5002 10.7502Z"
                                fill="black"/>
                        </svg>
                    </a>
                    <a href="https://t.me/+380998402441" target="_blank">
                        <svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.7083 23.3335L28.25 2.0835L11.25 14.1252" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M28.2502 2.0835L1.3335 12.7085" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24.7083 23.3333L11.25 14.125" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1.3335 12.7085L11.2502 14.1252" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.5 17.6667L11.25 21.9167V14.125" stroke="black" stroke-width="2.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
                <div class="footer_subscribe">
                    <div class="footer_subscribe_block">
                        <p>{{__('Підписатись')}} <br>{{__('на новини')}}</p>
                        @livewire('subscribe-form')
                    </div>
                </div>
                {{--<div class="_flex-display _align-center footer_links">
                    <a href="#">{{__('Privacy policy')}}</a>
                    <a href="#">{{__('Cookie policy')}}</a>
                </div>--}}
            </div>
        </div>
    </div>
</footer>

<div id="btn_top"><img src="{{asset('images/top.png')}}"/></div>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
{{-- Подключаем Cropper.js --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

{{-- Alpine.js компонент для Before/After --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('beforeAfterComponent', () => ({
            cropperBefore: null,
            cropperAfter: null,
            currentAspectRatio: 1/2,

            init() {
                console.log('BeforeAfter компонент инициализирован');

                // Следим за изменением showAddModal
                this.$watch('showAddModal', (value) => {
                    if (value) {
                        setTimeout(() => {
                            this.updateAspectRatio();
                            this.reinitializeCroppersIfNeeded();
                        }, 50);
                    } else {
                        this.destroyCroppers();
                    }
                });

                // Инициализация при первой загрузке
                if (this.$wire.get('showAddModal')) {
                    setTimeout(() => {
                        this.updateAspectRatio();
                    }, 100);
                }
            },

            reinitializeCroppersIfNeeded() {
                // Проверяем, есть ли уже загруженные изображения
                const fileBefore = document.getElementById('fileBefore');
                const fileAfter = document.getElementById('fileAfter');

                if (fileBefore?.files?.length > 0) {
                    this.initCropperFromFile(fileBefore.files[0], 'before');
                }

                if (fileAfter?.files?.length > 0) {
                    this.initCropperFromFile(fileAfter.files[0], 'after');
                }
            },

            initCropperFromFile(file, type) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.setupCropper(type, e.target.result);
                };
                reader.readAsDataURL(file);
            },

            updateAspectRatio() {
                const orientation = this.$wire.get('orientation');
                this.currentAspectRatio = orientation === 'vertical' ? 2/1 : 1/2;

                if (this.cropperBefore) {
                    this.cropperBefore.setAspectRatio(this.currentAspectRatio);
                }
                if (this.cropperAfter) {
                    this.cropperAfter.setAspectRatio(this.currentAspectRatio);
                }
            },

            initCropper(event, type) {
                const file = event.target.files[0];
                if (!file) return;
                this.initCropperFromFile(file, type);
            },

            setupCropper(type, imageUrl) {
                const containerId = `cropContainer${type.charAt(0).toUpperCase() + type.slice(1)}`;
                const imageId = `imageToCrop${type.charAt(0).toUpperCase() + type.slice(1)}`;
                const previewId = `preview${type.charAt(0).toUpperCase() + type.slice(1)}`;

                // Показываем контейнер для кропа, скрываем превью
                const container = document.getElementById(containerId);
                const preview = document.getElementById(previewId);

                if (container && preview) {
                    container.style.display = 'block';
                    preview.style.display = 'none';
                }

                const imageElement = document.getElementById(imageId);
                if (!imageElement) return;

                imageElement.src = imageUrl;

                // Уничтожаем старый кроппер
                if (type === 'before' && this.cropperBefore) {
                    this.cropperBefore.destroy();
                } else if (type === 'after' && this.cropperAfter) {
                    this.cropperAfter.destroy();
                }

                // Создаем новый кроппер после загрузки изображения
                imageElement.onload = () => {
                    this.createCropper(imageElement, type);
                };
            },

            createCropper(imageElement, type) {
                try {
                    const cropper = new Cropper(imageElement, {
                        aspectRatio: this.currentAspectRatio,
                        viewMode: 1,
                        autoCropArea: 0.8,
                        movable: true,
                        zoomable: true,
                        rotatable: true,
                        scalable: true,
                    });

                    if (type === 'before') {
                        this.cropperBefore = cropper;
                    } else {
                        this.cropperAfter = cropper;
                    }
                } catch (error) {
                    console.error(`Ошибка при создании Cropper:`, error);
                }
            },

            resetCrop(type) {
                const cropper = type === 'before' ? this.cropperBefore : this.cropperAfter;
                if (cropper) cropper.reset();
            },

            removeImage(type) {
                if (type === 'before' && this.cropperBefore) {
                    this.cropperBefore.destroy();
                    this.cropperBefore = null;
                } else if (type === 'after' && this.cropperAfter) {
                    this.cropperAfter.destroy();
                    this.cropperAfter = null;
                }

                const containerId = `cropContainer${type.charAt(0).toUpperCase() + type.slice(1)}`;
                const previewId = `preview${type.charAt(0).toUpperCase() + type.slice(1)}`;
                const fileInputId = `file${type.charAt(0).toUpperCase() + type.slice(1)}`;

                const container = document.getElementById(containerId);
                const preview = document.getElementById(previewId);
                const fileInput = document.getElementById(fileInputId);

                if (container) container.style.display = 'none';
                if (preview) preview.style.display = 'flex';
                if (fileInput) fileInput.value = '';
            },

            destroyCroppers() {
                if (this.cropperBefore) {
                    this.cropperBefore.destroy();
                    this.cropperBefore = null;
                }
                if (this.cropperAfter) {
                    this.cropperAfter.destroy();
                    this.cropperAfter = null;
                }
            },

            async saveImages() {
                if (!this.cropperBefore || !this.cropperAfter) {
                    alert('Будь ласка, завантажте та обріжте обидва фото!');
                    return;
                }

                let beforeData, afterData;
                try {
                    const beforeCanvas = this.cropperBefore.getCroppedCanvas({
                        width: 800,
                        height: this.currentAspectRatio === 2/1 ? 400 : 1600
                    });
                    beforeData = beforeCanvas.toDataURL('image/jpeg', 0.8);

                    const afterCanvas = this.cropperAfter.getCroppedCanvas({
                        width: 800,
                        height: this.currentAspectRatio === 2/1 ? 400 : 1600
                    });
                    afterData = afterCanvas.toDataURL('image/jpeg', 0.8);
                } catch (error) {
                    alert('Помилка при обробці зображень');
                    return;
                }

                this.$wire.set('photo_before_data', beforeData);
                this.$wire.set('photo_after_data', afterData);
                this.$wire.addPhoto();
            }
        }));
    });
</script>
@livewireScripts
@stack('scripts')
</body>
</html>
