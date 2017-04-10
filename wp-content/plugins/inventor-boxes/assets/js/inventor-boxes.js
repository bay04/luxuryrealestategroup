jQuery(document).ready(function($) {
    'use strict';

    $('.box-number').each(function(){
        statsCounterAnimation(this);
    });

    function statsCounterAnimation(element) {
        var inView = false;

        if (isScrolledIntoView(element)) {
            if (inView) {
                return;
            }
            inView = true;
            $(element).each(function() {
                $(this).animateNumber({ number: $(this).data('value'), easing: 'easeOutExpo'}, 3000);
            });
        }

        $(window).scroll(function() {
            if (isScrolledIntoView(element)) {
                if (inView) {
                    return;
                }
                inView = true;
                $(element).each(function() {
                    $(this).animateNumber({ number: $(this).data('value'), easing: 'easeOutExpo'}, 3000);
                });
            }
        });
    }

    // Check if scrolled to element
    function isScrolledIntoView(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemTop <= docViewBottom) && (elemBottom >= docViewTop));
    }
});