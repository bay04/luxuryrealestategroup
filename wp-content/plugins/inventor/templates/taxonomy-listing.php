<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The template for taxonomy archive page
 *
 * @package Inventor
 * @since Inventor 0.1.0
 */

get_header(); ?>

<?php $display_as_grid = ! empty( $_GET['listing-display'] ) && 'grid' == $_GET['listing-display'] || empty( $_GET['listing-display'] ) && get_theme_mod( 'inventor_general_show_listing_archive_as_grid', false ); ?>

<div class="row">
    <div class="<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>col-sm-8 col-lg-9<?php else : ?>col-sm-12<?php endif; ?>">
        <div id="primary">
            <?php get_template_part( 'templates/document-title' ); ?>

            <?php dynamic_sidebar( 'content-top' ); ?>

            <?php if ( have_posts() ) : ?>
                <?php do_action( 'inventor_before_listing_archive' );?>

                <?php if ( $display_as_grid ) : ?>
                    <div class="listing-box-archive type-box items-per-row-3">
                <?php endif; ?>

                <div class="listings-row">

                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="listing-container">
                            <?php if ( $display_as_grid ) : ?>
                                <?php include Inventor_Template_Loader::locate( 'listings/column' ); ?>
                            <?php else : ?>
                                <?php include Inventor_Template_Loader::locate( 'listings/row' ); ?>
                            <?php endif; ?>
                        </div><!-- /.listing-container -->
                    <?php endwhile; ?>

                </div><!-- /.listings-row -->

                <?php if ( $display_as_grid ) : ?>
                    </div><!-- /.listing-box-archive -->
                <?php endif; ?>

                <?php do_action( 'inventor_after_listing_archive' ); ?>

                <?php the_posts_pagination( array(
                    'prev_text'             => __( 'Previous', 'inventor' ),
                    'next_text'             => __( 'Next', 'inventor' ),
                    'mid_size'              => 2,
                    ) ); ?>
            <?php else : ?>
                <?php get_template_part( 'templates/content', 'none' ); ?>
            <?php endif; ?>
        </div><!-- /.content -->

        <?php dynamic_sidebar( 'content-bottom' ); ?>
    </div><!-- /.col-* -->

    <?php get_sidebar() ?>
</div><!-- /.row -->

<?php get_footer(); ?>
