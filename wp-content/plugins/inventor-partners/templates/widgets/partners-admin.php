<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$description = ! empty( $instance['description'] ) ? $instance['description'] : '';
$count = ! empty( $instance['count'] ) ? $instance['count'] : 3;
$ids = ! empty( $instance['ids'] ) ? $instance['ids'] : '';
$per_row = ! empty( $instance['per_row'] ) ? $instance['per_row'] : 3;
$classes = ! empty( $instance['classes'] ) ? $instance['classes'] : '';
?>

<!-- TITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo __( 'Title', 'inventor-partners' ); ?>
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
		<?php echo __( 'Description', 'inventor-partners' ); ?>
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


<!-- IDs -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>">
		<?php echo __( 'IDs', 'inventor' ); ?>
	</label>

	<input  class="widefat"
			id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"
			name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>"
			type="text"
			value="<?php echo esc_attr( $ids ); ?>">
	<i><?php echo __( 'For specific partners please insert post ids, separated by comma. Example: 1,2,3', 'inventor-partners' ); ?></i>
</p>

<!-- PER ROW -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>">
		<?php echo __( 'Items per row', 'inventor-partners' ); ?>
	</label>

	<select id="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'per_row' ) ); ?>">
		<option value="1" <?php echo ( $per_row == '1' ) ? 'selected="selected"' : ''; ?>>1</option>
		<option value="2" <?php echo ( $per_row == '2' ) ? 'selected="selected"' : ''; ?>>2</option>
		<option value="3" <?php echo ( $per_row == '3' ) ? 'selected="selected"' : ''; ?>>3</option>
		<option value="4" <?php echo ( $per_row == '4' ) ? 'selected="selected"' : ''; ?>>4</option>
		<option value="5" <?php echo ( $per_row == '5' ) ? 'selected="selected"' : ''; ?>>5</option>
		<option value="6" <?php echo ( $per_row == '6' ) ? 'selected="selected"' : ''; ?>>6</option>
	</select>
</p>