$.expr[":"].contains = $.expr.createPseudo(function (arg) {
    return function (elem) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

$(document).ready(function () {
    $('.calendar_slider').bxSlider({
        pager: false,
        controls: true,
        adaptiveHeight: true,
        startSlide: typeof start_month !== 'undefined' ? start_month : 0
    });


    $('.orar_slider').bxSlider({
        pager: false,
        controls: true,
        adaptiveHeight: true,
        startSlide: typeof start_month !== 'undefined' ? start_month : 0
    });
    $(window).scroll(function () {
        if ($(window).width>740){
            if ($(this).scrollTop() <= 83) {
                $('.home_menu').hide();
            }
            else {
                $('.home_menu').show();
            }
        }

    });

    $('section').css('min-height', ($(window).height() - 326));
    $('.l_a.m_t_n').css('min-height', ($(window).height() - 413));
    $('.header_menu_content').height($(window).height() - 83).css('min-height', '430px');

    $('.head_list,.overlay3').click(function () {
        $('.menu_content').toggleClass('hidden');
        $('.overlay3').toggleClass('hidden');
    });
    $('.currency .s_c,.overlay2').click(function () {
        $('.overlay2').toggleClass('hidden');
        $('.currency .lang').toggleClass('hidden');

    });
    $('.cont .contact_us_btn').hover(function () {
        $('header .contact .contact_us').toggleClass('active');
        $('.cont .cont_form').toggleClass('hidden');
    });
    $('.cont .cont_form').hover(function () {
        $('.cont .cont_form').removeClass('hidden');
    });
    $('.bxslider2').bxSlider({
        pager: false,
        auto: true,
        controls: true
                //adaptiveHeight: true
    });
    $("ul.faq  li a").click(function () {
        $('ul.faq li.active').removeClass('active');
        if ($(this).parent().find('p').hasClass('active')) {
            $("ul.faq  li p.active").slideToggle();
            $("ul.faq li p.active").removeClass('active');
        }
        else {
            $("ul.faq li p.active").slideToggle();
            $("ul.faq  p.active").removeClass('active');
            $(this).parent().find('p').addClass('active').slideToggle();
            $(this).parent().addClass('active');
        }
    });

    $("ul.dcr > li > a").click(function () {
        $("ul.dcr  li.active").removeClass('active');
        $('span.more').removeClass('hidden');
        if ($(this).parent().find('.dcr_box').hasClass('active')) {
            $("ul.dcr li .dcr_box.active").slideToggle();
            $("ul.dcr li .dcr_box.active").removeClass('active');
            $(this).find('span.more').removeClass('hidden');
        }
        else {
            $("ul.dcr li .dcr_box.active").slideToggle();
            $("ul.dcr li .dcr_box.active").removeClass('active');
            $(this).parent().find('.dcr_box').addClass('active').slideToggle();
            $(this).parent().addClass('active');
            $(this).find('span.more').addClass('hidden');
        }
    });
    $('.upload').click(function () {
        $('#upload').click();
    });

    $("select").selectBoxIt();

    var slider = $('.bxslider').bxSlider({
        pager: false,
        auto: true,
        onSliderLoad: function () {
            setTimeout(
                    function ()
                    {
                        var count = slider.getSlideCount();
                        var current = slider.getCurrentSlide() + 1;
                        $('.counter .total').text(count);
                        $('.counter .current').text(current);
                    }, 100);



        },
        onSlideAfter: function () {
            var count = slider.getSlideCount();
            var current = slider.getCurrentSlide() + 1;
            $('.counter .total').text(count);
            $('.counter .current').text(current);
        }
    });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
    });

    $(".search_start").click(function () {
        var block = $(this).closest(".search_files");
        var query = block.find(".search_input").val();

        block.find(".mda li").hide();
        block.find('.mda li span:contains("' + query + '")').closest("li").show();
    });

    $("#contact_top_form").submit(function (e) {
        e.preventDefault();

        var form = $(this);

        $.post('/contact/topsubmit', $(this).serialize(), function (data) {
            if (data.error == 0) {
                form.fadeOut(400, function () {
                    $(".contact_top_notif").fadeIn(300);
                });
            } else {
                form.find(".form_error").html(data.message);
            }
        });

        return false;
    });

//    $(".embeddedContent").each(function () {
//        var fw = $(this).width();
//        var fr = $(this).
//        alert(fw + ' ' + screen.width);
//        if (fw > screen.width && screen.width) {
//            $(this).width(screen.width);
//        }
//    });
});


var map, map2, map3;

function initialize() {
    var hidden_map = document.getElementById("map-canvas3");
    var big_map = document.getElementById("map-canvas2");
    var small_map = document.getElementById("map-canvas");

    var iconBase = res_url + "assets/img/marker.png";
    var myLatlng = new google.maps.LatLng(loc_lat, loc_long);

    var center = new google.maps.LatLng(loc_lat, loc_long);
    map = new google.maps.Map(small_map, {
        zoom: 14,
        center: myLatlng,
        disableDefaultUI: true
    });
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: iconBase
    });

    google.maps.event.addListener(map, 'click', function () {
        window.open('https://www.google.ro/maps/dir//' + loc_lat + ',' + loc_long + '/@' + loc_lat + ',' + loc_long + ',14z');
    });

    if (big_map !== null) {
        map2 = new google.maps.Map(big_map, {
            zoom: 14,
            disableDefaultUI: true,
            center: myLatlng
        });
        var marker2 = new google.maps.Marker({
            position: myLatlng,
            map: map2,
            icon: iconBase
        });
    }
    if (hidden_map !== null) {
        map3 = new google.maps.Map(hidden_map, {
            zoom: 14,
            disableDefaultUI: true,
            center: myLatlng
        });
        var marker3 = new google.maps.Marker({
            position: myLatlng,
            map: map3,
            icon: iconBase
        });
    }
}
google.maps.event.addDomListener(window, 'load', initialize);
