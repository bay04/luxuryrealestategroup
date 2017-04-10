<div class="form-group <?php echo esc_attr( $field_id ); ?>">
    <div class="checkbox">
        <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>">
            <input type="checkbox" name="<?php echo esc_attr( $field_id ); ?>" <?php echo ! empty( $_GET[ $field_id ] ) ? 'checked' : ''; ?> id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>">
            <?php echo get_the_title( $field->ID ); ?>
        </label>
    </div><!-- /.checkbox -->
</div><!-- /.form-group -->