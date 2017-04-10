<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Testimonials_Post_Type_Testimonial
 *
 * @class Inventor_Testimonials_Post_Type_Testimonial
 * @package Inventor_Testimonials/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Testimonials_Post_Type_Testimonial {
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
			'name'                  => __( 'Testimonials', 'inventor-testimonials' ),
			'singular_name'         => __( 'Testimonial', 'inventor-testimonials' ),
			'add_new'               => __( 'Add New Testimonial', 'inventor-testimonials' ),
			'add_new_item'          => __( 'Add New Testimonial', 'inventor-testimonials' ),
			'edit_item'             => __( 'Edit Testimonial', 'inventor-testimonials' ),
			'new_item'              => __( 'New Testimonial', 'inventor-testimonials' ),
			'all_items'             => __( 'Testimonials', 'inventor-testimonials' ),
			'view_item'             => __( 'View Testimonial', 'inventor-testimonials' ),
			'search_items'          => __( 'Search Testimonials', 'inventor-testimonials' ),
			'not_found'             => __( 'No Testimonials found', 'inventor-testimonials' ),
			'not_found_in_trash'    => __( 'No Testimonials found in Trash', 'inventor-testimonials' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Testimonials', 'inventor-testimonials' ),
		);

		register_post_type( 'testimonial',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail' ),
				'public'            => false,
				'show_ui'           => true,
                'rewrite'           => array( 'slug' => _x( 'testimonials', 'URL slug', 'inventor-testimonials' ) ),
				'show_in_menu'      => class_exists( 'Inventor_Admin_Menu') ? 'inventor' : true,
				'menu_icon'         => 'dashicons-testimonial',
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
            'id'            => INVENTOR_TESTIMONIALS_PREFIX . 'details',
            'title'         => __( 'Details', 'inventor-testimonials' ),
            'object_types'  => array( 'testimonial' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $cmb->add_field( array(
            'name'              => __( 'Author', 'inventor-testimonials' ),
            'id'                => INVENTOR_TESTIMONIALS_PREFIX . 'author',
            'type'              => 'text',
        ) );
    }
}

Inventor_Testimonials_Post_Type_Testimonial::init();