<?php if ( is_active_sidebar( 'header-topbar-left' ) || is_active_sidebar( 'header-topbar-right' ) ) : ?>
    <div class="header-bar">
        <div class="container">
            <div class="header-bar-inner">
                <?php if ( is_active_sidebar( 'header-topbar-left' ) ) : ?>
                    <div class="header-bar-left">
                        <?php dynamic_sidebar( 'header-topbar-left' ); ?>
                    </div><!-- /.header-bar-left -->
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'header-topbar-right' ) ) : ?>
                    <div class="header-bar-right">
                        <?php dynamic_sidebar( 'header-topbar-right' ); ?>
                    </div><!-- /.header-bar-right -->
                <?php endif; ?>
            </div><!-- /.header-bar-inner -->
        </div><!-- /.container -->
    </div><!-- /.header-bar -->
<?php endif; ?>