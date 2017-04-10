<?php if ( empty( $instance['hide_reduced'] ) ) : ?>
	<div class="form-group form-group-reduced">
		<div class="checkbox">
			<label for="<?php echo esc_attr( $args['widget_id'] ); ?>_reduced">
				<input type="checkbox" name="reduced" <?php echo ! empty( $_GET['reduced'] ) ? 'checked' : ''; ?> id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_reduced">
				<?php echo __( 'Reduced', 'inventor' ); ?>
			</label>
		</div><!-- /.checkbox -->
	</div><!-- /.form-group -->
<?php endif; ?>