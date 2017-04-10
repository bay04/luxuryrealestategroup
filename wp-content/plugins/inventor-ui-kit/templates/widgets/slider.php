<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php //echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>
<div id="<?php echo $args['widget_id'] ?>" class="widget widget_inventor_slider">

<?php if ( ! empty( $instance['title'] ) ) : ?>
	<?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
	<?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
	<?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>

<?php if ( $instance['number_of_slides'] > 0 ) :  ?>
	<div class="inventor-slider-list owl-carousel owl-theme <?php if ( ! empty( $instance['navigation_style'] ) ): echo 'navigation-' . $instance['navigation_style']; endif; ?>" style="height: <?php echo ! empty( $instance['height'] ) ? $instance['height'] : '500px'; ?>;">
		<?php for ( $i = 1; $i <= $instance['number_of_slides']; $i++ ) : ?>
			<?php
			$attrs = array(
				'headline', 'title', 'text',
				'button_label', 'button_link',
				'background',
				'overlay_color', 'overlay_opacity',
				'alignment',
				'css_class'
			);

			foreach ( $attrs as $attr ) {
				${ $attr } = ! empty( $instance[ $attr . '_' . $i ] ) ? $instance[ $attr . '_' . $i ] : '';
			}
			?>

			<div class="inventor-slider-item alignment-<?php echo esc_attr( $alignment ); ?> <?php echo esc_attr( $css_class ); ?>" data-index="<?php echo esc_attr( $i ); ?>">
				<div class="inventor-slider-item-image" style="height: <?php echo ! empty( $instance['height'] ) ? $instance['height'] : '500px'; ?>; background-image: url('<?php echo esc_attr( $background ); ?>');">
				</div><!-- /.inventor-slider-item-image -->

				<div class="inventor-slider-item-overlay" style="<?php if ( ! empty( $overlay_opacity ) ) : echo 'opacity:' . esc_attr( $overlay_opacity ) . ';'; endif; ?><?php if ( ! empty( $overlay_color ) ) : echo 'background-color:' . esc_attr( $overlay_color ) . ';'; endif; ?>">
				</div><!-- /.inventor-slider-item-overlay -->

				<div class="inventor-slider-item-info-wrapper">
					<div class="inventor-slider-item-info">
						<div class="inventor-slider-item-info-headline">
							<?php echo wp_kses( $headline, wp_kses_allowed_html( 'post' ) ); ?>
						</div><!-- /.inventor-slider-item-info-headline -->

						<div class="inventor-slider-item-info-title">
							<h1><?php echo wp_kses( $title, wp_kses_allowed_html( 'post' ) ); ?></h1>
						</div><!-- /.inventor-slider-item-info-title -->

						<div class="inventor-slider-item-info-text">
							<p><?php echo wp_kses( $text, wp_kses_allowed_html( 'post' ) ); ?></p>
						</div><!-- /.inventor-slider-item-info-text -->

						<?php if ( ! empty( $button_label ) && ! empty( $button_link ) ) : ?>
							<div class="inventor-slider-item-info-button">
								<a href="<?php echo esc_attr( $button_link ); ?>">
									<?php echo esc_attr( $button_label ); ?>
								</a>
							</div><!-- /.inventor-slider-item-info-button -->
						<?php endif; ?>
					</div><!-- /.inventor-slider-item-info -->
				</div><!-- /.inventor-slider-item-info-wrapper -->
			</div><!-- /.inventor-slider-item -->
		<?php endfor; ?>
	</div><!-- /.inventor-slider-list -->

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var el = $('#<?php echo esc_attr( $args['widget_id'] ); ?> .inventor-slider-list');

			var owl = el.owlCarousel({
				responsiveClass: true,
				loop: ($('> div', el).length > 1),
				items: 1,
				mouseDrag: true,
				<?php if ( ! empty( $instance['dots'] ) ) : ?>
				dots: true,
				<?php endif; ?>
				<?php if ( ! empty( $instance['navigation_counter'] ) ) : ?>
				onInitialized: function() {
					var length = el.find('.owl-item:not(.cloned)').length;
					el.find('.owl-prev').prepend('<span>' + length + ' / ' + length +'</span>');
					el.find('.owl-next').prepend('<span>2 / ' + length +'</span>');
				},
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
					$('#<?php echo esc_attr( $args['widget_id'] ); ?>').find('.inventor-slider-dot').removeClass('active').eq(index).addClass('active');
				},
				<?php endif; ?>
				<?php if ( $instance['navigation_style'] != 'none' ) : ?>
				nav: true,
				<?php endif; ?>
				<?php if ( ! empty( $instance['autoplay'] ) ) : ?>
				autoplay: true,
				<?php if ( ! empty( $instance['autoplay_timeout'] ) ) : ?>
				autoplayTimeout: <?php echo esc_attr( $instance['autoplay_timeout'] ); ?>,
				<?php endif; ?>
				<?php endif; ?>
			});
		});
	</script>
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>