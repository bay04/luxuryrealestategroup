<?php if ( empty( $instance['hide_title'] ) ) : ?>
	<div class="form-group form-group-title">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_title"><?php echo __( 'Title', 'inventor' ); ?></label>
		<?php endif; ?>

		<input type="text" name="title"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Title', 'inventor' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['title'] ) ? $_GET['title'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_title">
	</div><!-- /.form-group -->
<?php endif; ?>