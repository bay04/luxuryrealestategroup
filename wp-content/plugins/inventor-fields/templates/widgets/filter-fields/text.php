<?php $attributes = empty( $field_settings['attributes'] ) ? array() : $field_settings['attributes']; ?>

<div class="form-group <?php echo esc_attr( $field_id ); ?>">
    <?php if ( 'labels' == $input_titles ) : ?>
        <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>"><?php echo get_the_title( $field->ID ); ?></label>
    <?php endif; ?>

    <input class="form-control"
           name="<?php echo esc_attr( $field_id ); ?>"
           <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo get_the_title( $field->ID ) ?>"<?php endif; ?>
           type="<?php echo empty( $attributes['type'] ) ? 'text' : esc_attr( $attributes['type'] ); ?>"
           <?php if ( isset( $attributes['pattern'] ) ) : ?>pattern="<?php echo esc_attr( $attributes['pattern'] ); ?>"<?php endif; ?>
           <?php if ( isset( $attributes['step'] ) ) : ?>step="<?php echo esc_attr( $attributes['step'] ); ?>"<?php endif; ?>
           <?php if ( isset( $attributes['min'] ) ) : ?>min="<?php echo esc_attr( $attributes['min'] ); ?>"<?php endif; ?>
           value="<?php echo ! empty( $_GET[ $field_id ] ) ? $_GET[ $field_id ] : ''; ?>"
           id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>">
</div><!-- /.form-group -->