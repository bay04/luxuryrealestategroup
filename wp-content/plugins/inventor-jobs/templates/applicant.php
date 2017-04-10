<?php $job_id = get_post_meta( $applicant->ID, INVENTOR_APPLICATION_PREFIX . 'job_id', true ); ?>
<?php $resume_id = get_post_meta( $applicant->ID, INVENTOR_APPLICATION_PREFIX . 'resume_id', true ); ?>
<?php $job = get_post( $job_id ); ?>
<?php $resume = get_post( $resume_id ); ?>
<?php $user_id = $resume->post_author; ?>

<?php if ( has_post_thumbnail( $resume_id ) ) : ?>
    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $resume_id ), 'thumbnail' ); ?>
    <?php $image = $thumbnail[0]; ?>
<?php else: ?>
    <?php $image = Inventor_Post_Type_User::get_user_image( $user_id ); ?>
<?php endif; ?>

<?php $name = Inventor_Post_Type_User::get_full_name( $user_id ); ?>
<?php $phone = get_post_meta( $resume_id, INVENTOR_LISTING_PREFIX . 'phone', true ); ?>
<?php $email = get_post_meta( $resume_id, INVENTOR_LISTING_PREFIX . 'email', true ); ?>
<?php $website = get_post_meta( $resume_id, INVENTOR_LISTING_PREFIX . 'website', true ); ?>

<div class="applicant-container">
    <div class="applicant">
        <?php if ( ! empty( $image ) ) : ?>
            <div class="applicant-image" data-background-image="<?php echo esc_attr( $image ); ?>">
                <a href="<?php echo get_permalink( $resume_id ); ?>">
                    <img src="<?php echo esc_attr( $image ); ?>" alt="">
                </a>
            </div><!-- /.applicant-image -->
        <?php endif; ?>

        <div class="applicant-content">
            <div class="applicant-resume">
                <div class="applicant-title">
                    <span class="applicant-resume-title">
                        <?php echo get_the_title( $resume_id ); ?>
                    </span>

                    <h3 class="applicant-user-name">
                        <a href="<?php echo get_permalink( $resume_id ); ?>">
                            <?php if ( ! empty( $name ) ) : ?>
                                <?php echo esc_attr( $name ) ; ?>
                            <?php endif; ?>
                        </a>
                    </h3><!-- /.applicant-name -->
                </div><!-- /.applicant-title -->

                <dl>
                    <?php if ( ! empty( $email ) ) : ?>
                        <dt class="applicant-email"><?php echo __( 'E-mail', 'inventor-jobs' ); ?></dt>
                        <dd>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ) ; ?></a>
                        </dd>
                    <?php endif; ?>

                    <?php if ( ! empty( $phone ) ) : ?>
                        <dt class="applicant-phone"><?php echo __( 'Phone', 'inventor-jobs' ); ?></dt>
                        <dd>
                            <a href="tel:<?php echo esc_attr( str_replace(' ', '', $phone) ); ?>"><?php echo esc_attr( $phone ); ?></a>
                        </dd>
                    <?php endif; ?>

                    <?php if ( ! empty( $website ) ) : ?>
                        <dt class="applicant-website"><?php echo __( 'Website', 'inventor-jobs' ); ?></dt>
                        <dd>
                            <a href="<?php echo esc_attr( $website ); ?>" target="_blank"><?php echo esc_attr( $website ) ; ?></a>
                        </dd>
                    <?php endif; ?>
                </dl>
            </div><!-- /.applicant-resume -->
            <div class="applicant-job">
                <a class="applicant-job-title" href="<?php echo get_permalink( $job_id ); ?>"><?php echo get_the_title( $job_id ); ?></a>
                <p class="applicant-message"><?php echo $applicant->post_content; ?></p>
            </div><!-- /.applicant-job -->
        </div><!-- /.applicant-content -->
    </div><!-- /.applicant-->
</div><!-- /.user-container-->