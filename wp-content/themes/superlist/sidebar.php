<?php
/**
 * The template for displaying primary sidebar
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="col-sm-4 col-lg-3">
        <div id="secondary" class="secondary sidebar">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </div><!-- /#secondary -->
    </div><!-- /.col-* -->
<?php endif; ?>
