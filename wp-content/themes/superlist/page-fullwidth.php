<?php
/**
 * The template for displaying dashboard
 *
 * Template name: Fullwidth
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

get_header(); ?>

<div class="row">
	<div class="col-sm-12">
        <div id="primary">
			<?php get_template_part( 'templates/document-title' ); ?>

			<?php dynamic_sidebar( 'content-top' ); ?>

				<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'templates/content-page' ); ?>
						<?php endwhile; ?>

					<?php superlist_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'templates/content', 'none' ); ?>
				<?php endif; ?>

			<?php dynamic_sidebar( 'content-bottom' ); ?>

        </div><!-- #primary -->
	</div><!-- /.col-* -->
</div><!-- /.row -->

<?php get_footer(); ?>
