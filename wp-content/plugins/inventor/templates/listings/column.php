<?php $featured = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'featured', true ); ?>
<?php $reduced = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'reduced', true ); ?>
<?php $price = Inventor_Price::get_price( get_the_ID() ); ?>
<?php $price = empty( $price ) ? '' : $price; ?>

<?php if ( has_post_thumbnail() ) : ?>
    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
    <?php $image = $thumbnail[0]; ?>
<?php else: ?>
    <?php $image = esc_attr( plugins_url( 'inventor' ) ) . '/assets/img/default-item.png'; ?>
<?php endif; ?>

<div class="listing-column">
    <div class="listing-column-image" style="background-image: url('<?php echo esc_attr( $image ); ?>');">
    </div><!-- /.listing-column-image-->

    <?php if ( $featured ) : ?>
        <div class="listing-column-label-top listing-column-label-top-left"><?php echo esc_attr__( 'Featured', 'inventor' ); ?></div><!-- /.listing-column-label-top-left -->
    <?php endif; ?>

    <?php if ( $reduced ) : ?>
        <div class="listing-column-label-top listing-column-label-top-right"><?php echo esc_attr__( 'Reduced', 'inventor' ); ?></div><!-- /.listing-column-label-top-right -->
    <?php endif; ?>

    <?php $special_label = apply_filters( 'inventor_listing_special_label', $price, get_the_ID(), 'column' ); ?>
    <?php if ( ! empty( $special_label ) ): ?>
        <div class="listing-column-label-special">
            <?php echo $special_label; ?>
        </div><!-- /.listing-column-content -->
    <?php endif; ?>

    <div class="listing-column-title">
        <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

        <?php $location = Inventor_Query::get_listing_location_name( get_the_ID(), '/', false ); ?>
        <?php $subtitle = apply_filters( 'inventor_listing_subtitle', $location, get_the_ID(), 'column' ); ?>
        <?php if ( ! empty( $subtitle ) ): ?>
            <span class="listing-column-subtitle"><?php echo $subtitle; ?></span>
        <?php endif; ?>
    </div><!-- /.listing-column-title -->

    <div class="listing-column-content">
        <?php do_action( 'inventor_listing_content', get_the_ID(), 'column' ); ?>
    </div><!-- /.listing-column-content -->

    <?php $bottom_title = apply_filters( 'inventor_listing_bottom_title', '', get_the_ID(), 'column' ); ?>
    <?php if ( ! empty( $bottom_title ) || $bottom_title == '' ): ?>
        <div class="listing-column-bottom-title"><?php echo $bottom_title; ?></div>
    <?php endif; ?>

    <div class="listing-column-actions">
        <?php do_action( 'inventor_listing_actions', get_the_ID(), 'column' ); ?>
    </div><!-- /.listing-column-actions -->
</div><!-- /.listing-column -->
