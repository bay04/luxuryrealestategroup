<?php if ( empty( $job ) ): ?>
    <div class="alert alert-warning">
        <?php echo __( 'You have to specify listing!', 'inventor-jobs' ) ?>
    </div>
<?php elseif ( Inventor_Jobs_Logic::user_already_applied( $job->ID, get_current_user_id() ) ): ?>
    <div class="alert alert-info">
        <?php echo __( 'You have already applied for this job.', 'inventor-jobs' ) ?>
    </div>
<?php else: ?>
    <?php $current_user = wp_get_current_user(); ?>
    <h3><?php echo __( sprintf( "You are going to apply as %s for job %s.", $current_user->display_name, get_the_title( $job ) ), 'inventor-jobs' ); ?></h3>

    <?php echo __( 'Choose a resume you want to apply with', 'inventor-jobs' ) . ':'; ?>

    <form method="post">
        <input type="hidden" name="job_id" value="<?php echo $job->ID; ?>">

        <div class="form-group">
            <select class="form-control" name="resume" required="required">
                <?php foreach ( $resumes as $resume ) : ?>
                    <option value="<?php echo esc_attr( $resume->ID ); ?>">
                        <?php echo get_the_title( $resume ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div><!-- /.form-group -->

        <div class="form-group">
            <textarea class="form-control" name="message" required="required" placeholder="<?php echo __( 'Message', 'inventor-jobs' ); ?>" rows="4"></textarea>
        </div><!-- /.form-group -->

        <?php if ( class_exists( 'Inventor_Recaptcha' ) ) : ?>
            <?php if ( Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) : ?>
                <div id="recaptcha-<?php echo esc_attr( $job->id ); ?>" class="g-recaptcha" data-sitekey="<?php echo get_theme_mod( 'inventor_recaptcha_site_key' ); ?>"></div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="button-wrapper">
            <button type="submit" class="btn btn-primary" name="jobs_apply_form"><?php echo __( sprintf( 'Apply for %s', get_the_title( $job ) ), 'inventor-jobs' ); ?></button>
        </div><!-- /.button-wrapper -->
    </form>
<?php endif; ?>