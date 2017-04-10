<?php $icons = apply_filters( 'inventor_poi_icons', array() ); ?>

<table class="inventor-dashboard-listings-counts">
    <tr>
        <th class="listing-type"><?php echo __( 'Listing type', 'inventor' ); ?></th>
        <th class="pending"><?php echo __( 'Pending', 'inventor' ); ?></th>
        <th class="draft"><?php echo __( 'Draft', 'inventor' ); ?></th>
        <th class="publish"><?php echo __( 'Published', 'inventor' ); ?></th>
        <th class="total"><?php echo __( 'Total', 'inventor' ); ?></th>
    </tr>

    <?php foreach ( $listings as $name => $data ): ?>
    <tr>
        <td class="listing-type">
            <?php $post_type_object = get_post_type_object( $name ); ?>
            <?php $icon = ! empty( $post_type_object->labels->icon ) && array_key_exists( $post_type_object->labels->icon, $icons ) ? $icons[ $post_type_object->labels->icon ] : null; ?>

            <?php if ( ! empty( $icon ) ) : ?>
                <?php echo $icon; ?>
            <?php endif; ?>

            <?php echo $data[ 'title' ]; ?>
        </td>

        <?php foreach ( array( 'pending', 'draft', 'publish', 'total' ) as $status ): ?>
            <?php $count = $data[ $status ]; ?>

            <td class="<?php echo $status; ?>">
                <?php if( $count == 0 ):?>
                    <?php echo $count; ?>
                <?php else: ?>
                    <?php $url = admin_url( 'edit.php?post_status='. $status .'&post_type=' . $name ); ?>
                    <a href="<?php echo $url; ?>">
                        <?php echo $count; ?>
                    </a>
                <?php endif; ?>
            </td>
        <?php endforeach; ?>
    </tr>
<?php endforeach; ?>
</table>
