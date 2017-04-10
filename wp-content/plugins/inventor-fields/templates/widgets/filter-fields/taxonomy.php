<div class="form-group <?php echo esc_attr( $field_id ); ?>">
    <?php if ( 'labels' == $input_titles ) : ?>
        <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>"><?php echo get_the_title( $field->ID ); ?></label>
    <?php endif; ?>

    <?php $taxonomy = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'taxonomy', true ); ?>

    <?php $terms = get_terms( $taxonomy, array(
        'hide_empty'    => false,
    ) ); ?>

    <select class="form-control"
            name="<?php echo esc_attr( $field_id ); ?>"
            data-size="10"
            <?php if ( count( $terms ) > 10 ) : ?>data-live-search="true"<?php endif;?>
            id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $field_id ); ?>">
        <option value="">
            <?php if ( 'placeholders' == $input_titles ) : ?>
                <?php echo get_the_title( $field->ID ); ?>
            <?php else : ?>
                <?php echo __( 'All values', 'inventor-fields' ); ?>
            <?php endif; ?>
        </option>

        <?php global $wp_query; ?>
        <?php $selected = empty( $_GET[ $field_id ] ) ? null : $_GET[ $field_id ]; ?>
        <?php //$parent = is_tax( $taxonomy ) ? $wp_query->queried_object : null; ?>
        <?php $parent = null; ?>
        <?php $options = Inventor_Utilities::build_hierarchical_taxonomy_select_options( $taxonomy, $selected, $parent ); ?>
        <?php echo $options; ?>

    </select>
</div><!-- /.form-group -->