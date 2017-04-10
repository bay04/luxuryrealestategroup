<div class="detail-banner-shadow"></div>

<div class="container">
    <div class="detail-banner-left">
        <div class="detail-banner-info">
            <?php $listing_category = Inventor_Query::get_listing_category_name( get_the_ID(), ',', true ); ?>

            <?php if ( ! empty( $listing_category ) ) : ?>
                <div class="detail-label"><?php echo wp_kses( $listing_category, wp_kses_allowed_html( 'post' ) ); ?></div>
            <?php endif; ?>
        </div><!-- /.detail-banner-info -->

        <h1 class="detail-title">
            <?php echo apply_filters( 'inventor_listing_title', get_the_title(), get_the_ID() ); ?>
        </h1>

        <?php $slogan = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'slogan', true ); ?>
        <?php if ( ! empty( $slogan ) ) : ?>
            <h4 class="detail-banner-slogan">
                <?php echo esc_attr( $slogan ); ?>
            </h4>
        <?php endif; ?>

        <?php $location = Inventor_Query::get_listing_location_name(); ?>
        <?php if ( ! empty( $location ) ) : ?>
            <div class="detail-banner-address">
                <i class="fa fa-map-marker"></i> <?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
            </div><!-- /.detail-banner-address -->
        <?php endif; ?>

        <div class="detail-banner-after">
            <?php do_action( 'superlist_after_listing_banner', get_the_ID() ); ?>
        </div><!-- /.detail-banner-after -->
    </div><!-- /.detail-banner-left -->

    <div class="detail-banner-right">
        <?php $price = Inventor_Price::get_price(); ?>
        <?php $reduced = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'reduced', true ); ?>
        <?php if ( ! empty( $price ) ) : ?>
            <div class="detail-banner-price <?php echo ( ! empty( $reduced ) ) ? 'reduced-price' : '' ;?>">
                <span class="detail-banner-price-label"><?php echo esc_attr( ! empty( $reduced ) ) ? esc_attr__( 'Reduced Price', 'superlist' ) : esc_attr__( 'Price', 'superlist' );?>:</span>
                <span class="detail-banner-price-value"><?php echo esc_attr( $price ); ?></span>
                <?php do_action( 'inventor_after_listing_price', get_the_ID() ); ?>
            </div>
        <?php endif; ?>
    </div><!-- /.detail-banner-right -->
</div><!-- /.container -->