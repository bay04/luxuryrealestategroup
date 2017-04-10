<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Customizations_General
 *
 * @class Inventor_Customizations_General
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Customizations_General {
	/**
	 * Initialize customization type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'customize_register', array( __CLASS__, 'customizations' ) );
	}

	/**
	 * Customizations
	 *
	 * @access public
	 * @param object $wp_customize
	 * @return void
	 */
	public static function customizations( $wp_customize ) {
		$wp_customize->add_section( 'inventor_general', array(
			'title' 	=> __( 'Inventor General', 'inventor' ),
			'priority' 	=> 1,
		) );	

		// Post Types
		$all_post_types = Inventor_Post_Types::get_all_listing_post_types();
		$post_types = array();

		if ( is_array( $post_types ) ) {
			foreach ( $all_post_types as $obj ) {
				if ( apply_filters( 'inventor_listing_type_supported', true, $obj->name ) ) {
					$post_types[ $obj->name ] = $obj->labels->name;
				}
			}
		}

		$wp_customize->add_setting( 'inventor_general_post_types', array(
			'default'           => array_keys( $post_types ),
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'Inventor_Customize_Control_Checkbox_Multiple', 'sanitize' ),
		) );

		$wp_customize->add_control( new Inventor_Customize_Control_Checkbox_Multiple(
			$wp_customize,
			'inventor_general_post_types',
			array(
				'section'       => 'inventor_general',
				'label'         => __( 'Post types', 'inventor' ),
				'choices'       => $post_types,
				'description'   => __( 'After changing post types make sure that your resave permalinks in "Settings - Permalinks"', 'inventor' ),
			)
		) );

		// Banner Types
		$banner_types = apply_filters( 'inventor_metabox_banner_types', array() );

		$wp_customize->add_setting( 'inventor_general_banner_types', array(
			'default'           => array_keys( $banner_types ),
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( 'Inventor_Customize_Control_Checkbox_Multiple', 'sanitize' ),
		) );

		$wp_customize->add_control( new Inventor_Customize_Control_Checkbox_Multiple(
			$wp_customize,
			'inventor_general_banner_types',
			array(
				'section'       => 'inventor_general',
				'label'         => __( 'Listing banner types', 'inventor' ),
				'choices'       => $banner_types,
				'description'   => __( 'List of available banner types for listings', 'inventor' ),
			)
		) );

		// Default listing banner type
		$wp_customize->add_setting( 'inventor_general_default_banner_type', array(
			'default'           => 'banner_featured_image',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_default_banner_type', array(
			'type'          => 'select',
			'label'         => __( 'Default listing banner type', 'inventor' ),
			'description'	=> __( 'Has to be one of the enabled above', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_general_default_banner_type',
			'choices'		=> $banner_types
		) );

		// Listing map type
		$wp_customize->add_setting( 'inventor_general_listing_map_type', array(
			'default'           => 'ROADMAP',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_listing_map_type', array(
			'type'          => 'select',
			'label'         => __( 'Listing map type', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_general_listing_map_type',
			'choices'		=> array(
				'ROADMAP' 		=> __( 'Roadmap', 'inventor' ),
				'SATELLITE' 	=> __( 'Satellite', 'inventor' ),
				'HYBRID' 		=> __( 'Hybrid', 'inventor' ),
			)
		) );

		// Default listing sorting
		$wp_customize->add_setting( 'inventor_general_default_listing_sort', array(
			'default'           => 'published',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_default_listing_sort', array(
			'type'          => 'select',
			'label'         => __( 'Default sorting for listing archive', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_general_default_listing_sort',
			'choices'		=> apply_filters( 'inventor_filter_sort_by_choices', array() )
		) );

		// Default listing ordering by
		$wp_customize->add_setting( 'inventor_general_default_listing_order', array(
			'default'           => 'desc',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_default_listing_order', array(
			'type'          => 'select',
			'label'         => __( 'Default ordering for listing archive', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_general_default_listing_order',
			'choices'		=> array(
				'asc'			=> 'Ascending',
				'desc'			=> 'Descending',
			),
		) );

		// Maximum allowed categories per listing
		$wp_customize->add_setting( 'inventor_max_listing_categories', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_max_listing_categories', array(
			'type'          => 'text',
			'label'         => __( 'Maximum number of allowed categories per listing', 'inventor' ),
			'description'   => __( 'Keep empty for unlimited.', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_max_listing_categories',
		) );

		// Show listing archive as grid
		$wp_customize->add_setting( 'inventor_general_show_featured_image_in_gallery', array(
			'default'           => false,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_show_featured_image_in_gallery', array(
			'type'      	=> 'checkbox',
			'label'     	=> __( 'Show featured image in listing gallery', 'inventor' ),
			'description'	=> __( 'Featured image of listing will be shown in its gallery', 'inventor' ),
			'section'   	=> 'inventor_general',
			'settings'  	=> 'inventor_general_show_featured_image_in_gallery',
		) );

		// Show listing archive as grid
		$wp_customize->add_setting( 'inventor_general_show_listing_archive_as_grid', array(
			'default'           => false,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_show_listing_archive_as_grid', array(
			'type'      	=> 'checkbox',
			'label'     	=> __( 'Show listing archive as grid', 'inventor' ),
			'description'	=> __( 'Listings will be shown as box instead of row', 'inventor' ),
			'section'   	=> 'inventor_general',
			'settings'  	=> 'inventor_general_show_listing_archive_as_grid',
		) );

		// Purchase code
		$wp_customize->add_setting( 'inventor_purchase_code', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_purchase_code', array(
			'type'          => 'text',
			'label'         => __( 'Purchase code', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_purchase_code',
		) );

		// Google browser API key
		$wp_customize->add_setting( 'inventor_general_google_browser_key', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_general_google_browser_key', array(
			'type'          => 'text',
			'label'         => __( 'Google Browser Key', 'inventor' ),
			'description'   => __( 'Browser API key. Read more <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>.', 'inventor' ),
			'section'       => 'inventor_general',
			'settings'      => 'inventor_general_google_browser_key',
		) );
	}
}

Inventor_Customizations_General::init();
