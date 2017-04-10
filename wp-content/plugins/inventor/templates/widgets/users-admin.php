<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; ?>
<?php $count = ! empty( $instance['count'] ) ? $instance['count'] : 3; ?>
<?php $type = ! empty( $instance['type'] ) ? $instance['type'] : 1; ?>
<?php $order = ! empty( $instance['order'] ) ? $instance['order'] : ''; ?>
<?php $display = ! empty( $instance['display'] ) ? $instance['display'] : ''; ?>

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
    </select>
</p>

<!-- TYPE -->
<p class="type">
    <label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>">
        <?php echo __( 'Type', 'inventor' ); ?>
    </label>

    <select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
        <option value="author" <?php echo ( 'author' == $type || empty( $type ) ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Authors', 'inventor' ); ?></option>
        <option value="all" <?php echo ( 'all' == $type ) ? 'selected="selected"' : ''; ?>><?php echo __( 'All', 'inventor' ); ?></option>
    </select>
</p>


<!-- Pickup -->
<p>
    <strong><?php echo __( 'Order', 'inventor' ); ?></strong>

<ul>
    <li>
        <label>
            <input  type="radio"
                    class="radio"
                    value="registered"
                <?php echo ( empty( $order ) || 'registered' == $order ) ? 'checked="checked"' : ''; ?>
                    id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
            <?php echo __( 'Registration date', 'inventor' ); ?>
        </label>
    </li>

    <li>
        <label>
            <input  type="radio"
                    class="radio"
                    value="post_count"
                <?php echo ( 'post_count' == $order ) ? 'checked="checked"' : ''; ?>
                    id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
            <?php echo __( 'Post count', 'inventor' ); ?>
        </label>
    </li>
</ul>
</p>