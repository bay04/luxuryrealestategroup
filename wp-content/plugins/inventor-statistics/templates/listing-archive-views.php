<?php $views = get_post_meta( $listing_id, INVENTOR_STATISTICS_TOTAL_VIEWS_META, true ); ?>
<?php $views = empty ( $views ) ? 0 : $views; ?>

<?php if ( $display == 'row' ): ?>
    <dt><?php echo __( 'Views', 'inventor-statistics' ); ?></dt>
    <dd>
        <?php echo esc_attr( $views ); ?>
    </dd>
<?php endif; ?>