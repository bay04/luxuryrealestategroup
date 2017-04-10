<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; ?>
<?php $count = ! empty( $instance['count'] ) ? $instance['count'] : 3; ?>
<?php $ids = ! empty( $instance['ids'] ) ? $instance['ids'] : ''; ?>
<?php $per_row = ! empty( $instance['per_row'] ) ? $instance['per_row'] : 1; ?>
<?php $order = ! empty( $instance['order'] ) ? $instance['order'] : ''; ?>
<?php $attribute = ! empty( $instance['attribute'] ) ? $instance['attribute'] : ''; ?>
<?php $similar_location = ! empty( $instance['similar_location'] ) ? $instance['similar_location'] : ''; ?>
<?php $similar_type = ! empty( $instance['similar_type'] ) ? $instance['similar_type'] : ''; ?>
<?php $similar_category = ! empty( $instance['similar_category'] ) ? $instance['similar_category'] : ''; ?>
<?php $similar_price = ! empty( $instance['similar_price'] ) ? $instance['similar_price'] : ''; ?>
<?php $display = ! empty( $instance['display'] ) ? $instance['display'] : ''; ?>
<?php $listing_categories = ! empty( $instance['listing_categories'] ) ? $instance['listing_categories'] : array(); ?>
<?php $listing_types = ! empty( $instance['listing_types'] ) ? $instance['listing_types'] : array(); ?>
<?php $locations = ! empty( $instance['locations'] ) ? $instance['locations'] : array(); ?>

<!-- TITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo __( 'Title', 'inventor' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $title ); ?>">
</p>

<!-- DESCRIPTION -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
		<?php echo __( 'Description', 'inventor' ); ?>
	</label>

	<textarea class="widefat"
	          rows="4"
	          id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
	          name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
</p>

<!-- COUNT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
		<?php echo __( 'Count', 'inventor' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $count ); ?>">
</p>


