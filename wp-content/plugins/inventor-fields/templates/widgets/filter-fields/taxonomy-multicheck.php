<div class="form-group <?php echo esc_attr( $field_id ); ?>">
    <?php if ( 'labels' == $input_titles ) : ?>
        <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>"><?php echo get_the_title( $field->ID ); ?></label>
    <?php endif; ?>

    <?php $taxonomy = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'taxonomy', true ); ?>
    <?php $terms = get_terms( $taxonomy, array( 'hide_empty' => false ) ); ?>
    <?php $empty_label = 'placeholders' == $input_titles ? get_the_title( $field->ID ) : __( 'All values', 'inventor-fields' ); ?>

    <select multiple class="form-control"
            name="<?php echo esc_attr( $field_id ); ?>[]"
            data-size="10"
            data-empty-label="<?php echo $empty_label; ?>"
            <?php if ( count( $terms ) > 10 ) : ?>data-live-search="true"<?php endif;?>
            id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>">
        <option value=""><?php echo $empty_label ?></option>

        <?php global $wp_query; ?>
        <?php $selected = empty( $_GET[ $field_id ] ) ? array() : $_GET[ $field_id ]; ?>
        <?php //$parent = is_tax( $taxonomy ) ? $wp_query->queried_object : null; ?>
        <?php $parent = null; ?>
        <?php $options = Inventor_Utilities::build_hierarchical_taxonomy_select_options( $taxonomy, $selected, $parent ); ?>
        <?php echo $options; ?>

    </select>
</div><!-- /.form-group -->