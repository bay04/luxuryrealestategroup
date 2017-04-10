jQuery(document).ready(function($) {
    'use strict';

    $('input[type="checkbox"]#user_package_infinite').on('change', function() {
        var infinite = $(this).is(":checked");
        var validity = $('.cmb2-id-user-package-valid');

        if ( infinite ) {
            validity.hide();
        } else {
            validity.show();
        }
    }).change();

    $('input[type="checkbox"]#package_listing_types_restriction').on('change', function() {
        var restrict = $(this).is(":checked");
        var listing_types = $('.cmb2-id-package-listing-types-allowed');

        if ( restrict ) {
            listing_types.show();
        } else {
            listing_types.hide();
        }
    }).change();
});