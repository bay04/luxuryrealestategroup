<?php
/**
 * Superlist child functions and definitions
 *
 * @package Superlist Child
 * @since Superlist Child 1.0.0
 */

function drop_down_search_script_enqueue_files() {
	wp_enqueue_script( 'drop-down-search-jquery', get_stylesheet_directory_uri() . '/jquery-3.1.1.min.js', array( 'jquery' ));
	wp_enqueue_script( 'drop-down-search', get_stylesheet_directory_uri() . '/drop_down_search.js', array( 'jquery' ));
}
add_action( 'wp_footer', 'drop_down_search_script_enqueue_files' );