<!-- DISPLAY -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>">
		<?php echo __( 'Display as', 'inventor' ); ?>
	</label>

	<select id="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>"
			name="<?php echo esc_attr( $this->get_field_name( 'display' ) ); ?>">
		<option value="small" <?php echo ( 'small' == $display || empty( $display ) ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Small', 'inventor' ); ?></option>
		<option value="box" <?php echo ( 'box' == $display ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Box', 'inventor' ); ?></option>
		<option value="column" <?php echo ( 'column' == $display ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Column', 'inventor' ); ?></option>
		<option value="row" <?php echo ( 'row' == $display ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Row', 'inventor' ); ?></option>
		<option value="masonry" <?php echo ( 'masonry' == $display ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Masonry', 'inventor' ); ?></option>
		<option value="carousel" <?php echo ( 'carousel' == $display ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Carousel', 'inventor' ); ?></option>
	</select>
</p>

<!-- PER ROW -->
<p class="per-row">
	<label for="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>">
		<?php echo __( 'Items per row', 'inventor' ); ?>
	</label>

	<select id="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'per_row' ) ); ?>">
		<option value="1" <?php echo ( '1' == $per_row ) ? 'selected="selected"' : ''; ?>>1</option>
		<option value="2" <?php echo ( '2' == $per_row ) ? 'selected="selected"' : ''; ?>>2</option>
		<option value="3" <?php echo ( '3' == $per_row ) ? 'selected="selected"' : ''; ?>>3</option>
		<option value="4" <?php echo ( '4' == $per_row ) ? 'selected="selected"' : ''; ?>>4</option>
		<option value="5" <?php echo ( '5' == $per_row ) ? 'selected="selected"' : ''; ?>>5</option>
		<option value="6" <?php echo ( '6' == $per_row ) ? 'selected="selected"' : ''; ?>>6</option>
	</select>
</p>

<!-- Pickup -->
<p>
	<strong><?php echo __( 'Pickup', 'inventor' ); ?></strong>

	<?php
	$order_options = apply_filters( 'inventor_widget_listings_order_options', array(
		'rand'		=> __( 'Random', 'inventor' ),
		'ids'		=> __( 'IDs', 'inventor' ),
		'similar'	=> __( 'Similar with current listing', 'inventor' ),
	) );
	?>

	<ul>
		<li>
			<label>
				<input  type="radio"
				        class="radio"
						<?php echo ( empty( $order ) || 'on' == $order ) ? 'checked="checked"' : ''; ?>
				        id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
				        name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
				<?php echo __( 'Default', 'inventor' ); ?>
			</label>
		</li>

	<?php foreach( $order_options as $order_key => $order_title ): ?>
		<li>
			<label>
				<input  type="radio"
						class="radio"
						value="<?php echo $order_key; ?>"
					<?php echo ( $order_key == $order ) ? 'checked="checked"' : ''; ?>
						id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
						name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
				<?php echo $order_title; ?>
			</label>
		</li>
	<?php endforeach; ?>
	</ul>
</p>


<!-- IDs -->
<p class="ids">
	<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>">
		<?php echo __( 'IDs', 'inventor' ); ?>
	</label>

	<input  class="widefat"
			id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"
			name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>"
			type="text"
			value="<?php echo esc_attr( $ids ); ?>">
	<i><?php echo __( 'For specific listings please insert post ids, separated by comma. Example: 1,2,3', 'inventor' ); ?></i>
</p>

<!-- DISPLAY SORTING OPTIONS -->
<p class="similar-attributes">
	<strong><?php echo __( 'Similar attributes', 'inventor' ); ?></strong>

	<br><br>

	<label for="<?php echo esc_attr( $this->get_field_id( 'similar_location' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $similar_location ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'similar_location' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'similar_location' ) ); ?>">

		<?php echo __( 'Same location', 'inventor' ); ?>
	</label>

	<br>

	<label for="<?php echo esc_attr( $this->get_field_id( 'similar_type' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $similar_type ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'similar_type' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'similar_type' ) ); ?>">

		<?php echo __( 'Same type', 'inventor' ); ?>
	</label>

	<br>

	<label for="<?php echo esc_attr( $this->get_field_id( 'similar_category' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $similar_category ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'similar_category' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'similar_category' ) ); ?>">

		<?php echo __( 'Same category', 'inventor' ); ?>
	</label>

	<br>

	<label for="<?php echo esc_attr( $this->get_field_id( 'similar_price' ) ); ?>">
		<input 	type="checkbox"
				  <?php if ( ! empty( $similar_price ) ) : ?>checked="checked"<?php endif; ?>
				  name="<?php echo esc_attr( $this->get_field_name( 'similar_price' ) ); ?>"
				  id="<?php echo esc_attr( $this->get_field_id( 'similar_price' ) ); ?>">

		<?php echo __( 'Same price (+- 20%)', 'inventor' ); ?>
	</label>
</p>

<!-- ATTRIBUTE -->
<p>
	<strong><?php echo __( 'Attribute', 'inventor' ); ?></strong>

	<ul>
		<li>
			<label>
				<input  type="radio"
				        class="radio"
					<?php echo ( empty( $attribute ) || 'on' == $attribute ) ? 'checked="checked"' : ''; ?>
				        id="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>"
				        name="<?php echo esc_attr( $this->get_field_name( 'attribute' ) ); ?>">
				<?php echo __( 'None', 'inventor' ); ?>
			</label>
		</li>

		<li>
			<label>
				<input  type="radio"
				        class="radio"
				        value="featured"
					<?php echo ( 'featured' == $attribute ) ? 'checked="checked"' : ''; ?>
				        id="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>"
				        name="<?php echo esc_attr( $this->get_field_name( 'attribute' ) ); ?>">
				<?php echo __( 'Featured only', 'inventor' ); ?>
			</label>
		</li>

		<li>
			<label>
				<input  type="radio"
				        class="radio"
				        value="reduced"
					<?php echo ( 'reduced' == $attribute ) ? 'checked="checked"' : ''; ?>
				        id="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>"
				        name="<?php echo esc_attr( $this->get_field_name( 'attribute' ) ); ?>">

				<?php echo __( 'Reduced only', 'inventor' ); ?>
			</label>
		</li>
	</ul>
</p>

<!-- LISTING CATEGORIES  -->
<p>
	<strong><?php echo __( 'Listing Categories', 'inventor' ); ?></strong>
</p>

<p>
	<select id="<?php echo esc_attr( $this->get_field_id( 'listing_categories' ) ); ?>" style="width: 100%;"
	        multiple="multiple"
	        name="<?php echo esc_attr( $this->get_field_name( 'listing_categories' ) ); ?>[]">
		<?php $terms = get_terms( 'listing_categories', array( 'hide_empty' => false ) ); ?>

		<?php if ( is_array( $terms ) ) : ?>
			<?php foreach ( $terms as $term ) : ?>
				<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php if ( in_array( $term->term_id, $listing_categories ) ) : ?>selected="selected"<?php endif; ?>><?php echo esc_attr( $term->name ); ?></option>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>
</p>


<!-- LISTING TYPES  -->
<p>
	<strong><?php echo __( 'Types', 'inventor' ); ?></strong>
</p>

<p>
	<select id="<?php echo esc_attr( $this->get_field_id( 'listing_types' ) ); ?>" style="width: 100%;"
	        multiple="multiple"
	        name="<?php echo esc_attr( $this->get_field_name( 'listing_types' ) ); ?>[]">
		<?php $types = Inventor_Post_types::get_listing_post_types(); ?>

		<?php if ( is_array( $types ) ) : ?>			
			<?php foreach ( $types as $type ) : ?>
				<?php $obj = get_post_type_object( $type ); ?>
				<option value="<?php echo esc_attr( $type ); ?>" <?php if ( in_array( $type, $listing_types ) ) : ?>selected="selected"<?php endif; ?>>
					<?php echo esc_attr( $obj->labels->name ); ?>
				</option>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>
</p>

<!-- LOCATIONS  -->
<p>
	<strong><?php echo __( 'Locations', 'inventor' ); ?></strong>
</p>

<p>
	<select id="<?php echo esc_attr( $this->get_field_id( 'locations' ) ); ?>" style="width: 100%;"
	        multiple="multiple"
	        name="<?php echo esc_attr( $this->get_field_name( 'locations' ) ); ?>[]">
		<?php $terms = get_terms( 'locations', array( 'hide_empty' => false ) ); ?>

		<?php if ( is_array( $terms ) ) : ?>
			<?php foreach ( $terms as $term ) : ?>
				<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php if ( in_array( $term->term_id, $locations ) ) : ?>selected="selected"<?php endif; ?>><?php echo esc_attr( $term->name ); ?></option>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>
</p>