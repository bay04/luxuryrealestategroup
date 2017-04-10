<?php if ( apply_filters( 'inventor_metabox_allowed', true, 'opening_hours', get_the_author_meta('ID') ) ): ?>
    <?php $visible = Inventor_Post_Types::opening_hours_visible(); ?>

    <?php if ( $visible ) : ?>
        <div class="listing-detail-section" id="listing-detail-section-opening-hours">
            <h2 class="page-header"><?php echo $section_title; ?></h2>

            <table class="opening-hours horizontal">
                <?php
                // week days
                $day_names = Inventor_Post_Types::opening_hours_day_names();

                // get opening hours
                $opening_hours = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'opening_hours', true );

                // preserve first day of week setting
                $opening_hours = array_merge( array_splice( $opening_hours, get_option( 'start_of_week' ) - 1 ), $opening_hours );
                ?>

                <thead>
                <tr>
                    <?php foreach( $opening_hours as $day ): ?>
                        <th>
                            <?php echo $day_names[ $day['listing_day'] ]; ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <?php foreach( $opening_hours as $day ): ?>
                        <?php $open_status = Inventor_Post_Types::opening_hours_status( get_the_ID(), $day['listing_day'] ); ?>
                        <td class="<?php echo $open_status; ?>">
                            <?php echo Inventor_Post_Types::opening_hours_format_day( $day, true ); ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                </tbody>
            </table>
        </div><!-- /.listing-detail-section -->
    <?php endif; ?>
<?php endif; ?>