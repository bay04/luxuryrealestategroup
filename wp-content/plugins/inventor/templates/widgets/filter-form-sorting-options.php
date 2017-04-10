<div class="filter-sorting-options clearfix">
    <div class="filter-sorting-inner">
        <div class="filter-sorting-inner-group filter-sorting-inner-group-types">
            <strong><?php echo esc_attr__( 'Sort', 'inventor' ); ?>:</strong>

            <?php $default_sort = get_theme_mod( 'inventor_general_default_listing_sort', 'published' ); ?>
            <?php $current_sort = empty( $_GET['sort-by' ] ) ? $default_sort : esc_attr( $_GET['sort-by' ] ); ?>

            <ul>
                <?php $sort_by_choices = apply_filters( 'inventor_filter_sort_by_choices', array() ); ?>
                <?php foreach( $sort_by_choices as $key => $value ): ?>
                    <li>
                        <a class="filter-sort-by-<?php echo $key; ?> <?php if ( $current_sort == $key ) : ?>active<?php endif; ?>">
                            <?php echo $value ?>
                            <input type="hidden" name="sort-by" value="<?php echo esc_attr( $key ); ?>" <?php if ( empty( $_GET['sort-by'] ) || $_GET['sort-by'] != $key ) : ?>disabled<?php endif; ?>>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div><!-- /.filter-sorting-inner-group -->

        <div class="filter-sorting-inner-group filter-sorting-inner-group-order">
            <strong><?php echo esc_attr__( 'Order', 'inventor' ); ?>:</strong>

            <?php $default_order = get_theme_mod( 'inventor_general_default_listing_order', 'desc' ); ?>
            <?php $current_order = empty( $_GET['order' ] ) ? $default_order : esc_attr( $_GET['order' ] ); ?>

            <ul>
                <li>
                    <a class="filter-sort-order-asc <?php if ( $current_order == 'asc' ) : ?>active<?php endif; ?>">
                        <input type="hidden" name="order" value="asc" <?php if ( empty( $_GET['order'] ) || $_GET['order'] != 'asc' ) : ?>disabled<?php endif; ?>>
                        <?php echo esc_attr__( 'Asc', 'inventor' ); ?>
                    </a>
                </li>
                <li>
                    <a class="filter-sort-order-desc <?php if ( $current_order == 'desc' ) : ?>active<?php endif; ?>">
                        <input type="hidden" name="order" value="desc" <?php if ( empty( $_GET['order'] ) || $_GET['order'] != 'desc' ) : ?>disabled<?php endif; ?>>
                        <?php echo esc_attr__( 'Desc', 'inventor' ); ?>
                    </a>
                </li>
            </ul>
        </div><!-- /.filter-sorting-inner-group -->

        <div class="filter-sorting-inner-styles">
            <?php $display_as_grid = ! empty( $_GET['listing-display'] ) && 'grid' == $_GET['listing-display'] || empty( $_GET['listing-display'] ) && get_theme_mod( 'inventor_general_show_listing_archive_as_grid', false ); ?>

            <ul>
                <li>
                    <a class="listing-display-rows <?php if ( ! $display_as_grid ) : ?>active<?php endif; ?>">
                        <span><?php echo esc_attr__( 'Rows', 'inventor' ); ?></span>
                        <input type="hidden" name="listing-display" value="rows" <?php if ( empty( $_GET['listing-display'] ) || $display_as_grid ) : ?>disabled<?php endif; ?>>
                    </a>
                </li>

                <li>
                    <a class="listing-display-grid <?php if ( $display_as_grid ) : ?>active<?php endif; ?>">
                        <span><?php echo esc_attr__( 'Grid', 'inventor' ); ?></span>
                        <input type="hidden" name="listing-display" value="grid" <?php if ( empty( $_GET['listing-display'] ) || ! $display_as_grid ) : ?>disabled<?php endif; ?>>
                    </a>
                </li>
            </ul>
        </div>
    </div><!-- /.filter-sorting-inner -->
</div><!-- /.filter-sorting-options -->