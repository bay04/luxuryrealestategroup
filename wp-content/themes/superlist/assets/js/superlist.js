jQuery(document).ready(function($) {
    'use strict';

    // iOS fix
    if(/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream){
        document.querySelector('meta[name=viewport]').setAttribute(
            'content',
            'initial-scale=1.0001, minimum-scale=1.0001, maximum-scale=1.0001, user-scalable=no'
        );
    }

    /**
     * Action Bar
     */
    // Switch the body classes
    $('.action-bar-chapter a').on('click', function(e) {
       e.preventDefault();

       $(this).closest('ul').find('a').removeClass('active');
       $(this).closest('ul').find('a').each(function() {
           $('body').removeClass($(this).attr('data-action'));
       });
       $('body').addClass($(this).attr('data-action'));
       $(this).addClass('active');
    });

    // Change color combination
    $('.action-bar-chapter table a').on('click', function(e) {
        e.preventDefault();
        $(this).closest('table').find('a').removeClass('active');
        $(this).addClass('active');

        var uri = $(this).attr('href');
        $('#superlist-css').attr('href', uri);
    });

    // Hide/Show
    $('.action-bar-title').on('click', function(e) {
        $('.action-bar-content').toggleClass('open');
    });

    /**
     * Tabs
     */
    $('.listing-categories-tabs a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    /**
     * Share listing
     */
    $('.share-listing').on('click', function(e) {
        e.preventDefault();
        var modalInner = $(this).next('.modal-inner').clone();
        $('.modal-screen').addClass('open');
        $('.modal-main').html(modalInner);
    });

    /**
     * Modal
     */
    $('.modal-close').on('click', function() {
        $(this).closest('.modal-screen').removeClass('open');
        $('.modal-main').empty();
    });

    $('body').on('keyup', function(e) {
        if ($('.modal-screen').hasClass('open')) {
            if (e.keyCode == 27) {
                $('.modal-screen').removeClass('open');
                $('.modal-main').empty();
            }
        }
    });

    /**
     * Detail menu
     */
    var listingDetailMenu = $('.listing-detail-menu');

    if (listingDetailMenu.length) {
        $('.listing-detail-section').each(function() {
            var title = $('h2', $(this)).first().html();

            if (title === undefined) {
                title = $('h3', $(this)).first().html();
            }

            var id = $(this).attr('id');
            $('ul', listingDetailMenu).append('<li class="' + id  + '"><a href="#' + id + '">' + title + '</a></li>');
        });

        /**
         * Listing menu scroll
         */
        $('.listing-detail-menu a').click(function(e){
            e.preventDefault();

            var id = $(this).attr('href');

            $.scrollTo(id, 1200, {
                axis: 'y',
                offset: -160
            });
        });

        /**
         * Listing menu affix
         */
        if ($('.listing-detail-menu').length !== 0) {
            var height = $('.listing-detail-menu').offset().top;

            if ($('#wpadminbar').height() != null) {
                height -= $('#wpadminbar').height();
            }

            if ($('.header-sticky .header-wrapper').height() != null) {
                height -= 60;
            }

            $('.listing-detail-menu').affix({
                offset: {
                    top: height
                }
            });
        }

        /**
         * Scroll spy
         */
        $('body').scrollspy({
            target: '.listing-detail-menu',
            offset: 160
        });
    }


    /**
     * Detail Price
     */
    var listingDetailPrice = $('.detail-banner-right');

    if (listingDetailPrice.length) {
        var height = $('.detail-banner-right').offset().top;

        if ($('#wpadminbar').height() != null) {
            height -= $('#wpadminbar').height();
        }

        if ($('.header-sticky .header-wrapper').height() != null) {
            height -= 60;
        }

        var wWidth = $(window).width();
        if(wWidth > 767) {
            $('.detail-banner-right').affix({
                offset: {
                    top: height
                }
            });
        }
    }

    // Sticky header
    $('.header-sticky .header-wrapper').affix({
        offset: {
            top: 200
        }
    });

    /**
     * Header Action
     */
    $('.header-action').on('click', function(e) {
        e.preventDefault();
        $('.header-post-types').toggleClass('open');
        $('.header-action').toggleClass('open');
    });

    /**
     * Bootstrap Select
     */
    $('select').each(function() {
        $(this).selectpicker({
            noneSelectedText: $(this).data('empty-label'),
            template: {
                caret: '<i class="fa fa-chevron-down"></i>'
            }
        });
    });

    $('select').on('change', function () {
        $(this).selectpicker('refresh');
    });

    //$('select:not(.cmb2_select)').selectpicker({
    //    noneSelectedText: $(this).data('empty-label'), // does not work
    //    template: {
    //        caret: '<i class="fa fa-chevron-down"></i>'
    //    }
    //});

    /**
     * Background image
     */
    $('*[data-background-image]').each(function() {
        $(this).css({
            'background-image': 'url(' + $(this).data('background-image') + ')'
        });
    });

    /**
     * Bootstrap Tooltip
     */
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });

    /**
     * Simple map
     */
    var simple_map = $( '#simple-map' );
    if (simple_map.length) {
        var style = simple_map.data( 'styles' );

        simple_map.google_map({
            center: {
                latitude: simple_map.data( 'latitude' ),
                longitude: simple_map.data( 'longitude' )
            },
            zoom: simple_map.data( 'zoom' ),
            zoomControl: true,
            styles: style,
            transparentMarkerImage: simple_map.data( 'transparent-marker-image' ),
            marker: {
                height: 38,
                width: 24
            },
            markers: [{
                latitude: simple_map.data( 'latitude' ),
                longitude: simple_map.data( 'longitude' ),
                marker_content: '<div class="simple-marker"></div>'
            }]
        });
    }

    /**
     * Listing banner map
     */
    var banner_map = $( '#banner-map' );
    if (banner_map.length) {
        var mapType;
        var markerContent;
        var marker = false;
        var markers = [];

        switch(banner_map.data( 'map-type' )) {
            case 'ROADMAP':
                mapType = google.maps.MapTypeId.ROADMAP;
                markerContent = '<div class="simple-marker"></div>';
                break;
            case 'HYBRID':
                mapType = google.maps.MapTypeId.HYBRID;
                markerContent = '<div class="simple-marker-primary"></div>';
                break;
            default:
                mapType = google.maps.MapTypeId.SATELLITE;
                markerContent = '<div class="simple-marker-primary"></div>';
        }

        if (banner_map.data( 'marker' )) {
            marker = {
                height: 38,
                width: 24
            };

            markers = [{
                latitude: banner_map.data( 'latitude' ),
                longitude: banner_map.data( 'longitude' ),
                marker_content: markerContent
            }]
        }

        banner_map.google_map({
            center: {
                latitude: banner_map.data( 'latitude' ),
                longitude: banner_map.data( 'longitude' )
            },
            zoom: banner_map.data( 'zoom' ),
            zoomControl: true,
            rotateControl: false,
            mapTypeId: mapType,
            tilt: 45,
            transparentMarkerImage: banner_map.data( 'transparent-marker-image' ),
            marker: marker,
            markers: markers
        });
    }

    /**
     * Listing Banner Detail Street View
     */
    streetViewInit('banner-street-view');
    streetViewInit('banner-inside-view');

    function streetViewInit(banner_street_view_id) {
        var banner_street_view = $('#' + banner_street_view_id);

        if (banner_street_view.length) {
            new google.maps.StreetViewPanorama(document.getElementById(banner_street_view_id), {
                    position: {
                        lat: banner_street_view.data( 'latitude' ),
                        lng: banner_street_view.data( 'longitude' )
                    },
                    pov: {
                        heading: banner_street_view.data( 'heading' ),
                        pitch: banner_street_view.data( 'pitch' )
                    },
                    zoom: banner_street_view.data( 'zoom' ),
                    linksControl: false,
                    panControl: false,
                    scrollwheel: false,
                    addressControl: false,
                    visible: true
                }
            );
        }
    }

    /**
     * Detail gallery
     */
    var listingGallery = $('.listing-detail-gallery');
    var listingGalleryPreview = $('.listing-detail-gallery-preview-inner');
    var listingGalleryPreviewCount = listingGalleryPreview.data('count');
    var listingGalleryPreviewItems = 7;

    if (listingGallery.length != 0) {
        var loop = true;

        if (listingGallery.length === 1) {
            loop = false;
        }

        listingGallery.owlCarousel({
            items: 1,
            loop: loop,
            autoHeight: true,
            autoplay: true,
            autoplayTimeout:5000,
            smartSpeed: 700,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
        });
    }

    if (listingGalleryPreview.length != 0) {
        listingGalleryPreview.owlCarousel({
            items: listingGalleryPreviewItems,
            nav: (listingGalleryPreviewCount > listingGalleryPreviewItems),
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
        });
    }

    $('.listing-detail-gallery-preview-inner .owl-item:first').addClass('highlighted');

    listingGallery.on('changed.owl.carousel', function(event) {
        var currentIndex = event.item.index - 0; // bug because of "loop: true";
        var firstActiveIndex = $('.listing-detail-gallery-preview-inner .owl-item.active:first').children().data('item-id');
        var lastActiveIndex = $('.listing-detail-gallery-preview-inner .owl-item.active:last').children().data('item-id');

        if ( currentIndex == event.item.count ) {
            currentIndex = 0;
        }

        // Highlight current item
        $('.listing-detail-gallery-preview-inner .owl-item.highlighted').removeClass('highlighted');
        $('.listing-detail-gallery-preview-inner .owl-item:eq(' + currentIndex + ')').addClass('highlighted');

        // Move preview if it is necessary
        if (firstActiveIndex >= currentIndex) {
            for (var i = 0; i <= ( firstActiveIndex - currentIndex ); i++) {
                listingGalleryPreview.trigger('prev.owl.carousel');
            }
        } else if (lastActiveIndex <= currentIndex) {
            for (var i = 0; i <= ( currentIndex - lastActiveIndex ); i++) {
                listingGalleryPreview.trigger('next.owl.carousel');
            }
        }
    });

    // Show in gallery image from preview
    $('.listing-detail-gallery-preview-inner .owl-item').click(function(){
        var itemIndex = $(this).children().data('item-id');
        listingGallery.trigger('to.owl.carousel', [itemIndex, 300]);
    });

    $('.listing-detail-gallery').on('click', function() {
        listingGallery.trigger('stop.owl.autoplay');
    });

    /**
     * Colorbox
     */
    $('.listing-detail-gallery a').colorbox({
        ref: 'listing-gallery',
        maxHeight: '90%',
        maxWidth: '85%'
    });

    /**
     * Listing Detail Bookmark & Like
     */
    $(".detail-banner-btn.bookmark").click(function(){
        $(this).toggleClass("marked");

        var span = $(this).children("span");
        var toggleText = span.data("toggle");
        span.data("toggle", span.text());
        span.text(toggleText);
    });

    /**
     * Social Login
     */
    var title;
    $('.wp-social-login-provider').each(function(){
        title = $(this).attr('title');
        $(this).text(title);
    });

    /**
     * Responsive menu
     */
    function responsiveMenu() {
        var parent_menu = $('#menu-main-menu .menu-item-has-children');

        parent_menu.on('hover', function(e) {
            e.preventDefault();
        });

        parent_menu.on('click', function(e) {
            if (!$(this).hasClass('touched')) {
                e.preventDefault();
                $(this).closest('ul').find('> li').removeClass('touched');
                $(this).toggleClass('touched');
            }
        })
    }

    $(window).resize(function() {
        if ($(window).width() < 768) {
            responsiveMenu();
        }
    });

    if ($(window).width() < 768) {
        responsiveMenu();
    }

    /**
     * Masonry blog
     */
    if ( $('.content .post-masonry').length > 0 ) {
        $('.content').masonry({
            itemSelector: '.post-masonry'
        });
    }
});
