<?php if ( empty( $instance['hide_featured'] ) ) : ?>
	<div class="form-group form-group-featured">
		<div class="checkbox">			
			<label for="<?php echo esc_attr( $args['widget_id'] ); ?>_featured">
				<input type="checkbox" name="featured" <?php echo ! empty( $_GET['featured'] ) ? 'checked' : ''; ?> id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_featured">

				<?php echo __( 'Featured', 'inventor' ); ?>
			</label>
		</div><!-- /.checkbox -->
	</div><!-- /.form-group -->
<?php endif; ?>