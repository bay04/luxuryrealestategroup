<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>


<section id="primary" class="content-area">
    <main id="main" class="site-main content" role="main">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo Inventor_Template_Loader::load( 'content-invoice', array(), $plugin_dir = INVENTOR_INVOICES_DIR ); ?>
            <?php endwhile; ?>

            <?php the_posts_pagination( array(
                'prev_text'          => __( 'Previous', 'inventor-invoices' ),
                'next_text'          => __( 'Next', 'inventor-invoices' ),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'inventor-invoices' ) . ' </span>',
            ) ); ?>
        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>
    </main><!-- .site-main -->
</section><!-- .content-area -->

<?php get_footer(); ?>
