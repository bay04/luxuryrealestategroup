jQuery(document).ready(function($) {
    'use strict';

    $('.widget_coupon_detail_button_get_the_code').on('click', function(e) {
        e.preventDefault();
        var code = $(this).data('code');
        $(this).text(code);
    });

    $('.widget_coupon_detail_button_generate_code').on('click', function(e) {
        e.preventDefault();
        var el = $(this);
        var url = $(this).attr('href');
        var id = $(this).data('coupon-id');

        $.ajax({
            url: url,
            data: {
                id: id,
                action: 'inventor_coupons_generate_code'
            },
            success: function(data) {
                if (!data.status) {
                    alert(data.message);
                } else if (data.status) {
                    el.text(data.code);
                }
            }
        });
    });
});