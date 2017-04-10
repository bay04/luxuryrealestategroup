<!-- Property price comparison -->
<?php do_action( 'inventor_before_listing_detail_property_price_comparison' ); ?>

<?php
$area_unit_price = ${INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'area_unit_price'};
$avarage_area_unit_price = ${INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'average_area_unit_price'};
$average_area_unit_price_difference = ${INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'average_area_unit_price_difference'};
$area_unit = get_theme_mod( 'inventor_measurement_area_unit', 'sqft' );
$contract_type = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'contract_type', true );
$contract_type = Inventor_Properties_Post_Type_Property::get_contract_type( $contract_type );
?>

<div class="listing-detail-section" id="listing-detail-section-property-price-comparison">
    <h2 class="page-header"><?php echo sprintf( __( 'Price comparison per %s (%s)', 'inventor-properties' ), $area_unit, $contract_type ); ?></h2>

    <div class="listing-detail-property-price-comparison">
        <ul>
            <li class="property-area-unit-price">
                <h3><?php echo __( 'This property', 'inventor-properties' ); ?></h3>
                <span><?php echo $area_unit_price; ?></span>
            </li>
            <li class="average-area-unit-price">
                <h3><?php echo __( 'Average', 'inventor-properties' ); ?></h3>
                <span><?php echo $avarage_area_unit_price; ?></span>
            </li>
            <li class="average-area-unit-price-difference">
                <h3><?php echo __( 'Difference', 'inventor-properties' ); ?></h3>
                <span><?php echo $average_area_unit_price_difference; ?></span>
            </li>
        </ul>
    </div><!-- /.listing-detail-property-price-comparison -->
</div><!-- /.listing-detail-section -->
