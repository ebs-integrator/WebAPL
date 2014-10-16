$.expr[":"].contains = $.expr.createPseudo(function (arg) {
    return function (elem) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

$(document).ready(function () {
    $('.calendar_slider').bxSlider({
        pager: false,
        controls: true,
        adaptiveHeight: true
    });
    $(".lang p,.overlay2").click(function () {
        $(".lang ul,.overlay2").toggleClass('hidden');
    });

    $('.orar_slider').bxSlider({
        pager: false,
        controls: true,
        adaptiveHeight: true,
        startSlide: typeof start_month !== 'undefined' ? start_month : 0
    });

    $('section').css('min-height', ($(window).height() - 326));
    $('.l_a.m_t_n').css('min-height', ($(window).height() - 413));
    $('.menu_content').height($(window).height() - 83);

    $('.resp_menu').click(function(){
        $('.resp_menu').toggleClass('active');
        $('.left_block').toggle('slow');
        $('.dirs_menu a:last-child').toggle('100');
    });

    $('.mh_button,.overlay3').click(function () {
        $('.mini_header .content').toggleClass('hidden');
        $('.overlay3').toggleClass('hidden');
    });
    $('.cont .contact_us,.overlay').click(function () {
        $('.overlay').toggleClass('hidden');
        $('.cont .cont_form').toggleClass('hidden');
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
        $('span.more_dot').removeClass('hidden');
        if ($(this).parent().find('.dcr_box').hasClass('active')) {
            $("ul.dcr li .dcr_box.active").slideToggle();
            $("ul.dcr li .dcr_box.active").removeClass('active');
            $(this).find('span.more_dot').removeClass('hidden');
        }
        else {
            $("ul.dcr li .dcr_box.active").slideToggle();
            $("ul.dcr li .dcr_box.active").removeClass('active');
            $(this).parent().find('.dcr_box').addClass('active').slideToggle();
            $(this).parent().addClass('active');
            $(this).find('span.more_dot').addClass('hidden');
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
    $('input[type=radio]').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
        increaseArea: '20%'
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
});



var map, map2, map3;

function initialize() {
    var hidden_map = document.getElementById("map-canvas3");
    var big_map = document.getElementById("map-canvas2");
    var small_map = document.getElementById("map-canvas");

//    var iconBase = "/img/marker.png";
    var myLatlng = new google.maps.LatLng(47.148306, 28.617051);

    var center = new google.maps.LatLng(47.151994, 28.610020);



    if (small_map !== null) {
        map = new google.maps.Map(small_map, {
            zoom: 14,
            center: center,
            disableDefaultUI: true
        });

    }

    if (big_map !== null) {
        map2 = new google.maps.Map(big_map, {
            zoom: 14,
            disableDefaultUI: true,
            center: myLatlng
        });

    }
    if (hidden_map !== null) {
        map3 = new google.maps.Map(hidden_map, {
            zoom: 14,
            disableDefaultUI: true,
            center: myLatlng
        });

    }
}
google.maps.event.addDomListener(window, 'load', initialize);
