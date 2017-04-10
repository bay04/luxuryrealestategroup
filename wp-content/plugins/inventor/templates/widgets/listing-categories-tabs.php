<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $instance['per_row'] = ! empty( $instance['per_row'] ) ? $instance['per_row'] : 3; ?>

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

<?php if ( is_array( $terms ) ) : ?>
	<ul class="nav nav-tabs listing-categories-tabs" role="tablist">
		<?php $index = 0; ?>
		<?php foreach( $terms as $term ) : ?>
			<li class="nav-item <?php if ( $index == 0 ) : ?>active<?php endif; ?>">
				<a href="#listing-categories-<?php echo esc_attr( $term->term_id ); ?>" class="nav-link">
					<?php echo esc_attr( $term->name ); ?>
				</a>
			</li>

			<?php $index++; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if ( is_array( $terms ) ) : ?>
	<div class="tab-content">
		<?php $index = 0; ?>

		<?php foreach ( $terms as $term ) : ?>
			<?php $subterms = get_terms( 'listing_categories', array(
				'hide_empty'    => false,
				'parent'        => $term->term_id,
			) ); ?>

			<div role="tabpanel" class="tab-pane <?php if ( $index == 0 ) : ?>active<?php endif; ?>" id="listing-categories-<?php echo esc_attr( $term->term_id ); ?>">
				<ul>
					<?php foreach ( $subterms as $subterm ) : ?>
						<li>
							<a href="<?php echo get_term_link( $subterm ); ?>">
								<?php echo esc_attr( $subterm->name ); ?>

								<?php if ( ! empty( $instance['show_count'] ) ) : ?>
									<span>(<?php echo esc_attr( $subterm->count ); ?>)</span>
								<?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div><!-- /.tabpanel -->

			<?php $index++; ?>
		<?php endforeach; ?>
	</div><!-- /.tab-content -->
<?php endif; ?>

</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
