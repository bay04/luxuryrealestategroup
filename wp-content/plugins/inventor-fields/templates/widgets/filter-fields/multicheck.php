<div class="form-group <?php echo esc_attr( $field_id ); ?>">
    <?php if ( 'labels' == $input_titles ) : ?>
        <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>"><?php echo get_the_title( $field->ID ); ?></label>
    <?php endif; ?>

    <?php $options = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'options', true ); ?>
    <?php $options = explode( ',', $options ); ?>
    <?php $options = array_map( 'trim', $options );  // remove empty spaces ?>
    <?php $empty_label = 'placeholders' == $input_titles ? get_the_title( $field->ID ) : __( 'All values', 'inventor-fields' ); ?>

    <select multiple class="form-control"
            name="<?php echo esc_attr( $field_id ); ?>[]"
            data-size="10"
            data-empty-label="<?php echo $empty_label; ?>"
            <?php if ( count( $options ) > 10 ) : ?>data-live-search="true"<?php endif;?>
            id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>">
        <option value=""><?php echo $empty_label ?></option>

        <?php global $wp_query; ?>
        <?php $selected = empty( $_GET[ $field_id ] ) ? array() : $_GET[ $field_id ]; ?>

        <?php $choices = ''; ?>
        <?php foreach ( $options as $option ): ?>
            <?php if ( $option != '' ): ?>
                <?php $choices .= sprintf( "\t" . '<option value="%s" %s>%s</option>', $option, selected( true, in_array( $option, $selected ), false ), $option ) . "\n"; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php echo $choices; ?>

    </select>
</div><!-- /.form-group -->