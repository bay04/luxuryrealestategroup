<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */
?>

<?php $listing_banner = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner', true ); ?>
<?php $listing_banner = empty( $listing_banner ) ? get_theme_mod( 'inventor_general_default_banner_type', 'banner_featured_image' ) : $listing_banner; ?>
<?php $listing_banner_slug = str_replace( array( 'banner_', '_' ), array( '', '-' ), $listing_banner ); ?>

<?php get_template_part( 'templates/banner-types/' . $listing_banner_slug ); ?>
