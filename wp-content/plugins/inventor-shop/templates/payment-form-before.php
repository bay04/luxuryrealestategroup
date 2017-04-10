<?php if ( 'listing' == $payment_type ) : ?>

    <?php if ( ! empty( $object_id ) ) : ?>
        <?php $title = get_the_title( $object_id ); ?>
        <?php $price = Inventor_Price::get_listing_price( $object_id ) ?>

        <?php if ( empty( $price ) || $price == 0 ) : ?>
            <div class="alert alert-danger">
                <?php echo __( "Listing price is not set.", 'inventor-shop' ); ?>
            </div><!-- /.payment-info -->
        <?php else : ?>
            <div class="payment-info">
                <?php echo sprintf( __( 'You are going to pay <strong>%s</strong> for listing <strong>"%s"</strong>.', 'inventor-shop' ), Inventor_Price::format_price( $price ), $title ); ?>
            </div><!-- /.payment-info -->
        <?php endif; ?>

    <?php else : ?>
        <div class="payment-info">
            <?php echo __( 'Missing listing.', 'inventor-shop' ); ?>
        </div><!-- /.payment-info -->
    <?php endif; ?>

<?php endif; ?>