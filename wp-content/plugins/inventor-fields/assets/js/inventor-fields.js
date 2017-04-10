jQuery(document).ready(function($) {
    'use strict';

    $('#field_settings #field_type').on('change', function() {
        var type = $(this).val();

        // types with options
        var field_options = $('#field_settings .cmb2-id-field-options');
        var choices_types = ["multicheck", "multicheck_inline", "radio", "radio_inline", "select"];
        if (choices_types.indexOf(type) == -1) {
            field_options.hide();
        } else {
            field_options.show();
        }

        // types with text value
        var value_type = $('#field_settings .cmb2-id-field-value-type');
        var text_types = ["text", "text_small", "text_medium"];
        if (text_types.indexOf(type) == -1) {
            value_type.hide();
        } else {
            value_type.show();
        }

        // types with taxonomies
        var taxonomy = $('#field_settings .cmb2-id-field-taxonomy');
        var taxonomy_types = [
            "taxonomy_radio",
            "taxonomy_radio_inline",
            "taxonomy_select",
            "taxonomy_select_hierarchy",
            "taxonomy_multicheck",
            "taxonomy_multicheck_inline",
            "taxonomy_multicheck_hierarchy"
        ];
        if (taxonomy_types.indexOf(type) == -1) {
            taxonomy.hide();
        } else {
            taxonomy.show();
        }
    }).change();

    // filter field
    $('input[type="checkbox"]#field_filter_field').on('change', function() {
        var is_filter_field = $(this).is(":checked");
        var filter_lookup = $('.cmb2-id-field-filter-lookup');

        if ( is_filter_field ) {
            filter_lookup.show();
        } else {
            filter_lookup.hide();
        }
    }).change();

    // metaboxes
    var listing_metaboxes = $('#field_settings input[name="field_metabox[]"][value^="listing_"]').parents('li');
    var user_metaboxes = $('#field_settings input[name="field_metabox[]"][value^="user_"]').parents('li');

    // target
    $('#field_settings input[name="field_target"]').on('change', function() {
        var target = $(this).val();

        if($(this).is(":checked")) {
            if (target == 'listing' ) {
                listing_metaboxes.show();
                user_metaboxes.hide();
            } else if (target == 'user' ) {
                listing_metaboxes.hide();
                user_metaboxes.show();
            }
        }
    }).change();
});