<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php if ( ! empty( $instance['title'] ) ) : ?>
	<?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
	<?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
	<?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>

<?php if ( have_posts() ) :  ?>
	<div class="listings-slider-list owl-carousel owl-theme <?php if ( ! empty( $instance['fullscreen'] ) ) : ?>listings-slider-fullscreen<?php endif; ?>" style="height: <?php echo ! empty( $instance['height'] ) ? $instance['height'] : '500px'; ?>;">
		<?php $index = 0; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php $image_id = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'listing_slider_image_id', true ); ?>
			<?php $image = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'listing_slider_image', true ); ?>

			<div class="listings-slider-item" data-index="<?php echo esc_attr( $index ); ?>">
				<div class="listings-slider-item-image" style="height: <?php echo ! empty( $instance['height'] ) ? $instance['height'] : '500px'; ?>; background-image: url('<?php echo esc_attr( $image ); ?>');">
				</div><!-- /.listings-slider-item-image -->

				<div class="listings-slider-item-info-wrapper">
					<div class="listings-slider-item-info">
						<div class="listings-slider-item-info-inner">
							<div class="listings-slider-item-info-title">
								<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
							</div><!-- /.listings-slider-item-info-title -->

							<div class="listings-slider-item-info-location">
								<?php echo Inventor_Query::get_listing_location_name(); ?>
							</div><!-- /.listings-slider-item-info-location -->

							<div class="listings-slider-item-info-more">
								<a href="<?php the_permalink(); ?>">
									<?php echo __( 'View Detail', 'inventor-listing-slider' ); ?>
								</a>
							</div><!-- /.listings-slider-item-info-location -->
						</div><!-- /.listings-slider-item-info-inner -->
					</div><!-- /.listings-slider-item-info -->
				</div><!-- /.listings-slider-item-info-wrapper -->
			</div><!-- /.listings-slider-item -->
			<?php $index++; ?>
		<?php endwhile; ?>
	</div><!-- /.listings-slider-list -->

	<div class="listings-slider-dots">
		<?php $index = 0; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php $image_id = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'listing_slider_image_id', true ); ?>
			<?php $image_thumbnail_src = wp_get_attachment_image_src( $image_id, $instance['size']  ); ?>

			<div class="listings-slider-dot <?php if ( 0 == $index ) : ?>active<?php endif; ?>" data-index="<?php echo esc_attr( $index ); ?>" data-background-image="<?php echo $image_thumbnail_src[0]; ?>" alt='<?php the_title(); ?>'></div><!-- /.listings-slider-dor -->
			<?php $index++; ?>
		<?php endwhile; ?>
	</div><!-- /.listings-slider-dots -->

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var el = $('#<?php echo esc_attr( $args['widget_id'] ); ?> .listings-slider-list');

			var owl = el.owlCarousel({
				responsive: {
					0: {
						dots: false
					},
					768: {
						dots: <?php if ( ! empty( $instance['disable_dots'] ) ) : ?>false<?php else : ?>true<?php endif; ?>
					}
				},
				responsiveClass: true,
				loop: ($('> div', el).length > 1),
				items: 1,
				mouseDrag: false,
				onInitialized: function() {
					var length = el.find('.owl-item:not(.cloned)').length;
					el.find('.owl-prev').prepend('<span>' + length + ' / ' + length +'</span>');
					el.find('.owl-next').prepend('<span>2 / ' + length +'</span>');
				},
				dots: false,
				onTranslated: function() {
					var items = el.find('.owl-item:not(.cloned)');
					var length = items.length;
					var index = items.index($('.owl-item.active')) + 1;

					var prev = index - 1;
					if (index == 0) {
						prev = length;
					}

					var next = index + 1;
					if (index == length) {
						next = 1;
					} else if ( index == 0) {
						next = 2;
					}

					el.find('.owl-prev span').text(prev + ' / ' + length);
					el.find('.owl-next span').text(next + ' / ' + length);

					var index = el.find('.active > div').data('index');
					$('#<?php echo esc_attr( $args['widget_id'] ); ?>').find('.listings-slider-dot').removeClass('active').eq(index).addClass('active');
				},
				<?php if ( ! empty( $instance['show_arrows'] ) ) : ?>
					nav: true,
				<?php endif; ?>


				<?php if ( ! empty( $instance['autoplay'] ) ) : ?>
					autoplay: true,
					<?php if ( ! empty( $instance['autoplay_timeout'] ) ) : ?>
						autoplayTimeout: <?php echo esc_attr( $instance['autoplay_timeout'] ); ?>,
					<?php endif; ?>
				<?php endif; ?>
			});

			$('.listings-slider-dot').on('click', function(e) {
				var index = $(this).data('index');
				owl.trigger('to.owl.carousel', [index]);
			});
		});
	</script>
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>