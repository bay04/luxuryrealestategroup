<?php $working_history_group = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX  . 'resume_working_history_group', true ); ?>
<?php if ( ! empty( $working_history_group ) && is_array( $working_history_group ) && count( $working_history_group ) > 0 ) : ?>
    <div class="listing-detail-section" id="listing-detail-section-resume-working-history">
        <h2 class="page-header"><?php echo $section_title; ?></h2>

        <div class="listing-detail-resume-working-history">
            <dl>
                <?php foreach( $working_history_group as $working_history ) : ?>
                    <dt>
                        <?php $date_from = empty( $working_history[ INVENTOR_LISTING_PREFIX . 'resume_working_history_date_from' ] ) ? null : $working_history[ INVENTOR_LISTING_PREFIX . 'resume_working_history_date_from' ]; ?>
                        <?php $date_to = empty( $working_history[ INVENTOR_LISTING_PREFIX . 'resume_working_history_date_to' ] ) ? null : $working_history[ INVENTOR_LISTING_PREFIX . 'resume_working_history_date_to' ]; ?>

                        <?php if ( ! empty( $date_from ) ): ?><?php echo date( 'Y', esc_attr( $date_from ) ); ?><?php endif; ?><?php if ( ! empty( $date_to ) ): ?> - <?php echo date( 'Y', esc_attr( $date_to ) ); ?><?php endif; ?>
                    </dt>
                    <dd>
                        <?php $tile = empty( $working_history[ INVENTOR_LISTING_PREFIX . 'resume_working_history_title' ] ) ? null : $working_history[ INVENTOR_LISTING_PREFIX . 'resume_working_history_title' ]; ?>
                        <?php if ( ! empty( $tile ) ): ?>
                            <h3><?php echo esc_attr( $tile ); ?></h3>
                        <?php endif; ?>

                        <?php $description = empty( $working_history[ INVENTOR_LISTING_PREFIX . 'resume_working_history_description' ] ) ? null : $working_history[ INVENTOR_LISTING_PREFIX . 'resume_working_history_description' ]; ?>
                        <?php if ( ! empty( $description ) ): ?>
                            <p><?php echo esc_attr( $description ); ?></p>
                        <?php endif; ?>
                    </dd>
                <?php endforeach; ?>
            </dl>
        </div><!-- /.listing-detail-resume-working-history -->
    </div><!-- /.listing-detail-section -->
<?php endif; ?>