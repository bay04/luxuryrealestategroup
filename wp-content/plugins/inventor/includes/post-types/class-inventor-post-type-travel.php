<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Post_Type_Travel
 *
 * @class Inventor_Post_Type_Travel
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Travel {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
		add_filter( 'inventor_shop_allowed_listing_post_types', array( __CLASS__, 'allowed_purchasing' ) );
		add_filter( 'inventor_claims_allowed_listing_post_types', array( __CLASS__, 'allowed_claiming' ) );
	}

	/**
	 * Defines if post type can be claimed
	 *
	 * @access public
	 * @param array $post_types
	 * @return array
	 */
	public static function allowed_claiming( $post_types ) {
		$post_types[] = 'travel';
		return $post_types;
	}

	/**
	 * Defines if post type can be purchased
	 *
	 * @access public
	 * @param array $post_types
	 * @return array
	 */
	public static function allowed_purchasing( $post_types ) {
		$post_types[] = 'travel';
		return $post_types;
	}

	/**
	 * Custom post type definition
	 *
	 * @access public
	 * @return void
	 */
	public static function definition() {
		$labels = array(
			'name'                  => __( 'Travels', 'inventor' ),
			'singular_name'         => __( 'Travel', 'inventor' ),
			'add_new'               => __( 'Add New Travel', 'inventor' ),
			'add_new_item'          => __( 'Add New Travel', 'inventor' ),
			'edit_item'             => __( 'Edit Travel', 'inventor' ),
			'new_item'              => __( 'New Travel', 'inventor' ),
			'all_items'             => __( 'Travels', 'inventor' ),
			'view_item'             => __( 'View Travel', 'inventor' ),
			'search_items'          => __( 'Search Travel', 'inventor' ),
			'not_found'             => __( 'No Travels found', 'inventor' ),
			'not_found_in_trash'    => __( 'No Travels Found in Trash', 'inventor' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Travels', 'inventor' ),
			'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-airport', 'travel' )
		);

		register_post_type( 'travel',
			array(
				'labels'            => $labels,
				'show_in_menu'	    => 'listings',
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => _x( 'travels', 'URL slug', 'inventor' ) ),
				'public'            => true,
				'show_ui'           => true,
				'show_in_rest'      => true,
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
		$post_type = 'travel';

		Inventor_Post_Types::add_metabox( $post_type, array( 'general' ) );

		$metabox_id = INVENTOR_LISTING_PREFIX . 'travel_details';
		$metabox_title = __( 'Details', 'inventor' );

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', $metabox_title, $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', null, $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX  . 'travel_activity';
		$field_name = __( 'Travel activities', 'inventor' );
		$field_type = 'taxonomy_multicheck_hierarchy';

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
			'taxonomy'          => 'travel_activities',
		) );

        Inventor_Post_Types::add_metabox( 'travel', array( 'date_interval', 'gallery', 'banner', 'video', 'location', 'date_interval', 'price', 'contact', 'social', 'flags', 'listing_category' ) );
    }
}

Inventor_Post_Type_Travel::init();