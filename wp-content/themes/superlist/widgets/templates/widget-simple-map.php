<?php
/**
 * Widget template
 *
 * @package Superlist
 * @subpackage Widgets/Templates
 */

?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<div class="widget-inner
	<?php echo esc_attr( $instance['classes'] ); ?>
	<?php echo ( empty( $instance['padding_top'] ) ) ? '' : 'widget-pt' ; ?>
	<?php echo ( empty( $instance['padding_bottom'] ) ) ? '' : 'widget-pb' ; ?>"
    <?php if ( ! empty( $instance['background_color'] ) || ! empty( $instance['background_image'] ) ) : ?>
        style="
        <?php if ( ! empty( $instance['background_color'] ) ) : ?>
            background-color: <?php echo esc_attr( $instance['background_color'] ); ?>;
    <?php endif; ?>
        <?php if ( ! empty( $instance['background_image'] ) ) : ?>
            background-image: url('<?php echo esc_attr( $instance['background_image'] ); ?>');
        <?php endif; ?>"
    <?php endif; ?>>

    <?php $style = ! empty( $instance['style'] ) ? $instance['style'] : ''; ?>
    <?php $style_slug = ( ! empty( $_GET['map-style'] ) ) ? esc_attr( $_GET['map-style'] ) : $style; // Input var okay; sanitization okay. ?>

    <div class="map-wrapper">
        <div class="map" id="simple-map" style="height: <?php echo esc_attr( $instance['height'] ); ?>px"
             data-transparent-marker-image="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/transparent-marker-image.png"
             data-latitude="<?php echo esc_attr( $instance['latitude'] ); ?>"
             data-longitude="<?php echo esc_attr( $instance['longitude'] ); ?>"
             data-zoom="<?php echo esc_attr( $instance['zoom'] ); ?>"
				<?php if ( class_exists( 'Inventor_Google_Map_Styles' ) ) : ?>data-styles='<?php echo esc_attr( Inventor_Google_Map_Styles::get_style( $style_slug ) ); ?>'<?php endif; ?>
             data-geolocation='false'>
        </div>
    </div><!-- /.map-wrapper -->
</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
