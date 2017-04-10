<?php if ( has_nav_menu( 'main' ) ) : ?>
    <?php wp_nav_menu( array(
        'container_class'   => 'header-navigation',
        'fallback_cb'		=> '',
        'theme_location'    => 'main',
        'menu_class'        => 'header-nav-primary nav nav-pills collapse navbar-collapse',
    ) ); ?>
<?php endif; ?>