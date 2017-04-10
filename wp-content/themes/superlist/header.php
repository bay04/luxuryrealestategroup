<?php
/**
 * The template for displaying header
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if ( class_exists( 'Inventor_Template_Loader' ) ) :   ?>
    <?php echo Inventor_Template_Loader::load( 'misc/messages' ); ?>
<?php endif; ?>

<div class="page-wrapper">
    <?php $header_type = get_theme_mod( 'superlist_general_header_type', 'header-regular' ); ?>
    <?php get_template_part( 'templates/header-types/' . $header_type ); ?>

    <?php if ( class_exists( 'Inventor_Post_Types' ) ) : ?>
        <?php $post_types = Inventor_Post_Types::get_listing_post_types(); ?>
        <?php if ( is_singular( $post_types ) ) : ?>
            <?php get_template_part( 'templates/content-listing-banner' ); ?>

            <div class="listing-detail-menu-wrapper">
                <div class="listing-detail-menu">
                    <div class="container">
                        <ul class="nav nav-pills"></ul>
                    </div><!-- /.container -->
                </div><!-- /.listing-detail-menu -->
            </div><!-- /.listing-detail-menu-wrapper -->
        <?php endif; ?>
    <?php endif; ?>

    <div class="main">

        <?php dynamic_sidebar( 'top-fullwidth' ); ?>

        <div class="main-inner">
            <div class="container">
                <?php dynamic_sidebar( 'top' ); ?>
