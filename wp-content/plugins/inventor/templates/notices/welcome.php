<div class="notice notice-info inventor-notice">
    <p>
        <?php echo __( '<strong>Welcome to Inventor</strong> - please read <a href="http://inventorwp.com/documentation/" target="_blank">documentation</a> for more information.', 'inventor' ); ?>
    </p>

    <p>
        <?php echo __( 'All available features are listed at <a href="http://inventorwp.com" target="_blank">inventorwp.com</a>.', 'inventor' ); ?>
    </p>

    <p class="submit">
        <a href="http://inventorwp.com/documentation/" target="_blank" class="button-primary">
            <?php echo __( 'Documentation', 'inventor' ); ?>
        </a>

        <a href="http://inventorwp.com/plugins/" target="_blank" class="button-secondary">
            <?php echo __( 'Plugins', 'inventor' ); ?>
        </a>

        <a class="button-secondary skip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'inventor-hide-notice', 'welcome' ), 'inventor_hide_notices_nonce', '_inventor_notice_nonce' ) ); ?>">
            <?php echo __( 'Hide', 'inventor' ); ?>
        </a>
    </p>
</div><!-- /.notice -->
