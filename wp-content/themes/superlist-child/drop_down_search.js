var j$ = jQuery.noConflict();

j$(document).ready(function(){

    j$('.header-wrapper').prepend( '<div id="mobile_header_search"><i class="fa fa-search"></i></div>' );

    j$('#menu-item-279, #mobile_header_search').bind('click', function(){  

        j$('#filter-9').toggleClass('active_search');

        if(j$('#filter-9').hasClass('active_search')){
            window.setTimeout(function(){
                j$('#filter-9 form').addClass('active_search_form');
            }, 300);
        }else{
            j$('#filter-9 form').removeClass('active_search_form');
        }

        if(j$('#menu-main-menu').hasClass('in')){
            j$('.navbar-toggle').click();
        }
        
        if(j$('.header-wrapper').hasClass('affix')){
            j$('#filter-9').addClass('fixed_search');
        }else{
            j$('#filter-9').removeClass('fixed_search');
        }

    });

    j$('.navbar-toggle').bind('click', function(){

        if(j$('#menu-main-menu').hasClass('in')){
        
        }else{
            j$('#filter-9').removeClass('active_search');
            j$('#filter-9').removeClass('fixed_search');
        }
    });

    j$(window).bind('scroll', function(){

        var scrollPosition = j$(this).scrollTop();

        if(scrollPosition > 114){
            if(j$('.header-wrapper').hasClass('affix') && j$('#filter-9').hasClass('active_search')){

            }else{
                j$('#filter-9').removeClass('active_search');
                j$('#filter-9').removeClass('fixed_search');
                j$('#filter-9 form').removeClass('active_search_form');

            }        
        }

    });

});