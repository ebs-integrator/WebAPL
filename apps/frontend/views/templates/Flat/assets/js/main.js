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
    $('footer .right .content').click(function () {
        $(this).hide();
    });
    $('.orar_slider').bxSlider({
        pager: false,
        controls: true,
        adaptiveHeight: true,
        startSlide: typeof start_month !== 'undefined' ? start_month : 0
    });

    $('section').css('min-height', ($(window).height() - 326));
    $('.l_a.m_t_n').css('min-height', ($(window).height() - 413));
    $('.mini_header .content').height($(window).height() - 85);

    $('.resp_menu').click(function () {
        $('.resp_menu').toggleClass('active');
        $('.left_block,.dirs_menu a:last-child span').slideToggle('slow');
    });

    $('.mh_button,.overlay3').click(function () {
        $('.mini_header .content').toggleClass('hidden');
        $('.overlay3').toggleClass('hidden');
    });


    $('.bxslider2').bxSlider({
        pager: false,
        auto: true,
        controls: true
                //adaptiveHeight: true
    });
    $('.menu.art > li > a').click(function () {
        $('.menu.art li .months').slideUp();
        if ($(this).next().is(':visible')) {
            $(this).next().slideUp();
        }
        else {
            $(this).next().slideToggle();
        }
    });
    $("ul.faq > li > a").click(function () {
        $('ul.faq > li.active').removeClass('active');
        if ($(this).parent().find('p, ul, ol').hasClass('active')) {
            $("ul.faq li p.active, ul.faq li ul.active, ul.faq li ol.active").slideToggle();
            $("ul.faq li p.active, ul.faq li ul.active, ul.faq li ol.active").removeClass('active');
        } else {
            $("ul.faq li p.active, ul.faq li ul.active, ul.faq li ol.active").slideToggle();
            $("ul.faq p.active, ul.faq ul.active, ul.faq ol.active").removeClass('active');
            $(this).parent().find('p, ul, ol').addClass('active').slideToggle();
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

        block.find(".docs li").hide();
        block.find('.docs li a:contains("' + query + '")').closest("li").show();
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



    if (window.location.hash == '#hm') {
        $('html, body').animate({
            scrollTop: $("#hm_scroll").offset().top - 100
        }, 1000);
    }

    $(".live_comment > p").each(function () {
        var pID = $(this).closest('.live_comment').data('pid');
        var pNUM = $(".live_comment > p").index(this);
        var hID = pID + "a" + pNUM;

        $(this).attr('data-hID', hID);

        $(this).prepend('<a class="live_comment_num" data-disqus-identifier="' + hID + '" href="javascript:;#disqus_thread">0</a>');
    }).promise().done(function () {

        function checkload() {
            if (typeof DISQUSWIDGETS === 'undefined') {
                setTimeout(checkload, 1000);
            } else {
                $(".live_comment_num").each(function () {
                    $(this).text(parseInt($(this).text()));
                });
            }
        }

        checkload();

        var s = document.createElement('script');
        s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        jQuery('head').append(s);
    });

    $(".live_comment > p").click(function () {
        $(".live_comment > p").removeClass("activecomm");
        $(this).addClass("activecomm");

        var hID = $(this).attr('data-hID');
        loadDisqus(jQuery(this), hID, base_url + '/#!' + hID);
    });

    function loadDisqus(source, identifier, url) {
        if (window.DISQUS) {
            jQuery('#disqus_thread').insertAfter(source);
            DISQUS.reset({
                reload: true,
                config: function () {
                    this.page.identifier = identifier.toString();
                    this.page.url = url;
                }
            });
        } else {
            jQuery('<div id="disqus_thread"></div>').insertAfter(source);
            disqus_identifier = identifier;
            disqus_url = url;
            var dsq = document.createElement('script');
            dsq.type = 'text/javascript';
            dsq.async = true;
            dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
            jQuery('head').append(dsq);
        }
    }


    var alertbox = $("#alertbox");
    if (alertbox.length > 0) {
        var alertId = alertbox.data('alertid');
        var alertShow = $.cookie('alert_' + alertId);
        if (parseInt(alertShow) !== 1) {
            setTimeout(function () {
                alertbox.fadeIn(150);
            }, 3000);
        }
        alertbox.find(".alertclose").click(function () {
            alertbox.fadeOut(150);
            if ($("#f_1").is(':checked')) {
                $.cookie('alert_' + alertId, 1, {path: '/'});
            }
        });
    }

    $.ctrl = function (key, callback, args) {
        $(document).keydown(function (e) {
            if (!args)
                args = []; // IE barks when args is null 
            if (e.keyCode == key.charCodeAt(0) && e.ctrlKey) {
                callback.apply(this, args);
                return false;
            }
        });
    };

    $.ctrl('K', function (s) {
        window.open('/admin');
    });

});



var map, map2, map3;

function initialize() {
    var hidden_map = document.getElementById("map-canvas3");
    var big_map = document.getElementById("map-canvas2");
    var small_map = document.getElementById("map-canvas");

    var myLatlng = new google.maps.LatLng(loc_lat, loc_long);
    var isDraggable = $(document).width() > 480 ? true : false;
    var center = new google.maps.LatLng(loc_lat, loc_long);



    if (small_map !== null) {
        map = new google.maps.Map(small_map, {
            zoom: 14,
            center: center,
            disableDefaultUI: true,
            draggable: isDraggable,
            scrollwheel: isDraggable
        });
        var marker = new google.maps.Marker({
            map: map,
            position: center
        });

    }

    if (big_map !== null) {
        map2 = new google.maps.Map(big_map, {
            zoom: 14,
            disableDefaultUI: true,
            center: myLatlng,
            draggable: isDraggable,
            scrollwheel: isDraggable
        });
        var marker = new google.maps.Marker({
            map: map2,
            position: center
        });

    }
    if (hidden_map !== null) {
        map3 = new google.maps.Map(hidden_map, {
            zoom: 14,
            disableDefaultUI: true,
            center: myLatlng,
            draggable: isDraggable,
            scrollwheel: isDraggable
        });
        var marker = new google.maps.Marker({
            map: map3,
            position: center
        });

    }
}
google.maps.event.addDomListener(window, 'load', initialize);
