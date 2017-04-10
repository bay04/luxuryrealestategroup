<?php $experience_group = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX  . 'resume_experience_group', true ); ?>
<?php if ( ! empty( $experience_group ) && is_array( $experience_group ) && count( $experience_group ) > 0 ) : ?>
    <div class="listing-detail-section" id="listing-detail-section-resume-experience">
        <h2 class="page-header"><?php echo $section_title; ?></h2>

        <div class="listing-detail-resume-experience">
            <?php $experience_groups = Inventor_Jobs_Post_Type_Resume::get_experience_groups(); ?>
            <?php $experience_levels = apply_filters( 'inventor_jobs_experience_levels', array() ); ?>

            <div class="listing-detail-resume-experience-levels">
                <?php foreach( array_keys( $experience_groups ) as $level ) : ?>
                    <div class="listing-detail-resume-experience-level">
                        <h3><?php echo $experience_levels[ $level ]; ?></h3>
                        <ul>
                        <?php foreach( $experience_groups[ $level ] as $experience ) : ?>
                            <?php $title = empty( $experience[ 'title' ] ) ? null : $experience[ 'title' ]; ?>
                            <?php $years = empty( $experience[ 'years' ] ) ? null : $experience[ 'years' ]; ?>

                            <?php if ( ! empty( $title ) ): ?>
                                <li>
                                    <?php echo esc_attr( $title ); ?><?php if ( ! empty( $years ) ): ?>, <span><?php echo sprintf( _n( '%d year', '%d years', $years, 'inventor-jobs' ), $years ); ?></span><?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </ul>
                    </div><!-- /.listing-detail-resume-experience-level -->
                <?php endforeach; ?>
            </div><!-- /.listing-detail-resume-experience-levels -->
        </div><!-- /.listing-detail-resume-experience -->
    </div><!-- /.listing-detail-section -->
<?php endif; ?>