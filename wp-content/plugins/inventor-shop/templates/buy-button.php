<?php if ( $is_enabled ): ?>
    <div class="inventor-shop-wrapper">
        <?php if ( $is_available ) : ?>
            <?php if ( ! empty( $listing_id ) && ! empty( $payment_page_id ) ) : ?>
                <form method="post" action="<?php echo get_permalink( $payment_page_id ); ?>">
                    <input type="hidden" name="payment_type" value="listing">
                    <input type="hidden" name="object_id" value="<?php echo esc_attr( $listing_id ); ?>">
                    <button type="submit"><?php echo __( 'Buy', 'inventor-shop' ); ?></button>
                </form><!-- /.inventor-shop-form -->
            <?php endif; ?>
        <?php else: ?>
<!--            <span class="not-available">--><?php //echo __( 'Not available', 'inventor-shop' ); ?><!--</span>-->
        <?php endif ; ?>
    </div>
<?php endif ; ?>