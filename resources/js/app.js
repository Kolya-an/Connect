//import './bootstrap';
$(document).ready(function() {
    // открытие/закрытие всего меню
    $(".menu-toggle").click(function() {
        $(".header_mob_block").slideToggle(300);
    });

    $(".mob_menu_close").click(function() {
        $(".header_mob_block").slideUp(300);
    });

    // открытие/закрытие подменю
    $(".submenu > a").click(function(e) {
        e.preventDefault();
        $(".submenu").toggleClass('submenu_active');
        $(this).next("ul").slideToggle(300);
    });
    /*--------------------------Carousels------------------------------------*/
    const swiperHome = new Swiper('.swiper-home', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,

        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20
            }
        }

    });

    $(".carousel_btn_prev").on("click", function() {
        swiperHome.slidePrev();
    });

    $(".carousel_btn_next").on("click", function() {
        swiperHome.slideNext();
    });


/*------------------Каруселі--------------------------*/

    let swiperSpec = null;
    let swiperAppointments = null;

    function initializeSwiperSpec() {
        const swiperElement = document.querySelector('.swiper_spec');
        if (!swiperElement) {
            console.log('Swiper spec element not found, retrying...');
            setTimeout(initializeSwiperSpec, 200);
            return null;
        }

        console.log('Swiper spec element found!', swiperElement);

        if (swiperElement.swiper) {
            swiperElement.swiper.destroy(true, true);
        }

        swiperSpec = new Swiper('.swiper_spec', {
            loop: false,
            slidesPerView: 2,
            spaceBetween: 0,
            centeredSlides: false,
            allowTouchMove: true,
            resistance: true,
            resistanceRatio: 0.85,
            breakpoints: {
                390: { slidesPerView: 3 },
                640: { slidesPerView: 5 },
                768: { slidesPerView: 7 },
                1099: { slidesPerView: 10 },
                1199: { slidesPerView: 14 }
            },
            on: {
                // Предотвращаем возврат к первому слайду
                slideChange: function() {
                    console.log('Swiper spec slide changed to:', this.activeIndex);
                }
            }
        });

        console.log('Swiper spec initialized successfully!');
        return swiperSpec;
    }

    function initializeSwiperAppointments() {
        const swiperElement = document.querySelector('.swiper_appointments');
        if (!swiperElement) {
            console.log('Swiper appointments element not found, retrying...');
            setTimeout(initializeSwiperAppointments, 200);
            return null;
        }

        console.log('Swiper appointments element found!', swiperElement);

        if (swiperElement.swiper) {
            swiperElement.swiper.destroy(true, true);
        }

        swiperAppointments = new Swiper('.swiper_appointments', {
            loop: false,
            slidesPerView: 2,
            spaceBetween: 0,
            centeredSlides: false,
            allowTouchMove: true,
            resistance: true,
            resistanceRatio: 0.85,
            breakpoints: {
                390: { slidesPerView: 3 },
                640: { slidesPerView: 5 },
                768: { slidesPerView: 7 },
                1199: { slidesPerView: 10 }
            },
            on: {
                init: function() {
                    console.log('Swiper appointments initialized');
                },
                slideChange: function() {
                    console.log('Swiper appointments slide changed to:', this.activeIndex);
                }
            }
        });

        console.log('Swiper appointments initialized successfully!');
        return swiperAppointments;
    }

    function initializeAllSwipers() {
        initializeSwiperSpec();
        initializeSwiperAppointments();
    }

// Инициализация с задержкой
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initializeAllSwipers, 500);
    });

// Для Livewire
    document.addEventListener('livewire:init', function() {
        setTimeout(initializeAllSwipers, 500);
    });

    document.addEventListener('livewire:navigated', function() {
        setTimeout(initializeAllSwipers, 500);
    });

// Обработчики кнопок для первой карусели
    $(document).on('click', '.app_spec_prev', function(e) {
        e.preventDefault();
        if (!swiperSpec || swiperSpec.destroyed) {
            console.log('Initializing Swiper spec on button click...');
            initializeSwiperSpec();
        }
        if (swiperSpec && !swiperSpec.destroyed) {
            swiperSpec.slidePrev();
        }
    });

    $(document).on('click', '.app_spec_next', function(e) {
        e.preventDefault();
        if (!swiperSpec || swiperSpec.destroyed) {
            console.log('Initializing Swiper spec on button click...');
            initializeSwiperSpec();
        }
        if (swiperSpec && !swiperSpec.destroyed) {
            swiperSpec.slideNext();
        }
    });

// Обработчики кнопок для второй карусели
    $(document).on('click', '.appointments_prev', function(e) {
        e.preventDefault();
        if (!swiperAppointments || swiperAppointments.destroyed) {
            console.log('Initializing Swiper appointments on button click...');
            initializeSwiperAppointments();
        }
        if (swiperAppointments && !swiperAppointments.destroyed) {
            swiperAppointments.slidePrev();
        }
    });

    $(document).on('click', '.appointments_next', function(e) {
        e.preventDefault();
        if (!swiperAppointments || swiperAppointments.destroyed) {
            console.log('Initializing Swiper appointments on button click...');
            initializeSwiperAppointments();
        }
        if (swiperAppointments && !swiperAppointments.destroyed) {
            swiperAppointments.slideNext();
        }
    });

// ДОБАВЛЕНО: Переинициализация при открытии/закрытии модального окна
    document.addEventListener('livewire:update', function() {
        const modalOpen = document.querySelector('[wire\\:model="showModal"]')?.value === true ||
            document.querySelector('.fixed.inset-0.bg-black') !== null;

        if (modalOpen) {
            console.log('Modal detected, will reinit Swipers after close');
            window.needSwipersReinit = true;
        } else if (window.needSwipersReinit) {
            console.log('Modal closed, reinitializing Swipers...');
            setTimeout(initializeAllSwipers, 200);
            window.needSwipersReinit = false;
        }
    });

