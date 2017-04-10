<?php if ( ! $is_assigned ): ?>
    <?php if ( Inventor_Jobs_Logic::user_already_applied( $job_id, get_current_user_id() ) ) : ?>
        <span class="inventor-jobs-apply-btn marked" data-job-id="<?php echo $job_id; ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
            <i class="fa fa-hand-peace-o"></i> <?php echo __( 'I applied', 'inventor-jobs' ); ?>
        </span><!-- /.inventor-jobs-apply-btn -->
    <?php else: ?>
        <a href="<?php echo get_permalink( $apply_page ); ?>?id=<?php echo $job_id ?>" class="inventor-jobs-apply-btn" data-job-id="<?php echo $job_id; ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
            <i class="fa fa-hand-peace-o"></i> <?php echo __( 'Apply', 'inventor-jobs' ); ?>
        </a><!-- /.inventor-jobs-apply-btn -->
    <?php endif ; ?>
<?php endif ; ?>