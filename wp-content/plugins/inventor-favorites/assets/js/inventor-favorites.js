jQuery(document).ready(function($) {
    'use strict';

    var collection_pickup = $('#collection-pickup');
    var collection_pickup_btn_lookup = "#collection-pickup a";
    var favorite_toggle_class = ".inventor-favorites-btn-toggle";

    /**
     * Favorite toggle button
     */
    $(document).on("click", favorite_toggle_class, function(e) {
        var is_favorite = $(this).hasClass("marked");
        var action = is_favorite ? "inventor_favorites_remove_favorite" : "inventor_favorites_add_favorite";
        var toggler = $(this);
        var listing_id = toggler.data('listing-id');

        if(collection_pickup.length == 1 && ! is_favorite ) {
            // set pickup position
            collection_pickup.css('left', e.clientX);
            collection_pickup.css('top', e.clientY);

            // set listing id
            collection_pickup.data('listing-id', listing_id);

            var collections = collection_pickup.data('collections');

            $(collection_pickup_btn_lookup).each( function() {
                var collection_id = $( this ).data('collection-id');
                var collection_listings = collections[collection_id]['listings'];

                if ( collection_listings.indexOf(listing_id) != -1 ) {
                    $( this ).addClass('marked');
                } else {
                    $( this ).removeClass('marked');
                }
            });

            // toggle pickup visibility
            collection_pickup.toggleClass("visible");
        } else {
            $.ajax({
                url: toggler.data('ajax-url'),
                data: {
                    'action': action,
                    'id': listing_id
                }
            }).done(function( data ) {
                if (data.success) {
                    toggler.toggleClass("marked");
                    var span = toggler.children("span");
                    var toggleText = span.data("toggle");
                    span.data("toggle", span.text());
                    span.text(toggleText);

                    if ( data.collections ) {
                        // update collections
                        collection_pickup.data('collections', data.collections);
                    }
                } else {
                    alert(data.message);
                }
            });
        }

        e.preventDefault();
    });

    /**
     * Collection pickup
     */

    $(document).on("click", collection_pickup_btn_lookup, function(e) {
        var is_favorite = $(this).hasClass("marked");
        var action = is_favorite ? "inventor_favorites_remove_favorite" : "inventor_favorites_add_favorite";
        var toggler = $(this);
        var listing_id = collection_pickup.data('listing-id');

        $.ajax({
            url: toggler.data('ajax-url'),
            data: {
                'action': action,
                'id': listing_id,
                'collection-id': toggler.data('collection-id')
            }
        }).done(function( data ) {
            if (data.success) {
                toggler.toggleClass("marked");

                // TODO: mark parent toggler span class and text
                var parent_toggler = $('.inventor-favorites-btn-toggle[data-listing-id="'+ listing_id +'"]');

                parent_toggler.toggleClass("marked");
                var span = parent_toggler.children("span");
                var toggleText = span.data("toggle");
                span.data("toggle", span.text());
                span.text(toggleText);

                collection_pickup.toggleClass("visible");
            } else {
                alert(data.message);
            }
        });

        e.preventDefault();
    });

    // Close collection pickup button
    collection_pickup.find('.close').on('click', function() {
        collection_pickup.toggleClass('visible');
    });
});
