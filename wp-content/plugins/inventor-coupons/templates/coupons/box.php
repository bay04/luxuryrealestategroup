<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */

?>

<div class="coupon-box">
	<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
	<div class="coupon-box-image"
	     style="background-image: url('<?php if ( has_post_thumbnail() ) : ?><?php echo esc_attr( $image['0'] ); ?><?php else : ?><?php echo esc_attr( plugins_url( 'inventor' ) ); ?>/assets/img/default-item.png<?php endif; ?>');">

		<div class="coupon-box-image-shadow"></div><!-- /.coupon-box-image-shadow -->

		<dl><?php do_action( 'inventor_listing_content', get_the_ID(), 'box' ); ?></dl>

		<?php $discount = get_post_meta( get_the_ID(), INVENTOR_COUPON_PREFIX . 'discount', true ); ?>
		<?php if ( ! empty( $discount ) ) : ?>
			<span class="coupon-box-image-discount">
				<?php echo esc_attr( $discount ); ?>%
			</span><!-- /.coupon-box-image-discount -->
		<?php endif; ?>

		<?php $location = Inventor_Query::get_listing_location_name(); ?>
		<?php if ( ! empty( $location ) ) : ?>
			<div class="coupon-box-image-location">
				<?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
			</div><!-- /.coupon-box-image-location -->
		<?php endif; ?>

		<span class="coupon-box-image-content">
			<?php the_excerpt(); ?>
		</span><!-- /.coupon-box-image-content -->

		<a href="<?php the_permalink(); ?>" class="coupon-box-image-link"></a>
	</div><!-- /.coupon-box-image -->

	<div class="coupon-box-content">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<div class="coupon-box-content-sub">
			<?php $expiration = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'datetime_to', true ); ?>
			<span class="coupon-content-expiration">
				<?php if ( ! empty( $expiration ) ) : ?>
					<?php echo esc_attr__( 'Expiration', 'inventor-coupons' ); ?>: <?php echo date_i18n( get_option( 'date_format' ), $expiration ); ?> <?php echo date_i18n( get_option( 'time_format' ), $expiration ); ?>
				<?php else : ?>
					<?php echo esc_attr__( 'Coupon does not expire.', 'inventor-coupons' ); ?>
				<?php endif; ?>
			</span><!-- /.coupon-content-expiration -->

			<span class="coupon-box-content-view">
				<a href="<?php the_permalink(); ?>"><?php echo esc_attr__( 'View Coupon', 'inventor-coupons' ); ?></a>
			</span>
		</div><!-- /.coupon-box-content-sub -->
	</div><!-- /.coupon-box-content -->
</div><!-- /.coupon-box -->
