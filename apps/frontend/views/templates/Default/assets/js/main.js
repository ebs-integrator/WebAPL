$(document).ready(function() {
    $('.currency .s_c,.overlay2').click(function() {
        $('.overlay2').toggleClass('hidden');
        $('.currency .lang').toggleClass('hidden');

    });
    $('.cont .contact_us,.overlay').click(function() {
        $('.overlay').toggleClass('hidden');
        $('.cont .cont_form').toggleClass('hidden');
    });
    $('.bxslider2').bxSlider({
        pager: false,
        auto: true
    });
    $("ul.faq  li").click(function() {
        $('ul.faq li.active').removeClass('active');
        if ($(this).find('p').hasClass('active')) {
            $("ul.faq  li p.active").slideToggle();
            $("ul.faq li p.active").removeClass('active');
        }
        else {
            $("ul.faq li p.active").slideToggle();
            $("ul.faq  p.active").removeClass('active');
            $(this).find('p').addClass('active').slideToggle();
            $(this).addClass('active');
        }
    });

    $("ul.dcr li a").click(function() {
        $("ul.dcr  li.active").removeClass('active');
        if ($(this).parent().find('.dcr_box').hasClass('active')) {
            $("ul.dcr li .dcr_box.active").slideToggle();
            $("ul.dcr li .dcr_box.active").removeClass('active');
        }
        else {
            $("ul.dcr li .dcr_box.active").slideToggle();
            $("ul.dcr li .dcr_box.active").removeClass('active');
            $(this).parent().find('.dcr_box').addClass('active').slideToggle();
            $(this).parent().addClass('active');
        }
    });
    $('.upload').click(function() {
        $('#upload').click();
    });

    $("select").selectBoxIt();

    var slider = $('.bxslider').bxSlider({
        pager: false,
        auto: true,
        onSliderLoad: function() {
            setTimeout(
                    function()
                    {
                        var count = slider.getSlideCount();
                        var current = slider.getCurrentSlide() + 1;
                        $('.counter .total').text(count);
                        $('.counter .current').text(current);
                    }, 100);



        },
        onSlideAfter: function() {
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
});


var map, map2;

function initialize() {
    var big_map = document.getElementById("map-canvas2");
    var small_map = document.getElementById("map-canvas");

    var iconBase = res_url+"assets/img/marker.png";
    var myLatlng = new google.maps.LatLng(47.148306, 28.617051);

    var center = new google.maps.LatLng(47.151994, 28.610020);
    map = new google.maps.Map(small_map, {
        zoom: 14,
        center: center,
        disableDefaultUI: true
    });
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: iconBase
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
}
google.maps.event.addDomListener(window, 'load', initialize);