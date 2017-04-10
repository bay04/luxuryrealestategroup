<div class="detail-banner">
    <?php $banner_latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_latitude', true );?>
    <?php $banner_longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_longitude', true );?>
    <?php $banner_map_type = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_map_type', true ); ?>
    <?php $banner_marker = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_map_marker', true ); ?>
    <?php $banner_zoom = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_map_zoom', true ); ?>
    <div id="banner-map"
         data-transparent-marker-image="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/transparent-marker-image.png"
         data-latitude="<?php echo esc_attr( $banner_latitude ); ?>"
         data-longitude="<?php echo esc_attr( $banner_longitude ); ?>"
         data-map-type="<?php echo esc_attr( $banner_map_type ); ?>"
         data-marker="<?php echo esc_attr( $banner_marker ); ?>"
         data-zoom="<?php echo esc_attr( empty( $banner_zoom ) ? 17 : $banner_zoom ); ?>"></div>
    <?php get_template_part( 'templates/content-listing-banner-info' ); ?>
</div><!-- /.detail-banner -->