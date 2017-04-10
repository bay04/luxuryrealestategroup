<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Partners_Post_Type_Partner
 *
 * @class Inventor_Partners_Post_Type_Partner
 * @package Inventor_Partners/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Partners_Post_Type_Partner {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'cmb2_init', array( __CLASS__, 'fields' ) );
	}

	/**
	 * Custom post type definition
	 *
	 * @access public
	 * @return void
	 */
	public static function definition() {
		$labels = array(
			'name'                  => __( 'Partners', 'inventor-partners' ),
			'singular_name'         => __( 'Partner', 'inventor-partners' ),
			'add_new'               => __( 'Add New Partner', 'inventor-partners' ),
			'add_new_item'          => __( 'Add New Partner', 'inventor-partners' ),
			'edit_item'             => __( 'Edit Partner', 'inventor-partners' ),
			'new_item'              => __( 'New Partner', 'inventor-partners' ),
			'all_items'             => __( 'Partners', 'inventor-partners' ),
			'view_item'             => __( 'View Partner', 'inventor-partners' ),
			'search_items'          => __( 'Search Partner', 'inventor-partners' ),
			'not_found'             => __( 'No Partners found', 'inventor-partners' ),
			'not_found_in_trash'    => __( 'No Partners found in Trash', 'inventor-partners' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Partners', 'inventor-partners' ),
		);

		register_post_type( 'partner',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'thumbnail' ),
				'public'            => false,
				'show_ui'           => true,
				'show_in_menu'      => class_exists( 'Inventor_Admin_Menu') ? 'inventor' : true,
				'menu_icon'         => 'dashicons-businessman',
                'menu_position'     => 55,
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
        $cmb = new_cmb2_box( array(
            'id'            => INVENTOR_PARTNERS_PREFIX  . 'url',
            'title'         => __( 'URL', 'inventor-partners' ),
            'object_types'  => array( 'partner' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $cmb->add_field( array(
            'name'              => __( 'URL', 'inventor-partners' ),
            'id'                => INVENTOR_PARTNERS_PREFIX  . 'url',
            'type'              => 'text_url',
        ) );
	}
}

Inventor_Partners_Post_Type_Partner::init();