<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
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

    <?php if ( ! empty( $instance['title'] ) ) : ?>
        <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
        <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
        <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
    <?php endif; ?>

    <?php if ( ! empty( $instance['description'] ) ) : ?>
        <div class="description">
            <?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
        </div><!-- /.description -->
    <?php endif; ?>

    <?php if ( have_posts() ) : ?>
        <div class="items-per-row-<?php echo esc_attr( $instance['per_row'] ); ?>">
            <?php if ( $instance['per_row'] != 1 ) : ?>
                <div class="pricing-row">
            <?php endif; ?>

            <?php $index = 0; ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <?php include Inventor_Template_Loader::locate( 'pricing-table', INVENTOR_PRICING_DIR ); ?>

                <?php if ( ( $index + 1 ) % $instance['per_row'] == 0 && $instance['per_row'] != 1 && Inventor_Query::loop_has_next() ) : ?>
                    </div><div class="pricing-row">
                <?php endif; ?>

                <?php $index++; ?>
            <?php endwhile; ?>

            <?php if ( $instance['per_row'] != 1 ) : ?>
                </div><!-- /.properties-row -->
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-warning">
            <?php echo __( 'No pricing tables found.', 'inventor-pricing' ); ?>
        </div><!-- /.alert -->
    <?php endif; ?>

</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>