<?php if ( is_array( $lookup ) ): ?>
    <dl class="watchdog-lookup">
        <?php foreach ( $lookup as $key => $value ): ?>
            <?php if( $key == 'post-type' ): ?>
                <dt><?php echo __( 'Type', 'inventor-watchdogs' ); ?></dt>
                <dd><?php echo is_array( $value ) ? join( ',', $value ) : $value; ?></dd>
            <?php else: ?>
                <dt><?php echo Inventor_Watchdogs_Logic::get_lookup_name_by_key( $key ); ?></dt>
                <dd><?php echo Inventor_Watchdogs_Logic::get_lookup_display_value( $key, $value ); ?></dd>
            <?php endif; ?>
        <?php endforeach; ?>
    </dl>
<?php else: ?>
    <?php echo $lookup; ?>
<?php endif; ?>