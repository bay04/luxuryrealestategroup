<?php $reports_config = Inventor_Reports::get_config(); ?>
<?php $report_page = $reports_config['page']; ?>
<?php if ( ! empty( $report_page ) ): ?>
    <div class="listing-report">
        <a href="<?php echo get_permalink( $report_page ); ?>?id=<?php the_ID(); ?>" class="listing-report-btn">
            <i class="fa fa-flag-o"></i>
            <span><?php echo __( 'Report spam, abuse, or inappropriate content', 'inventor' ); ?></span>
        </a><!-- /.listing-report-btn-->
    </div><!-- /.listing-report -->
<?php endif; ?>