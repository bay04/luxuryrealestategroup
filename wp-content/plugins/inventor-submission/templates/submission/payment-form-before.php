<?php if ( ! empty( $object_id ) ) : ?>
    <?php $price = Inventor_Submission_Logic::payment_price_value( null, $payment_type, $object_id ); ?>
    <?php $title = get_the_title( $object_id ); ?>

    <?php if ( empty( $price ) || $price == 0 ) : ?>
        <div class="alert alert-danger">
            <?php echo __( "Price is not set.", 'inventor-submission' ); ?>
        </div><!-- /.payment-info -->
    <?php else : ?>
        <div class="payment-info">
        <?php if ( 'featured_listing' == $payment_type ) : ?>
            <?php echo sprintf( __( 'You are going to pay <strong>%s</strong> for featured listing <strong>"%s"</strong>.', 'inventor-submission' ), Inventor_Price::format_price( $price ), $title ); ?>
        <?php elseif ( 'publish_listing' == $payment_type ): ?>
            <?php echo sprintf( __( 'You are going to pay <strong>%s</strong> to publish listing <strong>"%s"</strong>.', 'inventor-submission' ), Inventor_Price::format_price( $price ), $title ); ?>
        <?php endif; ?>
        </div><!-- /.payment-info -->
    <?php endif; ?>

<?php else : ?>
    <div class="payment-info">
        <?php echo __( 'Missing listing.', 'inventor-submission' ); ?>
    </div><!-- /.payment-info -->
<?php endif; ?>