<?php

$default_social_networks = Inventor_Metaboxes::social_networks();
$social_networks = apply_filters( 'inventor_metabox_social_networks', array(), get_post_type() );
$social = '';

foreach( $social_networks as $key => $title ) {
    $field_id = INVENTOR_LISTING_PREFIX . $key;

    if ( apply_filters( 'inventor_metabox_field_enabled', true, INVENTOR_LISTING_PREFIX . get_post_type() . '_social', $field_id, get_post_type() ) ) {
        $social_value = get_post_meta( get_the_ID(), $field_id, true );

        if ( ! empty( $social_value ) ) {
            $class = array_key_exists( $key, $default_social_networks ) ? 'default' : '';
            $social_network_name = $social_networks[ $key ];

            $social_network_url = apply_filters( 'inventor_social_network_url', esc_attr( $social_value ), $key );
            $social .= '<a href="' . $social_network_url . '" target="_blank" class="' . $class . '"><i class="fa fa-'. esc_attr( $key ) .'"></i><span>' . $social_network_name . '</a>';
        }
    }
}
?>

<?php if ( ! empty( $social ) ) : ?>
    <div id="listing-detail-section-social" class="listing-detail-section">
        <h2 class="page-header"><?php echo $section_title; ?></h2>

        <div class="listing-detail-section-content-wrapper">
            <?php echo $social; ?>
        </div>
    </div><!-- /.listing-detail-section -->
<?php endif; ?>