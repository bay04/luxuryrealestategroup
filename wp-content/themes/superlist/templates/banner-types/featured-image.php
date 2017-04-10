<?php if ( has_post_thumbnail() ) : ?>
    <?php $thumbnail = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
    <?php $image = apply_filters( 'inventor_listing_featured_image', $thumbnail, get_the_ID() ); ?>
<?php endif; ?>

<div class="detail-banner" <?php if( ! empty( $image ) ): ?>data-background-image="<?php echo esc_attr( $image ); ?>"<?php endif; ?>>
    <?php get_template_part( 'templates/content-listing-banner-info' ); ?>
</div><!-- /.detail-banner -->