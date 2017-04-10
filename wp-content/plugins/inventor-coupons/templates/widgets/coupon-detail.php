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
		<?php $variant = get_post_meta( get_the_ID(), INVENTOR_COUPON_PREFIX . 'variant' , true );?>
		<?php if ( 'image' == $variant ): ?>
			<?php $download_link = get_post_meta( get_the_ID(), INVENTOR_COUPON_PREFIX . 'image', true ); ?>
			<?php if ( ! empty( $download_link ) ) : ?>
				<a href="<?php echo esc_attr( $download_link ); ?>" class="widget_coupon_detail_button"><?php echo esc_attr__( 'Print Coupon', 'inventor-coupons' ); ?></a>
			<?php endif; ?>
		<?php elseif ( 'code' == $variant ) : ?>
			<?php $code = get_post_meta( get_the_ID(), INVENTOR_COUPON_PREFIX . 'code', true ); ?>
			<?php if ( ! empty( $code ) ) : ?>
				<a href="#" class="widget_coupon_detail_button widget_coupon_detail_button_get_the_code" data-code="<?php echo esc_attr( $code ); ?>">
					<?php echo esc_attr__( 'Get the Code', 'inventor-coupons' ); ?>
				</a>
			<?php endif; ?>
		<?php elseif ( 'code_generated' == $variant ) : ?>
			<?php if ( is_user_logged_in() ) : ?>
				<?php $count = get_post_meta( get_the_ID(), INVENTOR_COUPON_PREFIX . 'count', true ); ?>
				<?php $codes = get_post_meta( get_the_ID(), INVENTOR_COUPON_PREFIX . 'codes', true ); ?>
				<?php $codes = empty( $codes ) ? array() : $codes; ?>
				<?php $user_code = Inventor_Coupons_Logic::get_user_code( get_the_ID(), get_current_user_id() ); ?>

				<?php if ( ! empty( $user_code ) ) : ?>
					<p><a class="widget_coupon_detail_button"><?php echo esc_attr( $user_code ); ?></a></p>
				<?php endif; ?>

				<?php if ( empty( $user_code ) && count( $codes ) < $count ): ?>
					<a href="<?php echo admin_url( 'admin-ajax.php' ); ?>"
					   data-coupon-id="<?php the_ID(); ?>"
					   class="widget_coupon_detail_button widget_coupon_detail_button_generate_code">
						<?php echo esc_attr__( 'Generate Code', 'inventor-coupons' ); ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $count ) && count( $codes ) < $count ) : ?>
					<div class="widget_coupon_detail_description widget_coupon_detail_available_code">
						<?php echo esc_attr__( 'Available codes', 'inventor-coupons' ); ?>:
						<strong><?php echo esc_attr( count( $codes ) ); ?>/<?php echo esc_attr( $count ); ?></strong>
					</div><!-- /.widget_coupon_detail_description -->
				<?php elseif ( ! empty( $count ) && count( $codes ) >= $count ) : ?>
					<div class="widget_coupon_detail_warning">
						<?php echo esc_attr( 'No coupons available', 'inventor-coupons' ); ?>
					</div><!-- /.widget_coupon_detail_warning -->
				<?php endif; ?>
			<?php else : ?>
				<div class="widget_coupon_detail_warning">
					<?php echo esc_attr__( 'You must be logged in to get the coupon code.', 'inventor-coupons' ); ?>
				</div><!-- /.widget_coupon_detail_warning -->
			<?php endif; ?>
		<?php endif; ?>

		<?php $expiration = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'datetime_to', true ); ?>
		<?php if ( ! empty( $expiration ) ) : ?>
			<div class="widget_coupon_detail_description widget_coupon_detail_expiration">
				<?php echo esc_attr__( 'Expires', 'inventor-coupons' ); ?>:
				<strong><?php echo date_i18n( get_option( 'date_format' ), $expiration ); ?> <?php echo date_i18n( get_option( 'time_format' ), $expiration ); ?></strong>
			</div><!-- /.widget_coupon_detail_description -->
		<?php endif; ?>

		<?php $valid = get_post_meta( get_the_ID(), INVENTOR_COUPON_PREFIX . 'valid', true ); ?>
		<?php if ( ! empty( $valid ) ) : ?>
			<h3><?php echo esc_attr__( 'Voucher valid', 'inventor-coupons' ); ?></h3>
			<div class="widget_coupon_detail_description">
				<?php echo wp_kses( $valid, wp_kses_allowed_html( 'post' ) ); ?>
			</div><!-- /.widget_coupon_detail_description -->
		<?php endif; ?>

		<?php $conditions = get_post_meta( get_the_ID(), INVENTOR_COUPON_PREFIX . 'conditions', true ); ?>
		<?php if ( ! empty( $conditions ) ) : ?>
			<h3><?php echo esc_attr__( 'Conditions of application', 'inventor-coupons' ); ?></h3>

			<div class="widget_coupon_detail_description">
				<?php echo wp_kses( $conditions, wp_kses_allowed_html( 'post' ) ); ?>
			</div><!-- /.widget_coupon_detail_description -->
		<?php endif; ?>
	</div><!-- /.widget-content -->
</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
