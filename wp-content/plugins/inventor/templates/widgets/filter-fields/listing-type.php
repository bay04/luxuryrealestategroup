<?php if ( empty( $instance['hide_listing_type'] ) ) : ?>
    <div class="form-group form-group-listing-type">
        <?php if ( 'labels' == $input_titles ) : ?>
            <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_listing_types"><?php echo __( 'Listing type', 'inventor' ); ?></label>
        <?php endif; ?>

        <?php $listing_types = Inventor_Post_Types::get_listing_post_types(); ?>

        <select class="form-control"
                name="listing_types"
                data-size="10"
                <?php if ( count( $listing_types ) > 10 ) : ?>data-live-search="true"<?php endif;?>
                id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_listing_types">
            <option value="">
                <?php if ( 'placeholders' == $input_titles ) : ?>
                    <?php echo __( 'Listing type', 'inventor' ); ?>
                <?php else : ?>
                    <?php echo __( 'All listing types', 'inventor' ); ?>
                <?php endif; ?>
            </option>

            <?php if ( is_array( $listing_types ) ) : ?>
                <?php foreach ( $listing_types as $listing_type ) : ?>
                    <?php $obj = get_post_type_object( $listing_type ); ?>
                    <option value="<?php echo $listing_type ?>" <?php if ( ! empty( $_GET['listing_types'] ) && $_GET['listing_types'] == $listing_type ) : ?>selected="selected"<?php endif; ?>><?php echo esc_attr( $obj->labels->singular_name ); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div><!-- /.form-group -->
<?php endif; ?>