// ДОБАВЛЕНО: Переинициализация при любом клике
    $(document).on('click', function(e) {
        if ($(e.target).closest('.appointments_day_edit_link').length) {
            console.log('Edit link clicked, will reinit Swipers');
            setTimeout(initializeAllSwipers, 500);
        }

        if ($(e.target).is('.fixed.inset-0, [wire\\:click="closeModal"], .bg-black.bg-opacity-50')) {
            console.log('Modal close detected, reinitializing Swipers...');
            setTimeout(initializeAllSwipers, 200);
        }
    });

// ДОБАВЛЕНО: Периодическая проверка и переинициализация
    setInterval(function() {
        const swiperSpecElement = document.querySelector('.swiper_spec');
        const swiperAppointmentsElement = document.querySelector('.swiper_appointments');

        if (swiperSpecElement && (!swiperSpec || swiperSpec.destroyed)) {
            console.log('Swiper spec not initialized, reinitializing...');
            initializeSwiperSpec();
        }

        if (swiperAppointmentsElement && (!swiperAppointments || swiperAppointments.destroyed)) {
            console.log('Swiper appointments not initialized, reinitializing...');
            initializeSwiperAppointments();
        }
    }, 1000);

// ДОБАВЛЕНО: Обработчик кастомных событий от Livewire
    document.addEventListener('reinit-swiper', function() {
        console.log('Reinit swiper event received');
        setTimeout(initializeAllSwipers, 200);
    });

// ДОБАВЛЕНО: Отдельные обработчики для каждой карусели
    document.addEventListener('reinit-swiper-spec', function() {
        console.log('Reinit swiper spec event received');
        setTimeout(initializeSwiperSpec, 200);
    });

    document.addEventListener('reinit-swiper-appointments', function() {
        console.log('Reinit swiper appointments event received');
        setTimeout(initializeSwiperAppointments, 200);
    });

// Обработчик кастомного события от Livewire
    document.addEventListener('reinit-swipers', function() {
        console.log('Reinit swipers event received from Livewire');
        setTimeout(initializeAllSwipers, 100);
    });


    /*-----------------END-Каруселі--------------------------*/

    $("#more_filter").on("click", function() {
        $("#more_filter_block").toggleClass('_display_none');
    });
    $("#more_filter_close").on("click", function() {
        $("#more_filter_block").addClass('_display_none');
    });
    $("#apply_search").on("click", function() {
        $("#more_filter_block").addClass('_display_none');
    });
    /*$(".area_metro_title").on("click", function() {
        $(".area_metro_block").toggleClass('_display_none');
    });
    $("#area_tab").on("click", function() {
        $("#area_block").removeClass('_display_none');
        $("#metro_block").addClass('_display_none');
        $(this).removeClass('white_rose_btn');
        $(this).addClass('rose_btn');
    });
    $("#metro_tab").on("click", function() {
        $("#metro_block").removeClass('_display_none');
        $("#area_block").addClass('_display_none');
        $(this).removeClass('white_rose_btn');
        $(this).addClass('rose_btn');
    });*/
    /*$(".area_metro_block ul li").on("click", function() {
        var area = $(this).text();
        $("#area_metro_input").val(area);
        $(".area_metro_title").text(area);
        $(".area_metro_block").addClass('_display_none');
    });
    $("#clear_search").on("click", function() {
        $(".area_metro_title").text('Район/Метро');
        $("#search_experience").val("").trigger("change");
        $("#search_sex").val("").trigger("change");
        $("#search_for").val("1000");
        $("#search_to").val("5000");
        $("#check_discount").prop("checked", false);
        $("#check_gift").prop("checked", false);
        $("#check_home").prop("checked", false);
    });*/
    /*$(".sort_news_title").on("click", function() {
        $(".sort_list").removeClass('_display_none');
    });
    $(".sort_list_li").on("click", function() {
        var sort = $(this).text();
        $(".sort_news_title").text(sort);
        $(".sort_list").addClass('_display_none');
    });*/
    /*$(".appointments_free").on("click", function() {
        $("#login_appointment").removeClass('_display_none');
    });
    $("#login_appointment a.btn").on("click", function() {
        $("#login_appointment").addClass('_display_none');
        $("#window_appointment").removeClass('_display_none');
    });
    $("#login_appointment #window_close").on("click", function() {
        $("#login_appointment").addClass('_display_none');
    });
    $("#window_appointment #window_close").on("click", function() {
        $("#window_appointment").addClass('_display_none');
    });
    $(".add_service").on("click", function() {
        $("#add_service").removeClass('_display_none');
    });
    $(".add_extra_service").on("click", function() {
        $("#add_service").removeClass('_display_none');
    });
    $(".price_edit_btn").on("click", function() {
        $("#add_service").removeClass('_display_none');
    });
   /!* $(".appointments_day_edit_link").on("click", function() {
        $("#edit_schedule").removeClass('_display_none');
    });*!/
    $(".add_photo_btn").on("click", function() {
        $("#add_photo").removeClass('_display_none');
    });
    $(".add_action_btn, .spec_action_edit_btn").on("click", function() {
        $("#add_action").removeClass('_display_none');
    });*/
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) { // если прокрутили больше 300px
            $('#btn_top').fadeIn(); // плавно показать
        } else {
            $('#btn_top').fadeOut(); // плавно скрыть
        }
    });
    $("#btn_top").on("click", function() {
        $('html, body').animate({ scrollTop: 0 }, 'slow', 'swing');
    });

});
