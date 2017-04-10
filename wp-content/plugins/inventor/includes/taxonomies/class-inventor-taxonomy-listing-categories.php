<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Taxonomy_Listing_Categories
 *
 * @class Inventor_Taxonomy_Listing_Categories
 * @package Inventor/Classes/Taxonomy
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Listing_Categories {
	/**
	 * Initialize taxonomy
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ), 12 );
		add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
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
			'name'              => __( 'Categories', 'inventor' ),
			'singular_name'     => __( 'Category', 'inventor' ),
			'search_items'      => __( 'Search Categories', 'inventor' ),
			'all_items'         => __( 'All Categories', 'inventor' ),
			'parent_item'       => __( 'Parent Category', 'inventor' ),
			'parent_item_colon' => __( 'Parent Category:', 'inventor' ),
			'edit_item'         => __( 'Edit Category', 'inventor' ),
			'update_item'       => __( 'Update Category', 'inventor' ),
			'add_new_item'      => __( 'Add New Category', 'inventor' ),
			'new_item_name'     => __( 'New Category', 'inventor' ),
			'menu_name'         => __( 'Categories', 'inventor' ),
            'not_found'         => __( 'No categories found.', 'inventor' ),
		);

		register_taxonomy( 'listing_categories', Inventor_Post_Types::get_listing_post_types(), array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'query_var'         => 'listing-category',
			'rewrite'           => array( 'slug' => _x( 'listing-category', 'URL slug', 'inventor' ) ),
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

		if ( 'listing_categories' == $taxonomy ) {
			return 'lexicon';
		}

		return $parent_file;
	}

	/**
	 * Define custom fields for listing category taxonomy
	 *
	 * @access public
	 * @return void
	 */
	public static function fields() {
		$meta_box_id = 'listing_categories_options';

		$cmb = new_cmb2_box( array(
			'id'           	=> $meta_box_id,
			'object_types' 	=> array( 'term' ),
			'taxonomies'   	=> array( 'listing_categories' ),
			'show_in_rest'	=> true,
		) );

		$cmb->add_field( array(
			'name'      => __( 'Listing Category Options', 'inventor' ),
			'id'        => 'title',
			'type'		=> 'title',
		) );

		$cmb->add_field( array( 
			'name'      => __( 'Image', 'inventor' ),
			'id'        => 'image',
			'type'		=> 'file',
		) );

		$cmb->add_field( array(
			'name'      		=> __( 'Icon', 'inventor' ),
			'id'        		=> 'poi',
			'type'      		=> 'radio_inline',
			'options'   		=> apply_filters( 'inventor_poi_icons', array() ),
			'column' 			=> true,
			'show_option_none'	=> true
		) );

		$cmb->add_field( array(
			'name'      => __( 'Color', 'inventor' ),
			'id'        => 'color',
			'type'      => 'colorpicker',
		) );

		// Post Types
		$listing_types = Inventor_Post_Types::get_listing_post_types( false, true );

		$cmb->add_field( array(
			'name'      	=> __( 'Listing types', 'inventor' ),
			'description'   => __( 'If none selected, category is available for all types.', 'inventor' ),
			'id'        	=> INVENTOR_LISTING_CATEGORY_PREFIX . 'listing_types',
			'type'      	=> 'multicheck',
			'options'   	=> $listing_types,
		) );
	}
}


Inventor_Taxonomy_Listing_Categories::init();
