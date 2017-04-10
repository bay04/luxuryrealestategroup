<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$latitude = ! empty( $instance['latitude'] ) ? $instance['latitude'] : 37.439826;
$longitude = ! empty( $instance['longitude'] ) ? $instance['longitude'] : -122.132088;
$zoom = ! empty( $instance['zoom'] ) ? $instance['zoom'] : 11;
$max_pins = ! empty( $instance['max_pins'] ) ? $instance['max_pins'] : '';
$grid_size = ! empty( $instance['grid_size'] ) ? $instance['grid_size'] : 60;
$style = ! empty( $instance['style'] ) ? $instance['style'] : '';
$height = ! empty( $instance['height'] ) ? $instance['height'] : '400px';
$classes = ! empty( $instance['classes'] ) ? $instance['classes'] : '';
$body_classes = ! empty( $instance['body_classes'] ) ? $instance['body_classes'] : '';
$show_all_markers = ! empty( $instance['show_all_markers'] ) ? $instance['show_all_markers'] : '';
$show_toggle = ! empty( $instance['show_toggle'] ) ? $instance['show_toggle'] : '';
$toggle_default = ! empty( $instance['toggle_default'] ) ? $instance['toggle_default'] : '';
$intercept_filter = ! empty( $instance['intercept_filter'] ) ? $instance['intercept_filter'] : '';
$intercept_term = ! empty( $instance['intercept_term'] ) ? $instance['intercept_term'] : '';
$intercept_post_type = ! empty( $instance['intercept_post_type'] ) ? $instance['intercept_post_type'] : '';
$geolocation = ! empty( $instance['geolocation'] ) ? $instance['geolocation'] : '';
$filter = ! empty( $instance['filter'] ) ? $instance['filter'] : '';
$live_filtering = ! empty( $instance['live_filtering'] ) ? $instance['live_filtering'] : '';
$auto_submit_filter = ! empty( $instance['auto_submit_filter'] ) ? $instance['auto_submit_filter'] : '';
$marker_style = ! empty( $instance['marker_style'] ) ? $instance['marker_style'] : 'simple';
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels';
$orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$sort = ! empty( $instance['sort'] ) ? $instance['sort'] : '';

$map_types = ! empty( $instance['map_types'] ) ? $instance['map_types'] : '';
$map_zoom = ! empty( $instance['map_zoom'] ) ? $instance['map_zoom'] : '';
$map_geolocation = ! empty( $instance['map_geolocation'] ) ? $instance['map_geolocation'] : '';
?>

<!-- TITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo __( 'Title', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $title ); ?>">
</p>

<!-- LATITUDE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>">
		<?php echo __( 'Latitude', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'latitude' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $latitude ); ?>">
</p>

<!-- LONGITUDE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>">
		<?php echo __( 'Longitude', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'longitude' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $longitude ); ?>">
</p>


<!-- ZOOM -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'max_pins' ) ); ?>">
		<?php echo __( 'Max. pins', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'max_pins' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'max_pins' ) ); ?>"
	        type="number"
	        min="0"
	        value="<?php echo esc_attr( $max_pins ); ?>">
</p>

<!-- ZOOM -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>">
		<?php echo __( 'Zoom', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'zoom' ) ); ?>"
	        type="number"
            min="0"
	        value="<?php echo esc_attr( $zoom ); ?>">
</p>

<!-- GRID SIZE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'grid_size' ) ); ?>">
		<?php echo __( 'Grid size', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'grid_size' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'grid_size' ) ); ?>"
            type="number"
            step="5"
	        value="<?php echo esc_attr( $grid_size ); ?>">
</p>

<!-- HEIGHT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">
		<?php echo __( 'Height', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $height ); ?>">
</p>

<!-- CLASSES -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'classes' ) ); ?>">
		<?php echo __( 'Classes', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'classes' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'classes' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $classes ); ?>">
</p>

<!-- CLASSES -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'body_classes' ) ); ?>">
		<?php echo __( 'Body Classes', 'inventor-google-map' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'body_classes' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'body_classes' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $body_classes ); ?>">
	<br>
	<small><?php echo __( 'Additional classes appended to body class (separated by comma)', 'inventor-google-map' ); ?></small>
</p>

