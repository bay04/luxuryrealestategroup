<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */

?>

<div class="posts post-detail">
    <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail(); ?>
    <?php endif; ?>

    <?php $content = get_the_content(); ?>
    <?php if ( ! empty( $content ) ) : ?>
        <div class="post-content">
            <?php the_content(); ?>
        </div><!-- /.post-content -->
    <?php endif; ?>

</div><!-- /.post -->
