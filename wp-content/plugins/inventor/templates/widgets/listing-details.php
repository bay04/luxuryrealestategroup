<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php do_action( 'inventor_listing_details_before', get_the_ID() ); ?>

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

        <?php if ( ! empty( $instance['title'] ) ) : ?>
            <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
            <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
            <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
        <?php endif; ?>

        <?php do_action( 'inventor_listing_detail', get_the_ID() ); ?>

    </div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php do_action( 'inventor_listing_details_after', get_the_ID() ); ?>