<!-- STYLE-->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>">
		<?php echo __( 'Style', 'inventor-google-map' ); ?>
	</label>

	<select id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
		<option value=""><?php echo __( 'Default', 'inventor-google-map' ); ?></option>
		<?php $maps = Inventor_Google_Map_Styles::styles(); ?>
		<?php if ( is_array( $maps ) ) : ?>
			<?php foreach ( $maps as $map ) :   ?>
				<option <?php if ( $style == $map['slug'] ) : ?>selected="selected"<?php endif; ?>value="<?php echo esc_attr( $map['slug'] ); ?>"><?php echo esc_html( $map['title'] ); ?></option>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>
</p>

<!-- TOGGLE DEFAULT  -->
<h4><?php echo esc_attr__( 'Toggle default state', 'inventor-google-map' ); ?></h4>

<ul>
	<li>
		<label>
			<input  type="radio"
			        class="radio"
			        value="open"
				<?php echo ( empty( $toggle_default ) || 'open' == $toggle_default ) ? 'checked="checked"' : ''; ?>
				    id="<?php echo esc_attr( $this->get_field_id( 'toggle_default' ) ); ?>"
				    name="<?php echo esc_attr( $this->get_field_name( 'toggle_default' ) ); ?>">
			<?php echo __( 'Open', 'inventor-google-map' ); ?>
		</label>
	</li>

	<li>
		<label>
			<input  type="radio"
			        class="radio"
			        value="closed"
				<?php echo ( 'closed' == $toggle_default ) ? 'checked="checked"' : ''; ?>
				    id="<?php echo esc_attr( $this->get_field_id( 'toggle_default' ) ); ?>"
				    name="<?php echo esc_attr( $this->get_field_name( 'toggle_default' ) ); ?>">
			<?php echo __( 'Closed', 'inventor-google-map' ); ?>
		</label>
	</li>
</ul>

<!-- INTERCEPT -->
<h4><?php echo __( 'Intercept', 'inventor-google-map' ); ?></h4>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'intercept_filter' ) ); ?>">
		<input 	type="checkbox"
		          <?php if ( ! empty( $intercept_filter ) ) : ?>checked="checked"<?php endif; ?>
		          name="<?php echo esc_attr( $this->get_field_name( 'intercept_filter' ) ); ?>"
		          id="<?php echo esc_attr( $this->get_field_id( 'intercept_filter' ) ); ?>">

		<?php echo __( 'Filter queries in URL', 'inventor-google-map' ); ?>
	</label>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'intercept_post_type' ) ); ?>">
		<input 	type="checkbox"
		          <?php if ( ! empty( $intercept_post_type ) ) : ?>checked="checked"<?php endif; ?>
		          name="<?php echo esc_attr( $this->get_field_name( 'intercept_post_type' ) ); ?>"
		          id="<?php echo esc_attr( $this->get_field_id( 'intercept_post_type' ) ); ?>">

		<?php echo __( 'Main post type in loop', 'inventor-google-map' ); ?>
	</label>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'intercept_term' ) ); ?>">
		<input 	type="checkbox"
		          <?php if ( ! empty( $intercept_term ) ) : ?>checked="checked"<?php endif; ?>
		          name="<?php echo esc_attr( $this->get_field_name( 'intercept_term' ) ); ?>"
		          id="<?php echo esc_attr( $this->get_field_id( 'intercept_term' ) ); ?>">

		<?php echo __( 'Main term in loop', 'inventor-google-map' ); ?>
	</label>
</p>

<h4><?php echo __( 'Toolbar', 'inventor-google-map' ); ?></h4>

<!-- MAP TYPES -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'map_types' ) ); ?>">
		<input 	type="checkbox"
		          <?php if ( ! empty( $map_types ) ) : ?>checked="checked"<?php endif; ?>
		          name="<?php echo esc_attr( $this->get_field_name( 'map_types' ) ); ?>"
		          id="<?php echo esc_attr( $this->get_field_id( 'map_types' ) ); ?>">

		<?php echo __( 'Map types', 'inventor-google-map' ); ?>
	</label>
</p>

<!-- ZOOM -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'map_zoom' ) ); ?>">
		<input 	type="checkbox"
		          <?php if ( ! empty( $map_zoom ) ) : ?>checked="checked"<?php endif; ?>
		          name="<?php echo esc_attr( $this->get_field_name( 'map_zoom' ) ); ?>"
		          id="<?php echo esc_attr( $this->get_field_id( 'map_zoom' ) ); ?>">

		<?php echo __( 'Zoom', 'inventor-google-map' ); ?>
	</label>
</p>

