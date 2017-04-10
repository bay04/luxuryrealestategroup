<div class="watchdog-row">
    <?php $url = Inventor_Watchdogs_Logic::get_watchdog_url( get_the_ID() ); ?>
    <?php $type = get_post_meta( get_the_ID(), INVENTOR_WATCHDOG_PREFIX . 'type', true ); ?>
    <?php $lookup = get_post_meta( get_the_ID(), INVENTOR_WATCHDOG_PREFIX . 'lookup', true ); ?>
    <?php $value = get_post_meta( get_the_ID(), INVENTOR_WATCHDOG_PREFIX . 'value', true ); ?>
    <?php $current_value = Inventor_Watchdogs_Logic::get_watchdog_value( $type, $lookup ); ?>

    <h2>
        <a href="<?php echo esc_attr( $url ); ?>">
            <?php if ( $type == INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY ) : ?>
                <?php printf( _n( '<span class="match">%d</span> listing matches your search query', '<span class="match">%d</span> listings match your search query', $current_value, 'inventor-watchdogs' ), $current_value ); ?>
            <?php endif; ?>
        </a>

        <a href="?watchdog-remove=true&id=<?php echo get_the_ID(); ?>" class="watchdog-row-remove"><i class="fa fa-close"></i></a>
    </h2>
    <?php if ( $value != $current_value ): ?>
        <h3 class="watched-value">
            <?php echo __( 'Watched value', 'inventor-watchdogs' ); ?>: <?php echo $value; ?>
        </h3>
    <?php endif; ?>

    <?php Inventor_Watchdogs_Logic::render_watchdog_lookup( get_the_ID() ); ?>

    <div class="watchdog-row-date"><?php echo __( 'Record created', 'inventor-watchdogs' ); ?>: <?php echo get_the_date(); ?></div>
</div><!-- /.watchdog-row -->

