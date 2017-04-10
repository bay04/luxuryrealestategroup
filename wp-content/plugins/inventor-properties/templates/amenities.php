<!-- Property amenities -->
<?php do_action( 'inventor_before_listing_detail_property_amenities' ); ?>

<?php $amenities = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'amenities', true ); ?>
<?php $hide_unassigned_amenities = get_theme_mod( 'inventor_properties_hide_unassigned_amenities', false ); ?>
<?php $all_amenities = get_terms( 'property_amenities', array( 'hide_empty' => false ) )?>

<?php if ( ! empty( $amenities ) && is_array( $amenities ) && count( $amenities ) > 0 && ! empty( $all_amenities ) && is_array( $all_amenities ) && count( $all_amenities ) > 0 ) : ?>
    <div class="listing-detail-section" id="listing-detail-section-property-amenities">
        <h2 class="page-header"><?php echo __( 'Amenities', 'inventor-properties' ); ?></h2>

        <div class="listing-detail-property-amenities">
            <ul>
                <?php foreach( $all_amenities as $amenity ) : ?>
                    <?php $has_term = in_array( $amenity->slug, $amenities ); ?>

                    <?php if ( ! $hide_unassigned_amenities || ( $hide_unassigned_amenities && $has_term ) ) : ?>
                        <li class="<?php echo $has_term ? 'yes' : 'no'; ?>">
                            <a href="<?php echo get_term_link( $amenity ); ?>">
                                <?php echo esc_attr( $amenity->name ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div><!-- /.listing-detail-amenities -->
    </div><!-- /.listing-detail-section -->
<?php endif; ?>

<?php do_action( 'inventor_after_listing_detail_property_amenities' ); ?>