<!-- GEOLOCATION -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'map_geolocation' ) ); ?>">
		<input 	type="checkbox"
		          <?php if ( ! empty( $map_geolocation ) ) : ?>checked="checked"<?php endif; ?>
		          name="<?php echo esc_attr( $this->get_field_name( 'map_geolocation' ) ); ?>"
		          id="<?php echo esc_attr( $this->get_field_id( 'map_geolocation' ) ); ?>">

		<?php echo __( 'Geolocation', 'inventor-google-map' ); ?>
	</label>
</p>

<!-- MARKER STYLE -->

<h4><?php echo __( 'Marker style', 'inventor-google-map' ); ?></h4>

<ul>
	<li>
		<label>
			<input  type="radio"
			        class="radio"
			        value="simple"
				<?php echo ( empty( $marker_style ) || 'simple' == $marker_style ) ? 'checked="checked"' : ''; ?>
			        id="<?php echo esc_attr( $this->get_field_id( 'marker_style' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'marker_style' ) ); ?>">
			<?php echo __( 'Simple', 'inventor-google-map' ); ?>
		</label>
	</li>

	<li>
		<label>
			<input  type="radio"
					class="radio"
					value="inventor-poi"
				<?php echo ( 'inventor-poi' == $marker_style ) ? 'checked="checked"' : ''; ?>
					id="<?php echo esc_attr( $this->get_field_id( 'marker_style' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'marker_style' ) ); ?>">
			<?php echo __( 'Inventor POI', 'inventor-google-map' ); ?>
		</label>
	</li>

	<li>
		<label>
			<input  type="radio"
					class="radio"
					value="thumbnail"
				<?php echo ( 'thumbnail' == $marker_style ) ? 'checked="checked"' : ''; ?>
					id="<?php echo esc_attr( $this->get_field_id( 'marker_style' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'marker_style' ) ); ?>">
			<?php echo __( 'Thumbnail', 'inventor-google-map' ); ?>
		</label>
	</li>
</ul>

<!-- ORDER BY-->

<h4><?php echo __( 'Order by', 'inventor-google-map' ); ?></h4>

<ul>
	<li>
		<label>
			<input  type="radio"
					class="radio"
				<?php echo ( empty( $orderby ) || 'on' == $orderby ) ? 'checked="checked"' : ''; ?>
					id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
			<?php echo __( 'Default', 'inventor-google-map' ); ?>
		</label>
	</li>

	<li>
		<label>
			<input  type="radio"
					class="radio"
					value="rand"
				<?php echo ( 'rand' == $orderby ) ? 'checked="checked"' : ''; ?>
					id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
			<?php echo __( 'Random', 'inventor-google-map' ); ?>
		</label>
	</li>
</ul>

<h4><?php echo __( 'Options', 'inventor-google-map' ); ?></h4>

<!-- SHOW ALL MARKERS -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'show_all_markers' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $show_all_markers ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'show_all_markers' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'show_all_markers' ) ); ?>">

		<?php echo __( 'Show all markers on viewport', 'inventor-google-map' ); ?>
	</label>
</p>

<!-- SHOW TOGGLE  -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'show_toggle' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $show_toggle ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'show_toggle' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'show_toggle' ) ); ?>">

		<?php echo __( 'Show toggle (open/close map)', 'inventor-google-map' ); ?>
	</label>
</p>

<!-- GEOLOCATION -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'geolocation' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $geolocation ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'geolocation' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'geolocation' ) ); ?>">

		<?php echo __( 'Current Position', 'inventor-google-map' ); ?>
	</label>
</p>

<!-- LIVE FILTERING -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'live_filtering' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $live_filtering ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'live_filtering' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'live_filtering' ) ); ?>">

		<?php echo __( 'Live Filtering', 'inventor-google-map' ); ?>
	</label>
</p>

<!-- AUTO SUBMIT FILTER -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'auto_submit_filter' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $auto_submit_filter ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'auto_submit_filter' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'auto_submit_filter' ) ); ?>">

		<?php echo __( 'Auto Submit Filter', 'inventor-google-map' ); ?>
	</label>
</p>

<?php if ( class_exists( 'Inventor' ) ) : ?>
	<!-- FILTER -->
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>">
			<input 	type="checkbox"
					  data-rel="inventor-filter"
					  <?php if ( ! empty( $filter ) ) : ?>checked="checked"<?php endif; ?>
					  name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>"
					  id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>">

			<?php echo esc_attr__( 'Filter', 'inventor-ui-kit' ); ?>
		</label>
	</p>

	<?php include Inventor_Template_Loader::locate( 'widgets/filter-form-admin' ); ?>
<?php endif; ?>