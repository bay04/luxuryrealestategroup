<header class="header header-complex">
    <?php get_template_part( 'templates/header-parts/header-bar' ); ?>

    <div class="header-wrapper affix-top">
        <div class="container">
            <div class="header-inner">
                <?php get_template_part( 'templates/header-parts/header-logo' ); ?>

                <div class="header-content">
                    <?php dynamic_sidebar( 'header' ); ?>

                    <?php get_template_part( 'templates/header-parts/header-action' ); ?>

                    <?php get_template_part( 'templates/header-parts/header-navigation-toggle' ); ?>
                </div><!-- /.header-content -->
            </div><!-- /.header-inner -->
        </div><!-- /.container -->

        <div class="header-navigation-wrapper">
            <div class="container">
                <?php get_template_part( 'templates/header-parts/header-navigation-menu' ); ?>
            </div><!-- /.container -->
        </div><!-- /.header-navigation-wrapper -->

        <?php get_template_part( 'templates/header-parts/header-post-types' ); ?>
    </div><!-- /.header-wrapper -->
</header><!-- /.header -->