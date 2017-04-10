<?php
$ids = ! empty( $instance['ids'] ) ? $instance['ids'] : '';
$height = ! empty( $instance['height'] ) ? $instance['height'] : '500px';
$fullscreen = ! empty( $instance['fullscreen'] ) ? $instance['fullscreen'] : false;
$size = ! empty( $instance['size'] ) ? $instance['size'] : 'thumbnail';
$classes = ! empty( $instance['classes'] ) ? $instance['classes'] : '';
$show_arrows = ! empty( $instance['show_arrows'] ) ? $instance['show_arrows'] : '';
$disable_dots = ! empty( $instance['disable_dots'] ) ? $instance['disable_dots'] : '';
$autoplay = ! empty( $instance['autoplay'] ) ? $instance['autoplay'] : '';
$autoplay_timeout = ! empty( $instance['autoplay_timeout'] ) ? $instance['autoplay_timeout'] : '';
?>

<!-- IDS -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>">
		<?php echo __( 'IDs', 'inventor-listing-slider' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $ids ); ?>">
	<br>
	<small><?php echo __( 'Listing IDs, separated by commas.', 'inventor-listing-slider' ); ?></small>
</p>

<!-- CLASSES -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'classes' ) ); ?>">
		<?php echo __( 'Classes', 'inventor-listing-slider' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'classes' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'classes' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $classes ); ?>">
	<br>
	<small><?php echo __( 'Additional classes appended to body class and separated by , e.g. <i>header-transparent, listing-slider-append-top</i>', 'inventor-listing-slider' ); ?></small>
</p>

<!-- HEIGHT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">
		<?php echo __( 'Container height', 'inventor-listing-slider' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $height ); ?>">
	<br>
	<small><?php echo __( 'Default value 500px.', 'inventor-listing-slider' ); ?></small>
</p>

<!-- FULLSCREEN -->
<p>
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $fullscreen ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'fullscreen' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'fullscreen' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'fullscreen' ) ); ?>">
		<?php echo __( 'Fullscreen', 'inventor-listing-slider' ); ?>
	</label>
</p>

<!-- SIZE -->
<?php $sizes = get_intermediate_image_sizes(); ?>

<?php if ( ! empty( $sizes ) ) : ?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>">
			<?php echo __( 'Thumbnail size', 'inventor-listing-slider' ); ?>
		</label>

		<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>">
			<?php foreach ( $sizes as $thumb_size ) : ?>
				<option value="<?php echo esc_attr( $thumb_size ); ?>" <?php echo ( $size == $thumb_size ) ? 'selected="selected"' : ''; ?>>
					<?php echo esc_attr( $thumb_size ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>
<?php endif; ?>

<!-- SHOW ARROWS -->
<p>
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $show_arrows ) ? 'checked="checked"' : ''; ?>
	        id="<?php echo esc_attr( $this->get_field_id( 'show_arrows' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'show_arrows' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'show_arrows' ) ); ?>">
		<?php echo __( 'Show arrows', 'inventor-listing-slider' ); ?>
	</label>
</p>

<!-- AUTOPLAY -->
<p>
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $autoplay ) ? 'checked="checked"' : ''; ?>
	        id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>">
		<?php echo __( 'Autoplay', 'inventor-listing-slider' ); ?>
	</label>
</p>

<!-- AUTOPLAY TIMEOUT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay_timeout' ) ); ?>">
		<?php echo __( 'Autoplay timeout', 'inventor-listing-slider' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'autoplay_timeout' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'autoplay_timeout' ) ); ?>"
			type="number"
			step="1"
	        value="<?php echo esc_attr( $autoplay_timeout ); ?>">
	<br>
	<small><?php echo __( 'Default value 2000.', 'inventor-listing-slider' ); ?></small>
</p>