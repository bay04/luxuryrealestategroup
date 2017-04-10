<?php if ( empty( $instance['hide_description'] ) ) : ?>
	<div class="form-group form-group-description">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_description"><?php echo __( 'Description', 'inventor' ); ?></label>
		<?php endif; ?>

		<input type="text" name="description"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Description', 'inventor' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['description'] ) ? $_GET['description'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_description">
	</div><!-- /.form-group -->
<?php endif; ?>