<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; ?>
<?php $per_row = ! empty( $instance['per_row'] ) ? $instance['per_row'] : 4; ?>

<!-- TITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo __( 'Title', 'inventor-pricing' ); ?>
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
		<?php echo __( 'Description', 'inventor-pricing' ); ?>
	</label>

	<textarea class="widefat"
	          rows="4"
	          id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
	          name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
</p>

<!-- PER ROW -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>">
		<?php echo __( 'Items per row', 'inventor-pricing' ); ?>
	</label>

	<select id="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'per_row' ) ); ?>">
		<option value="1" <?php echo ( $per_row == '1' ) ? 'selected="selected"' : ''; ?>>1</option>
		<option value="2" <?php echo ( $per_row == '2' ) ? 'selected="selected"' : ''; ?>>2</option>
		<option value="3" <?php echo ( $per_row == '3' ) ? 'selected="selected"' : ''; ?>>3</option>
		<option value="4" <?php echo ( $per_row == '4' ) ? 'selected="selected"' : ''; ?>>4</option>
		<option value="5" <?php echo ( $per_row == '5' ) ? 'selected="selected"' : ''; ?>>5</option>
	</select>
</p>