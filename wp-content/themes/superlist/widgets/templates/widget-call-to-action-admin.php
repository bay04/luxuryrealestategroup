<?php
/**
 * Widget template
 *
 * @package Superlist
 * @subpackage Widgets/Templates
 */

$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$button_link = ! empty( $instance['button_link'] ) ? $instance['button_link'] : '';
?>

<!-- TEXT -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>">
        <?php echo esc_attr__( 'Text', 'superlist' ); ?>
    </label>

    <textarea  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"
            rows="4"
        ><?php echo esc_attr( $text ); ?></textarea>
</p>

<!-- BUTTON TEXT -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
        <?php echo esc_attr__( 'Button Text', 'superlist' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $button_text ); ?>">
</p>

<!-- BUTTON LINK -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>">
        <?php echo esc_attr__( 'Button Link', 'superlist' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $button_link ); ?>">
</p>
