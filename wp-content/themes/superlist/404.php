<?php
/**
 * The template for displaying not found page
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

get_header(); ?>

<div class="row">
    <div class="col-sm-12">
        <div id="primary">
            <?php dynamic_sidebar( 'content-top' ); ?>

            <section class="no-results not-found">
                <div class="page-content">
                    <div class="number">
                        404

                        <div class="number-description"><?php echo esc_attr__( 'Page does not exist.', 'superlist' ); ?></div><!-- /.number-description -->
                    </div><!-- /.number -->
                </div><!-- .page-content -->
            </section><!-- .no-results -->

            <?php dynamic_sidebar( 'content-bottom' ); ?>
        </div><!-- /#primary -->
    </div><!-- /.col-* -->
</div><!-- /.row -->

<?php get_footer(); ?>
