<?php
/**
 * The template for displaying listing archive
 *
 * @package Superlist
 * @since Superlist 1.0.0
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
				 * Inventor_before_faq_archive
				 */
				do_action( 'inventor_before_faq_archive' );
				?>

                <div class="faq">

                <?php while ( have_posts() ) : the_post(); ?>

                    <div class="faq-item">
                        <div class="faq-item-question">
                            <h2><?php the_title(); ?></h2>
                        </div>
                        <div class="faq-item-answer">
                            <?php the_content(); ?>
                        </div>
                    </div><!-- /.faq-item -->

                <?php endwhile; ?>

                </div><!-- /.faq -->

				<?php
				/**
				 * Inventor_after_faq_archive
				 */
				do_action( 'inventor_after_faq_archive' );
				?>

				<?php superlist_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'templates/content', 'none' ); ?>
			<?php endif; ?>

			<?php dynamic_sidebar( 'content-bottom' ); ?>
		</div><!-- #primary -->
	</div><!-- /.col-* -->

	<?php get_sidebar() ?>
</div><!-- /.row -->

<?php get_footer(); ?>
