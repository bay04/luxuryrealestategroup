<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The template for user list
 *
 * @package Inventor
 * @since Inventor 1.3.0
 */
?>

<?php do_action( 'inventor_before_user_list' ); ?>

<?php if( count( $users ) > 0 ): ?>
    <div class="user-list <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>items-per-row-2<?php else : ?>items-per-row-2<?php endif; ?>">
        <?php foreach ( $users as $user ) : ?>
            <?php include Inventor_Template_Loader::locate( 'users/card' ); ?>
        <?php endforeach; ?>

        <?php //TODO: http://wordpress.stackexchange.com/questions/99225/how-to-list-users-like-an-archive-page-10-users-on-page-and-have-navigations ?>
        <?php the_posts_pagination( array(
            'prev_text'             => __( 'Previous', 'inventor' ),
            'next_text'             => __( 'Next', 'inventor' ),
            'mid_size'              => 2,
        ) ); ?>
    </div>
<?php else : ?>
    <?php get_template_part( 'templates/content', 'none' ); ?>
<?php endif; ?>

<?php do_action( 'inventor_before_user_list' ); ?>