<div class="detail-banner">
    <?php $inside_view = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view', true );?>

    <?php if ( ! empty( $inside_view ) ): ?>
        <?php $banner_latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_latitude', true );?>
        <?php $banner_longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_longitude', true );?>
        <?php $banner_zoom = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_zoom', true ); ?>
        <?php $banner_heading = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_heading', true ); ?>
        <?php $banner_pitch = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'inside_view_location_pitch', true ); ?>
        <div id="banner-inside-view"
             data-latitude="<?php echo esc_attr( $banner_latitude ); ?>"
             data-longitude="<?php echo esc_attr( $banner_longitude ); ?>"
             data-zoom="<?php echo esc_attr( $banner_zoom ); ?>"
             data-heading="<?php echo esc_attr( $banner_heading ); ?>"
             data-pitch="<?php echo esc_attr( $banner_pitch ); ?>"></div>
    <?php endif; ?>

    <?php get_template_part( 'templates/content-listing-banner-info' ); ?>
</div><!-- /.detail-banner -->