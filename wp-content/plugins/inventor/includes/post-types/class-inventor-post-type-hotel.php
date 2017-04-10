<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Post_Type_Hotel
 *
 * @class Inventor_Post_Type_Hotel
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Hotel {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
		add_filter( 'inventor_bookings_allowed_listing_post_types', array( __CLASS__, 'allowed_booking' ) );
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
		$post_types[] = 'hotel';
		return $post_types;
	}

	/**
	 * Defines if post type can be booked
	 *
	 * @access public
	 * @param array $post_types
	 * @return array
	 */
	public static function allowed_booking( $post_types ) {
		$post_types[] = 'hotel';
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
			'name'                  => __( 'Hotels', 'inventor' ),
			'singular_name'         => __( 'Hotel', 'inventor' ),
			'add_new'               => __( 'Add New Hotel', 'inventor' ),
			'add_new_item'          => __( 'Add New Hotel', 'inventor' ),
			'edit_item'             => __( 'Edit Hotel', 'inventor' ),
			'new_item'              => __( 'New Hotel', 'inventor' ),
			'all_items'             => __( 'Hotels', 'inventor' ),
			'view_item'             => __( 'View Hotel', 'inventor' ),
			'search_items'          => __( 'Search Hotel', 'inventor' ),
			'not_found'             => __( 'No Hotels found', 'inventor' ),
			'not_found_in_trash'    => __( 'No Hotels Found in Trash', 'inventor' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Hotels', 'inventor' ),
			'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-hotel', 'hotel' )
		);

		register_post_type( 'hotel',
			array(
				'labels'            => $labels,
				'show_in_menu'	  	=> 'listings',
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => _x( 'hotels', 'URL slug', 'inventor' ) ),
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
		Inventor_Post_Types::add_metabox( 'hotel', array( 'general' ) );

        $cmb = new_cmb2_box( array(
            'id'            => INVENTOR_LISTING_PREFIX . 'hotel_details',
            'title'         => __( 'Details', 'inventor' ),
            'object_types'  => array( 'hotel' ),
            'context'       => 'normal',
            'priority'      => 'high',
			'show_in_rest'  => true,
        ) );

        $cmb->add_field( array(
            'name'              => __( 'Hotel class', 'inventor' ),
            'id'                => INVENTOR_LISTING_PREFIX  . 'hotel_class',
            'type'              => 'taxonomy_radio',
            'taxonomy'          => 'hotel_classes',
        ) );

        $cmb->add_field( array(
            'name'              => __( 'Rooms', 'inventor' ),
            'id'                => INVENTOR_LISTING_PREFIX  . 'hotel_rooms',
            'type'              => 'text_small',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
            ),
        ) );

        Inventor_Post_Types::add_metabox( 'hotel', array( 'gallery', 'banner', 'video', 'price', 'flags', 'location', 'contact', 'social', 'listing_category' ) );
    }
}

Inventor_Post_Type_Hotel::init();