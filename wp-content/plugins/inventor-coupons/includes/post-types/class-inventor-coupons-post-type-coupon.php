<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Coupons_Post_Type_Coupon
 *
 * @class Inventor_Coupons_Post_Type_Coupon
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Coupons_Post_Type_Coupon {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ), 11 );
		add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
	}

	/**
	 * Custom post type definition
	 *
	 * @access public
	 * @return void
	 */
	public static function definition() {
		$labels = array(
			'name'                  => __( 'Coupons', 'inventor-coupons' ),
			'singular_name'         => __( 'Coupon', 'inventor-coupons' ),
			'add_new'               => __( 'Add New Coupon', 'inventor-coupons' ),
			'add_new_item'          => __( 'Add New Coupon', 'inventor-coupons' ),
			'edit_item'             => __( 'Edit Coupon', 'inventor-coupons' ),
			'new_item'              => __( 'New Coupon', 'inventor-coupons' ),
			'all_items'             => __( 'Coupons', 'inventor-coupons' ),
			'view_item'             => __( 'View Coupon', 'inventor-coupons' ),
			'search_items'          => __( 'Search Coupon', 'inventor-coupons' ),
			'not_found'             => __( 'No Coupons found', 'inventor-coupons' ),
			'not_found_in_trash'    => __( 'No Coupons Found in Trash', 'inventor-coupons' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Coupons', 'inventor-coupons' ),
			'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-exchange', 'coupon' )
		);

		register_post_type( 'coupon',
			array(
				'labels'            => $labels,
				'show_in_menu'	    => 'listings',
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'public'            => true,
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => _x( 'coupons', 'URL slug', 'inventor-coupons' ) ),
				'show_ui'           => true,
				'categories'        => array(),
			)
		);
	}

	/**
	 * Defines custom fields
	 *
	 * @access public
	 * @return array
	 */
	public static function fields() {
		if ( ! is_admin() ) {
			Inventor_Post_Types::add_metabox( 'coupon', array( 'general' ) );
		}

		Inventor_Post_Types::add_metabox( 'coupon', array( 'Inventor_Coupons_Metaboxes::details', 'datetime_interval', 'Inventor_Coupons_Metaboxes::codes', 'gallery', 'banner', 'contact', 'faq', 'flags', 'location', 'listing_category' ) );
	}
}

Inventor_Coupons_Post_Type_Coupon::init();
