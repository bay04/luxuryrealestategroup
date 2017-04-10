<?php $required_skills = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX  . 'job_skill', true ); ?>
<?php if ( ! empty( $required_skills ) && is_array( $required_skills ) && count( $required_skills ) > 0 ) : ?>
    <div class="listing-detail-section" id="listing-detail-section-job-skills">
        <h2 class="page-header"><?php echo $section_title; ?></h2>

        <div class="listing-detail-job-skills">
            <ul>
                <?php foreach( $required_skills as $required_skill_id ) : ?>
                    <li>
                        <?php $required_skill = get_term_by( 'slug', $required_skill_id, 'job_skills' ) ?>
                        <?php echo wp_kses( $required_skill->name, wp_kses_allowed_html( 'post' ) ); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div><!-- /.listing-detail-job-skills -->
    </div><!-- /.listing-detail-section -->
<?php endif; ?>