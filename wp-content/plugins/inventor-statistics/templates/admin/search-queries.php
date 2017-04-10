<div class="wrap">
    <h2><?php echo __( 'Search Query Statistics', 'inventor-statistics' ); ?></h2>

    <?php $query_enabled = get_theme_mod( 'inventor_statistics_enable_query_logging', false ); ?>

    <?php if ( empty( $query_enabled ) ) : ?>
        <div class="notice warning">
            <p><?php echo __( 'Query logging is disabled. If you want to collect queries, plase enable under "Appearance - Customize".', 'inventor-statistics' ); ?></p>
        </div><!-- /.notice -->
    <?php else: ?>

        <div class="chart-block">
            <div class="chart-title">
                <?php echo __( 'Filters per day in the last two weeks', 'inventor-statistics' ); ?>
            </div><!-- /.chart-title  -->

            <div id="chart-daily-filters">
                <svg></svg>
            </div>
        </div><!-- /.chart-block -->

        <div class="row">
            <div class="price-from one-half">
                <div class="chart-block">
                    <div class="chart-title">
                        <?php echo __( 'Price searches', 'inventor-statistics' ); ?>
                    </div><!-- /.chart-title  -->

                    <div id="chart-price">
                        <svg></svg>
                    </div>
                </div><!-- /.chart-block -->
            </div><!-- /.one-half -->

            <div class="one-half">
                <div class="row">
                    <div class="one-half">
                        <div class="chart-block">
                            <div class="chart-title">
                                <?php echo __( 'Locations', 'inventor-statistics' ); ?>
                            </div><!-- /.chart-title  -->

                            <div id="chart-location">
                                <svg></svg>
                            </div>
                        </div><!-- /.chart-block -->
                    </div><!-- /.one-half -->

                    <div class="one-half">
                        <div class="chart-block">
                            <div class="chart-title">
                                <?php echo __( 'Categories', 'inventor-statistics' ); ?>
                            </div><!-- /.chart-title  -->

                            <div id="chart-category">
                                <svg></svg>
                            </div>
                        </div><!-- /.chart-block -->
                    </div><!-- /.one-half -->
                </div>
            </div>
        </div><!-- /.row -->
    <?php endif; ?>
</div><!-- /.wrap -->