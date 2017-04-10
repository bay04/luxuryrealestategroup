<?php if ( empty( $instance['hide_geolocation'] ) ) : ?>
	<div class="form-group form-group-geolocation">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_geolocations"><?php echo __( 'Location', 'inventor' ); ?></label>
		<?php endif; ?>

		<input type="text" name="geolocation"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Location', 'inventor' ); ?>"<?php endif; ?>
		       class="form-control form-control-geolocation" value="<?php echo ! empty( $_GET['geolocation'] ) ? $_GET['geolocation'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_geolocation">

		<?php $latitude = ! empty( $_GET['latitude'] ) ? $_GET['latitude'] : ( ! empty( $instance['latitude'] ) ? $instance['latitude'] : null ); ?>
		<?php $longitude = ! empty( $_GET['longitude'] ) ? $_GET['longitude'] : ( ! empty( $instance['longitude'] ) ? $instance['longitude'] : null ); ?>
		<input type="hidden" name="latitude" value="<?php if ( ! empty( $latitude ) ) : ?><?php echo esc_attr( $latitude ); ?><?php endif; ?>">
		<input type="hidden" name="longitude" value="<?php if ( ! empty( $longitude ) ) : ?><?php echo esc_attr( $longitude ); ?><?php endif; ?>">
	</div><!-- /.form-group -->
<?php endif; ?>