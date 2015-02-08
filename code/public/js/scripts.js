$(window).resize(function () {
    if ('matchMedia' in window) {
        // Chrome, Firefox, and IE 10 support mediaMatch listeners
        window.matchMedia('print').addListener(function (media) {
            chart.validateNow();
        });
    } else {
        // IE and Firefox fire before/after events
        window.onbeforeprint = function () {
            chart.validateNow();
        }
    }
});

$(window).load(function () {
    $('#status').fadeOut();
    $('#preloader').delay(350).fadeOut(function () {
        $('body').delay(350).css({'overflow': 'visible'});
    });
});

$(document).ready(function () {
    //  class add mouse hover
    jQuery('.custom-nav > li').hover(function () {
        jQuery(this).addClass('nav-hover');
    }, function () {
        jQuery(this).removeClass('nav-hover');
    });

    $('.panel .tools .fa-chevron-down').click(function () {
        var el = $(this).parents(".panel").children(".panel-body");
        if ($(this).hasClass("fa-chevron-down")) {
            $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });

    // panel close
    $('.panel .tools .fa-times').click(function () {
        $(this).parents(".panel").parent().remove();
    });

});
