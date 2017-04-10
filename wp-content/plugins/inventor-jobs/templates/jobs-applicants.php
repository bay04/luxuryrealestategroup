<?php if ( empty( $applicants ) ): ?>
    <div class="alert alert-info">
        <?php echo __( 'Nobody applied to any of your jobs yet.', 'inventor-jobs' ) ?>
    </div>
<?php else: ?>
    <div class="applicant-list items-per-row-2">
        <?php foreach ( $applicants as $applicant ): ?>
            <?php echo Inventor_Template_Loader::load( 'applicant', array( 'applicant' => $applicant ), INVENTOR_JOBS_DIR ); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>