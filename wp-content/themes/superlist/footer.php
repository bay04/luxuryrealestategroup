<?php
/**
 * The template for displaying the footer
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

?>

                <?php dynamic_sidebar( 'bottom' ); ?>
            </div><!-- /.content -->
        </div><!-- /.main-inner -->
    </div><!-- /.main -->

    <footer class="footer">
        <?php if ( is_active_sidebar( 'footer-first' ) || is_active_sidebar( 'footer-second' ) || is_active_sidebar( 'footer-top-first' ) || is_active_sidebar( 'footer-top-second' ) || is_active_sidebar( 'footer-top-third' ) || is_active_sidebar( 'footer-top-fourth' ) ) : ?>
            <div class="footer-top">
	            <?php if ( is_active_sidebar( 'footer-top-first' ) || is_active_sidebar( 'footer-top-second' ) || is_active_sidebar( 'footer-top-third' ) || is_active_sidebar( 'footer-top-fourth' ) ) : ?>
		            <div class="footer-area">
			            <div class="container">
				            <div class="row">
								<div class="col-sm-3">
									<?php dynamic_sidebar( 'footer-top-first' ); ?>
								</div><!-- /.cols-sm-3 -->

					            <div class="col-sm-3">
						            <?php dynamic_sidebar( 'footer-top-second' ); ?>
					            </div><!-- /.cols-sm-3 -->

					            <div class="col-sm-3">
						            <?php dynamic_sidebar( 'footer-top-third' ); ?>
					            </div><!-- /.cols-sm-3 -->

					            <div class="col-sm-3">
						            <?php dynamic_sidebar( 'footer-top-fourth' ); ?>
					            </div><!-- /.cols-sm-3 -->
				            </div><!-- /.row -->
			            </div><!-- /.container -->
		            </div><!-- .footer-area -->
				<?php endif; ?>

	            <?php if ( is_active_sidebar( 'footer-first' ) || is_active_sidebar( 'footer-second' ) ) : ?>
	                <div class="container">
		                <div class="footer-top-inner">
		                    <?php if ( is_active_sidebar( 'footer-first' ) ) : ?>
		                        <div class="footer-first">
		                            <?php dynamic_sidebar( 'footer-first' ); ?>
		                        </div><!-- /.footer-first -->
		                    <?php endif; ?>

		                    <?php if ( is_active_sidebar( 'footer-second' ) ) : ?>
		                        <div class="footer-second">
		                            <?php dynamic_sidebar( 'footer-second' ); ?>
		                        </div><!-- /.footer-second -->
		                    <?php endif; ?>
		                </div><!-- /.footer-top-inner -->
	                </div><!-- /.container -->
	            <?php endif; ?>
            </div><!-- /.footer-top -->
        <?php endif; ?>

        <?php if ( is_active_sidebar( 'footer-bottom-first' ) || is_active_sidebar( 'footer-bottom-second' ) ) : ?>
            <div class="footer-bottom">
                <div class="container">
					<div class="footer-bottom-inner">
	                    <div class="footer-bottom-first">
	                        <?php dynamic_sidebar( 'footer-bottom-first' ); ?>
	                    </div><!-- /.footer-bottom-first -->

	                    <div class="footer-bottom-second">
	                        <?php dynamic_sidebar( 'footer-bottom-second' ); ?>
	                    </div><!-- /.footer-bottom-second -->
					</div><!-- /.footer-bottom-inner -->
                </div><!-- /.container -->
            </div><!-- /.footer-bottom -->
        <?php endif; ?>

    </footer><!-- /.footer -->
</div><!-- /.page-wrapper -->

<?php get_template_part( 'templates/modal' ); ?>

<?php $customizer = get_theme_mod( 'superlist_general_customizer', false ); ?>
<?php if ( ! empty( $customizer ) ) : ?>
	<?php get_template_part( 'templates/action-bar' ); ?>
<?php endif; ?>


<?php wp_footer(); ?>

</body>
</html>
