<?php
/**
 * The template for displaying main file
 *
 * @package Inventor Bootstrap
 * @since Inventor Bootstrap 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<div class="row">
    <div class="<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>col-lg-8 col-xl-9<?php else : ?>col-sm-12<?php endif; ?>">
        <?php dynamic_sidebar( 'content-top' ); ?>

        <div class="content">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php include Inventor_Template_Loader::locate( 'content-listing' ); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part( 'templates/content', 'none' ); ?>
            <?php endif; ?>
        </div><!-- /.content -->

        <?php dynamic_sidebar( 'content-bottom' ); ?>
    </div><!-- /.col-* -->

    <?php get_sidebar() ?>
</div><!-- /.row -->

<?php get_footer(); ?>
