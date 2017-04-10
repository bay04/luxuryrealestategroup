<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */

?>

<section class="no-results not-found">
    <div class="page-content">
        <p><?php echo esc_attr__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'superlist' ); ?></p>

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <?php get_search_form(); ?>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- .page-content -->
</section><!-- .no-results -->
