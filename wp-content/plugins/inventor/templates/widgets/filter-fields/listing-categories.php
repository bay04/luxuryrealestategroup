<?php if ( empty( $instance['hide_category'] ) ) : ?>
    <div class="form-group form-group-listing-categories">
        <?php if ( 'labels' == $input_titles ) : ?>
            <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_listing_categories"><?php echo __( 'Category', 'inventor' ); ?></label>
        <?php endif; ?>

        <?php $categories = get_terms( 'listing_categories', array(
            'hide_empty' 	=> false,
        ) ); ?>

        <select class="form-control"
                name="listing_categories"
                data-size="10"
                <?php if ( count( $categories ) > 10 ) : ?>data-live-search="true"<?php endif;?>
                id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_listing_categories">
            <option value="">
                <?php if ( 'placeholders' == $input_titles ) : ?>
                    <?php echo __( 'Category', 'inventor' ); ?>
                <?php else : ?>
                    <?php echo __( 'All categories', 'inventor' ); ?>
                <?php endif; ?>
            </option>

            <?php global $wp_query; ?>
            <?php $selected = empty( $_GET['listing_categories'] ) ? null : $_GET['listing_categories']; ?>
            <?php $parent = is_tax('listing_categories') ? $wp_query->queried_object : null; ?>
            <?php $post_type = is_post_type_archive() && $wp_query->queried_object->name != 'listing' ? $wp_query->queried_object->name : null; ?>
            <?php $options = Inventor_Utilities::build_hierarchical_taxonomy_select_options( 'listing_categories', $selected, $parent, 1, false, $post_type ); ?>
            <?php echo $options; ?>
        </select>
    </div><!-- /.form-group -->
<?php endif; ?>
