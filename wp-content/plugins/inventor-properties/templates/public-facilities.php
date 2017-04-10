<!-- PUBLIC FACILITIES -->
<?php do_action( 'inventor_before_listing_detail_property_public_facilities' ); ?>

<?php $facilities = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'public_facilities', true ); ?>

<?php if ( ! empty( $facilities ) && is_array( $facilities ) && ! empty( $facilities[0] ) ) : ?>
    <div class="listing-detail-section" id="listing-detail-section-property-public-facilities">
        <h2 class="page-header"><?php echo __( 'Public facilities', 'inventor-properties' ); ?></h2>

        <div class="listing-detail-property-public-facilities">
            <?php foreach ( $facilities as $facility ) : ?>
                <?php $key = esc_attr( $facility[ INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'public_facilities_key' ] ); ?>
                <?php $value = esc_attr( $facility[ INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'public_facilities_value' ] ); ?>

                <div class="listing-detail-property-public-facility-wrapper">
                    <div class="listing-detail-property-public-facility">
                        <div class="listing-detail-property-public-facility-title">
                            <span><?php echo $key ?></span>
                        </div><!-- /.property-public-facility-title -->

                        <div class="listing-detail-property-public-facility-info">
                            <?php echo $value ?>
                        </div><!-- /.listing-detail-property-public-facility-info -->
                    </div><!-- /.listing-detail-property-public-facility -->
                </div><!-- /.listing-detail-property-public-facility-wrapper -->
            <?php endforeach; ?>
        </div><!-- /.listing-detail-public-facilities -->
    </div><!-- /.listing-detail-section -->
<?php endif; ?>

<?php do_action( 'inventor_after_listing_detail_property_public_facilities' ); ?>
