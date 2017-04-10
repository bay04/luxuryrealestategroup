<?php
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels';
?>

<!-- BUTTON TEXT -->
<div class="filter-form-admin">
    <hr>

    <h4><?php echo __( 'Filter', 'inventor' ); ?></h4>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
            <?php echo esc_attr__( 'Button Text', 'inventor' ); ?>
        </label>

        <input  class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>"
                type="text"
                value="<?php echo esc_attr( $button_text ); ?>">
    </p>

    <!-- INPUT TITLES -->
    <label><h4><?php echo __( 'Input titles', 'inventor' ); ?></h4></label>

    <ul>
        <li>
            <label>
                <input  type="radio"
                        class="radio"
                        value="labels"
                    <?php echo ( empty( $input_titles ) || 'labels' == $input_titles ) ? 'checked="checked"' : ''; ?>
                        id="<?php echo esc_attr( $this->get_field_id( 'input_titles' ) ); ?>"
                        name="<?php echo esc_attr( $this->get_field_name( 'input_titles' ) ); ?>">
                <?php echo __( 'Labels', 'inventor' ); ?>
            </label>
        </li>

        <li>
            <label>
                <input  type="radio"
                        class="radio"
                        value="placeholders"
                    <?php echo ( 'placeholders' == $input_titles ) ? 'checked="checked"' : ''; ?>
                        id="<?php echo esc_attr( $this->get_field_id( 'input_titles' ) ); ?>"
                        name="<?php echo esc_attr( $this->get_field_name( 'input_titles' ) ); ?>">
                <?php echo __( 'Placeholders', 'inventor' ); ?>
            </label>
        </li>
    </ul>

    <?php include Inventor_Template_Loader::locate( 'widgets/filter-fields-admin' ); ?>
</div>
