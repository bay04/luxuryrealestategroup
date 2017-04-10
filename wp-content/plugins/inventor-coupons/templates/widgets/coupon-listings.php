<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<div class="widget-inner
 <?php if ( ! empty( $instance['classes'] ) ) : ?><?php echo esc_attr( $instance['classes'] ); ?><?php endif; ?>
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

	<div class="widget-content">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php include Inventor_Template_Loader::locate( 'coupons/small', INVENTOR_COUPONS_DIR ); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div><!-- /.widget-content -->
</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
