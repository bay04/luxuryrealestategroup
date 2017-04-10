<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $instance['per_row'] = ! empty( $instance['per_row'] ) ? $instance['per_row'] : 4; ?>

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

	<?php if ( ! empty( $instance['description'] ) ) : ?>
		<div class="description">
			<?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
		</div><!-- /.description -->
	<?php endif; ?>

	<?php if ( is_array( $terms ) ) : ?>
		<div class="listing-categories-cards items-per-row-<?php echo esc_attr( $instance['per_row'] ); ?>">

			<?php foreach( $terms as $term ) : ?>
				<div class="listing-categories-card-container">
					<div class="listing-categories-card">
						<?php $image = get_term_meta( $term->term_id, 'image', true ); ?>
						<?php $image = empty( $image ) ? plugins_url( 'inventor' ) . '/assets/img/default-item.png' : esc_attr( $image ); ?>

						<div class="listing-categories-card-image" style="background-image: url('<?php echo $image; ?>');">
							<?php $color = get_term_meta( $term->term_id, 'color', true ); ?>

							<a href="<?php echo get_term_link( $term->term_id, $term->taxonomy ); ?>" <?php if ( ! empty( $icon ) ) :?>style="border-color:<?php echo $color; ?>;"<?php endif; ?>>
								<?php
								$icon = get_term_meta( $term->term_id, 'poi', true );

								if ( ! empty( $icon ) ) {
									$style = empty( $icon ) ? '' : 'style="background-color: ' . $color .' ;"';
									echo '<i class="inventor-poi '. $icon .'" ' . $style .'></i>';
								}
								?>
							</a>
						</div><!-- /.listing-categories-card-image -->

						<h3 class="listing-categories-card-title">
							<a href="<?php echo get_term_link( $term->term_id, $term->taxonomy ); ?>"><?php echo esc_attr( $term->name ); ?></a>
						</h3><!-- /.listing-categories-card-title -->

						<?php if ( ! empty( $instance['show_count'] ) ) : ?>
							<div class="listing-categories-card-bottom">
								<?php $listings_count = $term->count; ?>
								<?php printf( _n( '%d listing', '%d listings', $listings_count, 'inventor' ), $listings_count ); ?>
							</div>
						<?php endif; ?>
					</div><!-- /.listing-categories-card -->
				</div><!-- /.listing-categories-card-container -->
			<?php endforeach; ?>
		</div><!-- /.listing-categories-cards -->
	<?php endif; ?>	
	
</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>	