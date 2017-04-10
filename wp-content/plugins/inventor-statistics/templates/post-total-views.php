<div class="inventor-statistics-total-post-views">
    <?php $total_views = get_post_meta( $listing_id, INVENTOR_STATISTICS_TOTAL_VIEWS_META, true ); ?>
    <?php $total_views = empty ( $total_views ) ? 0 : $total_views; ?>
    <i class="fa fa-eye"></i>
    <?php echo sprintf( _n( '<strong>%d</strong> view', '<strong>%d</strong> views', $total_views, 'inventor-statistics' ), $total_views ); ?>
</div>