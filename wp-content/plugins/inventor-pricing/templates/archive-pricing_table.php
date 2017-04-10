<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The template for archive page
 *
 * @package Inventor_Pricing
 * @since Inventor_Pricing 0.3.0
 */

get_header(); ?>

<div class="row">
    <div class="<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>col-sm-8 col-lg-9<?php else : ?>col-sm-12<?php endif; ?>">
        <div id="primary">
            <?php get_template_part( 'templates/document-title' ); ?>

            <?php dynamic_sidebar( 'content-top' ); ?>

            <?php if ( have_posts() ) : ?>
                <?php
                /**
                 * Inventor_before_pricing_archive
                 */
                do_action( 'inventor_before_pricing_archive' );
                ?>

                <?php global $wp_query; ?>
                <?php $count = count( $wp_query->get_posts() ); ?>
                <?php $per_row = $count <= 4 ? $count : ( in_array( $count, array( 5, 6, 9 ) ) ? 3 : 4 ) ; ?>

                <div class="items-per-row-<?php echo $per_row; ?>">

                    <div class="pricing-row">
                        <?php $index = 0; ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                        <?php include Inventor_Template_Loader::locate( 'pricing-table', INVENTOR_PRICING_DIR ); ?>

                        <?php if ( ( $index + 1 ) % $per_row == 0 && Inventor_Query::loop_has_next() ) : ?>
                    </div><div class="pricing-row">
                        <?php endif; ?>

                        <?php $index++; ?>
                        <?php endwhile; ?>
                    </div><!-- /.properties-row -->
                </div>

                <?php
                /**
                 * Inventor_after_pricing_archive
                 */
                do_action( 'inventor_after_pricing_archive' );
                ?>

                <?php the_posts_pagination( array(
                    'prev_text'             => __( 'Previous', 'inventor' ),
                    'next_text'             => __( 'Next', 'inventor' ),
                    'mid_size'              => 2,
                ) ); ?>

            <?php else : ?>
                <?php get_template_part( 'templates/content', 'none' ); ?>
            <?php endif; ?>

            <?php dynamic_sidebar( 'content-bottom' ); ?>
        </div><!-- #primary -->
    </div><!-- /.col-* -->

    <?php get_sidebar() ?>
</div><!-- /.row -->

<?php get_footer(); ?>
