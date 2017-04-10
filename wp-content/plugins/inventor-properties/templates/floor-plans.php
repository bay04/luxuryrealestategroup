<!-- FLOOR PLANS -->
<?php do_action( 'inventor_before_listing_detail_property_floor_plans' ); ?>

<?php $floor_plans = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'floor_plans', true ); ?>

<?php if ( ! empty( $floor_plans ) && is_array( $floor_plans ) ) : ?>
    <div class="listing-detail-section" id="listing-detail-section-property-floor-plans">
        <h2 class="page-header"><?php echo __( 'Floor plans', 'inventor-properties' ); ?></h2>

        <div class="listing-detail-property-floor-plans">
            <?php foreach ( $floor_plans as $id => $src ) : ?>
                <?php $img = wp_get_attachment_image_src( $id, 'large' ); ?>
                <?php $src = $img[0]; ?>
                <a href="<?php echo esc_url( $src ); ?>" rel="property-floor-plans">
                    <?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>
                </a>
            <?php endforeach; ?>
        </div><!-- /.listing-detail-floor-plans -->
    </div><!-- /.listing-detail-section -->
<?php endif; ?>

<?php do_action( 'inventor_after_listing_detail_property_floor_plans' ); ?>
