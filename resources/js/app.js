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
    const swiper = new Swiper('.swiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        centeredSlides: true,
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            390: {
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
            }
        }

    });

    $(".carousel_btn_prev").on("click", function() {
        swiper.slidePrev();
    });

    $(".carousel_btn_next").on("click", function() {
        swiper.slideNext();
    });

    const swiperAppointments = new Swiper('.swiper_appointments', {
        loop: false,
        slidesPerView: 2,
        spaceBetween: 0,
        centeredSlides: false,
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            390: {
                slidesPerView: 3
            },
            640: {
                slidesPerView: 5
            },
            768: {
                slidesPerView: 7
            },
            1199: {
                slidesPerView: 10
            }
        }

    });

    $(".appointments_prev").on("click", function() {
        swiperAppointments.slidePrev();
    });

    $(".appointments_next").on("click", function() {
        swiperAppointments.slideNext();
    });

    const swiperSpec = new Swiper('.swiper_spec', {
        loop: false,
        slidesPerView: 2,
        spaceBetween: 0,
        centeredSlides: false,
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            390: {
                slidesPerView: 3
            },
            640: {
                slidesPerView: 5
            },
            768: {
                slidesPerView: 7
            },
            1099: {
                slidesPerView: 10
            },
            1199: {
                slidesPerView: 14
            }
        }

    });

    $(".app_spec_prev").on("click", function() {
        swiperSpec.slidePrev();
    });

    $(".app_spec_next").on("click", function() {
        swiperSpec.slideNext();
    });
    /*--------------------End carousels--------------------------------------*/
    $("#more_filter").on("click", function() {
        $("#more_filter_block").toggleClass('_display_none');
    });
    $("#more_filter_close").on("click", function() {
        $("#more_filter_block").addClass('_display_none');
    });
    $("#apply_search").on("click", function() {
        $("#more_filter_block").addClass('_display_none');
    });
    $(".area_metro_title").on("click", function() {
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
    });
    $(".area_metro_block ul li").on("click", function() {
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
    });
    $(".sort_news_title").on("click", function() {
        $(".sort_list").removeClass('_display_none');
    });
    $(".sort_list_li").on("click", function() {
        var sort = $(this).text();
        $(".sort_news_title").text(sort);
        $(".sort_list").addClass('_display_none');
    });
    $(".appointments_free").on("click", function() {
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
    /*$(".login_btn").on("click", function() {
        $("#login_window").removeClass('_display_none');
    });
    $("#login_window #window_close").on("click", function() {
        $("#login_window").addClass('_display_none');
    });
    $(".register_btn").on("click", function() {
        $("#register_window").removeClass('_display_none');
    });
    $("#register_window #window_close").on("click", function() {
        $("#register_window").addClass('_display_none');
    });
    $(".form_text_login").on("click", function() {
        $("#register_window").addClass('_display_none');
        $("#login_window").removeClass('_display_none');
    });
    $(".add_city").on("click", function() {
        $("#add_city").removeClass('_display_none');
    });
    $(".add_address").on("click", function() {
        $("#add_address").removeClass('_display_none');
    });
    $(".add_area").on("click", function() {
        $("#add_area").removeClass('_display_none');
    });*/
    $(".add_service").on("click", function() {
        $("#add_service").removeClass('_display_none');
    });
    $(".add_extra_service").on("click", function() {
        $("#add_service").removeClass('_display_none');
    });
    $(".price_edit_btn").on("click", function() {
        $("#add_service").removeClass('_display_none');
    });
    $(".appointments_day_edit_link").on("click", function() {
        $("#edit_schedule").removeClass('_display_none');
    });
    $(".add_photo_btn").on("click", function() {
        $("#add_photo").removeClass('_display_none');
    });
    $(".add_action_btn, .spec_action_edit_btn").on("click", function() {
        $("#add_action").removeClass('_display_none');
    });
    /*$(".window_close").on("click", function() {
        $(this).closest(".screen").addClass("_display_none");
    });
    $(".reg_doc_btn").on("click", function() {
        $("#register_client").addClass('_display_none');
        $("#register_doctor").removeClass('_display_none');
        $(this).removeClass('white_rose_btn').addClass('rose_btn');
        $(".reg_pac_btn").removeClass('rose_btn').addClass('white_rose_btn');
    });
    $(".reg_pac_btn").on("click", function() {
        $("#register_doctor").addClass('_display_none');
        $("#register_client").removeClass('_display_none');
        $(this).removeClass('white_rose_btn').addClass('rose_btn');
        $(".reg_doc_btn").removeClass('rose_btn').addClass('white_rose_btn');
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
