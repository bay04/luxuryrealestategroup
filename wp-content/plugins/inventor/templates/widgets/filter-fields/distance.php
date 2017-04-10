<?php if ( empty( $instance['hide_distance'] ) ) : ?>
	<div class="form-group form-group-distance">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_distance"><?php echo __( 'Distance', 'inventor' ); ?></label>
		<?php endif; ?>

		<div class="input-group">
			<input type="number" name="distance"
			       min="0"
			       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Distance', 'inventor' ); ?>"<?php endif; ?>
			       class="form-control" value="<?php echo ! empty( $_GET['distance'] ) ? $_GET['distance'] : ''; ?>"
			       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_distance">
			<span class="input-group-addon">
				<?php echo get_theme_mod( 'inventor_measurement_distance_unit_long', 'mi' );?>
			</span>
		</div><!-- /.input-group -->
	</div><!-- /.form-group -->
<?php endif; ?>