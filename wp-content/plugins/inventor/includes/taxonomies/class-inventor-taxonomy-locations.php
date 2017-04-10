<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Taxonomy_Locations
 *
 * @class Inventor_Taxonomy_Locations
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Locations {
	/**
	 * Initialize taxonomy
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ), 12 );
		add_action( 'parent_file', array( __CLASS__, 'menu' ) );
	}

	/**
	 * Widget definition
	 *
	 * @access public
	 * @return void
	 */
	public static function definition() {
		$labels = array(
			'name'              => __( 'Locations', 'inventor' ),
			'singular_name'     => __( 'Location', 'inventor' ),
			'search_items'      => __( 'Search Location', 'inventor' ),
			'all_items'         => __( 'All Locations', 'inventor' ),
			'parent_item'       => __( 'Parent Location', 'inventor' ),
			'parent_item_colon' => __( 'Parent Location:', 'inventor' ),
			'edit_item'         => __( 'Edit Location', 'inventor' ),
			'update_itm'        => __( 'Update Location', 'inventor' ),
			'add_new_item'      => __( 'Add New Location', 'inventor' ),
			'new_item_name'     => __( 'New Location', 'inventor' ),
			'menu_name'         => __( 'Locations', 'inventor' ),
            'not_found'         => __( 'No locations found.', 'inventor' ),
		);

		register_taxonomy( 'locations', Inventor_Post_Types::get_listing_post_types(), array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'query_var'         => 'location',
			'rewrite'           => array( 'slug' => _x( 'location', 'URL slug', 'inventor' ), 'hierarchical' => true ),
			'public'            => true,
			'show_ui'           => true,
			'show_in_menu'	    => 'lexicon',
            'show_in_nav_menus' => true,
			'show_in_rest'      => true,
            'meta_box_cb'       => false,
			'show_admin_column' => true,
		) );
	}

	/**
	 * Set active menu for taxonomy location
	 *
	 * @access public
	 * @return string
	 */
	public static function menu( $parent_file ) {
		global $current_screen;
		$taxonomy = $current_screen->taxonomy;

		if ( 'locations' == $taxonomy ) {
			return 'lexicon';
		}

		return $parent_file;
	}
}

Inventor_Taxonomy_Locations::init();
