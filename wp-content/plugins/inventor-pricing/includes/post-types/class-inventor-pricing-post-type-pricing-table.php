<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Pricing_Post_Type_Pricing_Table
 *
 * @class Inventor_Pricing_Post_Type_Pricing_Table
 * @package Inventor_Pricing/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Pricing_Post_Type_Pricing_Table {
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
            'name'                  => __( 'Pricing Tables', 'inventor-pricing' ),
			'singular_name'         => __( 'Pricing Table', 'inventor-pricing' ),
			'add_new'               => __( 'Add New Pricing Table', 'inventor-pricing' ),
			'add_new_item'          => __( 'Add New Pricing Table', 'inventor-pricing' ),
			'edit_item'             => __( 'Edit Pricing Table', 'inventor-pricing' ),
			'new_item'              => __( 'New Pricing Table', 'inventor-pricing' ),
			'all_items'             => __( 'Pricing Tables', 'inventor-pricing' ),
			'view_item'             => __( 'View Pricing Table', 'inventor-pricing' ),
			'search_items'          => __( 'Search Pricing Table', 'inventor-pricing' ),
			'not_found'             => __( 'No Pricing Tables found', 'inventor-pricing' ),
			'not_found_in_trash'    => __( 'No Pricing Tables found in Trash', 'inventor-pricing' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Pricing Tables', 'inventor-pricing' ),
        );

		register_post_type( 'pricing_table',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title' ),
				'public'            => true,
                'has_archive'       => true,
                'rewrite'           => array( 'slug' => _x( 'pricing', 'URL slug', 'inventor-pricing' ) ),
				'show_ui'           => true,
                'show_in_menu'      => class_exists( 'Inventor_Admin_Menu') ? 'inventor' : true,
				'menu_icon'         => 'dashicons-list-view',
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
        new_cmb2_box( array(
            'id'                    => INVENTOR_PRICING_PREFIX . 'general',
            'title'                 => __( 'General Options', 'inventor-pricing' ),
            'object_types'          => array( 'pricing_table' ),
            'context'               => 'normal',
            'priority'              => 'high',
            'show_names'            => true,
            'show_in_rest'          => true,
            'fields'                => array(
                array(
                    'id'                => INVENTOR_PRICING_PREFIX . 'price',
                    'name'              => __( 'Price', 'inventor-pricing' ),
                    'type'              => 'text_money',
                    'before_field'      => Inventor_Price::default_currency_symbol(),
                    'sanitization_cb'   => false,
                    'description'       => sprintf( __( 'In %s. Will be ignored, if package and payment page are set.', 'inventor-pricing' ), Inventor_Price::default_currency_code() ),
                    'attributes'		=> array(
                        'type'				=>	'number',
                        'step'				=> 	'any',
                        'min'				=> 	0,
                        'pattern'			=> 	'\d*(\.\d*)?',
                    )
                ),
                array(
                    'id'   => INVENTOR_PRICING_PREFIX . 'description',
                    'name' => __( 'Description', 'inventor-pricing' ),
                    'type' => 'text_medium',
                ),
                array(
                    'id'   => INVENTOR_PRICING_PREFIX . 'button_text',
                    'name' => __( 'Button Text', 'inventor-pricing' ),
                    'type' => 'text_medium',
                ),
                array(
                    'id'   => INVENTOR_PRICING_PREFIX . 'button_url',
                    'name' => __( 'Button Link', 'inventor-pricing' ),
                    'type' => 'text_url',
                    'description'   => __( 'Will be ignored, if package (not trial) and payment page are set.', 'inventor-pricing' ),
                ),
                array(
                    'id'   => INVENTOR_PRICING_PREFIX . 'highlighted',
                    'name' => __( 'Highlight Table?', 'inventor-pricing' ),
                    'type' => 'checkbox',
                )
            ),
		) );

        new_cmb2_box( array(
            'id'                    => INVENTOR_PRICING_PREFIX . 'pricing_items',
            'title'                 => __( 'Pricing Table Items', 'inventor-pricing' ),
            'object_types'          => array( 'pricing_table' ),
            'context'               => 'normal',
            'priority'              => 'high',
            'show_names'            => true,
            'show_in_rest'          => true,
            'fields'                => array(
                array(
                    'name'          => __( 'Item (row)', 'inventor-pricing' ),
                    'id'            => INVENTOR_PRICING_PREFIX . 'items',
                    'type'          => 'text',
                    'repeatable'    => true,
                    'sanitization_cb'   => false,
                ),
            ),
        ) );
    }
}

Inventor_Pricing_Post_Type_Pricing_Table::init();