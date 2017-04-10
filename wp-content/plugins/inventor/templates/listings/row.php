<?php $featured = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'featured', true ); ?>
<?php $reduced = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'reduced', true ); ?>

<?php if ( has_post_thumbnail() ) : ?>
    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
    <?php $image = $thumbnail[0]; ?>
<?php else: ?>
    <?php $image = esc_attr( plugins_url( 'inventor' ) ) . '/assets/img/default-item.png'; ?>
<?php endif; ?>

<div class="listing-row <?php if ( ! empty( $featured ) ) : ?>featured<?php endif; ?>">
    <div class="listing-row-image" style="background-image: url('<?php echo esc_attr( $image ); ?>');">
        <a href="<?php the_permalink() ?>" class="listing-row-image-link"></a>

        <div class="listing-row-actions">
            <?php do_action( 'inventor_listing_actions', get_the_ID(), 'row' ); ?>
        </div><!-- /.listing-row-actions -->

        <?php if ( $featured ) : ?>
            <div class="listing-row-label-top listing-row-label-top-left"><?php echo esc_attr__( 'Featured', 'inventor' ); ?></div><!-- /.listing-row-label-top-left -->
        <?php endif; ?>

        <?php if ( $reduced ) : ?>
            <div class="listing-row-label-top listing-row-label-top-right"><?php echo esc_attr__( 'Reduced', 'inventor' ); ?></div><!-- /.listing-row-label-top-right -->
        <?php endif; ?>

        <?php $listing_type_name = Inventor_Post_Types::get_listing_type_name(); ?>
        <?php if ( ! empty( $listing_type_name ) ) : ?>
            <div class="listing-row-label-bottom"><?php echo wp_kses( $listing_type_name, wp_kses_allowed_html( 'post' ) ); ?></div><!-- /.listing-row-label-bottom -->
        <?php endif; ?>
    </div><!-- /.listing-row-image -->


    <div class="listing-row-body">
        <h2 class="listing-row-title"><a href="<?php the_permalink(); ?>"><?php echo Inventor_Utilities::excerpt( get_the_title(), 50 ); ?></a></h2>
        <div class="listing-row-content">
            <?php the_excerpt(); ?>

            <p>
                <a class="read-more-link" href="<?php echo esc_attr( get_permalink( get_the_ID() ) ); ?>"><?php echo esc_attr__( 'Read More', 'inventor' ); ?><i class="fa fa-chevron-right"></i></a>
            </p>
        </div><!-- /.listing-row-content -->
    </div><!-- /.listing-row-body -->

    <div class="listing-row-properties">
        <dl>
            <?php $price = Inventor_Price::get_price( get_the_ID() ); ?>
            <?php if ( ! empty( $price ) ) : ?>
                <dt><?php echo esc_attr__( 'Price', 'inventor' ); ?></dt>
                <dd><?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?></dd>
            <?php endif; ?>

            <?php $location = Inventor_Query::get_listing_location_name( get_the_ID(), '/', false ); ?>
            <?php if ( ! empty( $location ) ) : ?>
                <dt><?php echo esc_attr__( 'Location', 'inventor' ); ?></dt>
                <dd><?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?></dd>
            <?php endif; ?>

            <?php do_action( 'inventor_listing_content', get_the_ID(), 'row' ); ?>
        </dl>
    </div><!-- /.listing-row-properties -->
</div><!-- /.listing-row -->
