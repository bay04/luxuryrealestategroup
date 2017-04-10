<div class="wrap">
    <h2><?php echo __( 'Listing Views', 'inventor-statistics' ); ?></h2>

    <?php $query_enabled = get_theme_mod( 'inventor_statistics_enable_listing_logging', false ); ?>

    <?php if ( empty( $query_enabled ) ) : ?>
        <div class="notice warning">
            <p><?php echo __( 'Listing views logging is disabled. If you want to collect stats, plase enable under "Appearance - Customize".', 'inventor-statistics' ); ?></p>
        </div><!-- /.notice -->
    <?php else: ?>

        <div class="chart-block">
            <div class="chart-title">
                <?php echo __( 'Overall listing views for last two weeks', 'inventor-statistics' ); ?>
            </div><!-- /.chart-title -->

            <div id="chart-statistics-daily">
                <svg></svg>
            </div>
        </div><!-- /.chart-block -->

        <div class="row">
            <div class="one-half">
                <?php $listings = Inventor_Statistics_Logic::listing_views_get_popular_listings(); ?>

                <?php if ( ! empty( $listings ) && is_array( $listings ) ) : ?>
                    <table class="table">
                        <thead>
                        <th colspan="2" class="center">
                            <?php echo __( '10 most popular listings', 'inventor-statistics' ); ?>
                        </th>
                        </thead>

                        <tbody>
                        <?php foreach ( $listings as $listing ) : ?>
                            <tr>
                                <td>
                                    <?php if ( has_post_thumbnail( $listing->key ) ) : ?>
                                        <span class="table-small-image">
                                                <?php echo get_the_post_thumbnail( $listing->key, array( 22, 22 ) ); ?>
                                            </span><!-- /.table-small-image -->
                                    <?php endif; ?>

                                    <a href="<?php echo get_the_permalink( $listing->key ); ?>"><?php echo get_the_title( $listing->key ); ?><a>
                                </td>
                                <td><?php echo esc_attr( $listing->count ); ?> <?php echo __( 'views', 'inventor-statistics' ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div><!-- /.one-half -->

            <div class="one-half">
                <?php $locations = Inventor_Statistics_Logic::listing_views_get_popular_locations(); ?>

                <?php if ( ! empty( $locations ) && is_array( $locations ) ) : ?>
                    <table class="table">
                        <thead>
                        <th colspan="2" class="center">
                            <?php echo __( '10 most popular locations', 'inventor-statistics' ); ?>
                        </th>
                        </thead>

                        <tbody>
                        <?php foreach ( $locations as $location ) : ?>
                            <tr>
                                <td>
                                    <?php $term = get_term( $location->term_taxonomy_id, 'locations' ); ?>
                                    <a href="<?php echo get_term_link( $term->term_taxonomy_id, 'locations' ); ?>"><?php echo esc_attr( $term->name ); ?><a>
                                </td>
                                <td><?php echo esc_attr( $location->count ); ?> <?php echo __( 'views', 'inventor-statistics' ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div><!-- /.one-half -->
        </div><!-- /.row -->
    <?php endif; ?>
</div><!-- /.wrap -->