jQuery(document).ready(function($) {

    $( window ).load(function() {
        masonryInit('.testimonials', '.testimonial');
    });

    $( window ).resize(function() {
        masonryInit('.testimonials', '.testimonial');
    });

    function masonryInit( wrapper, item, columns, gutter, oneColumnResolution) {
        columns = columns || 2;
        gutter = gutter || 30;
        oneColumnResolution = oneColumnResolution || 991;

        if ( $( window ).width() <= oneColumnResolution ) {
            columns = 1;
        }
        var containerWidth = $(wrapper).width();
        var itemWidth = ( containerWidth - ( columns - 1 ) * gutter ) / columns;

        $(item).css('width', itemWidth);

        $(wrapper).masonry({
            itemSelector: item,
            columnWidth: itemWidth,
            gutter: gutter
        });
    }
});