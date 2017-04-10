<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Customizations_Measurement
 *
 * @class Inventor_Customizations_Measurement
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Customizations_Measurement {
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
		$wp_customize->add_section( 'inventor_measurement', array(
			'title'     => __( 'Inventor Measurement', 'inventor' ),
			'priority'  => 1,
		) );

		// Area unit
		$wp_customize->add_setting( 'inventor_measurement_area_unit', array(
			'default'           => 'sqft',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_measurement_area_unit', array(
			'label'     => __( 'Area Unit', 'inventor' ),
			'section'   => 'inventor_measurement',
			'settings'  => 'inventor_measurement_area_unit',
		) );

		// Distance unit
		$wp_customize->add_setting( 'inventor_measurement_distance_unit', array(
			'default'           => 'ft',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_measurement_distance_unit', array(
			'label'             => __( 'Short Distance Unit', 'inventor' ),
			'section'           => 'inventor_measurement',
			'settings'          => 'inventor_measurement_distance_unit',
			'description'       => __( 'Example: "ft" or "m"', 'inventor' ),
		) );

		// Distance unit long
		$wp_customize->add_setting( 'inventor_measurement_distance_unit_long', array(
			'default'           => 'mi',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_measurement_distance_unit_long', array(
			'label'         => __( 'Long Distance Unit', 'inventor' ),
			'section'       => 'inventor_measurement',
			'settings'      => 'inventor_measurement_distance_unit_long',
			'description'   => __( 'Example: "mi" or "km"', 'inventor' ),
		) );

		// Weight unit
		$wp_customize->add_setting( 'inventor_measurement_weight_unit', array(
			'default'           => 'lbs',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_measurement_weight_unit', array(
			'label'         => __( 'Weight unit', 'inventor' ),
			'section'       => 'inventor_measurement',
			'settings'      => 'inventor_measurement_weight_unit',
			'description'   => __( 'Example: "lbs" or "kg"', 'inventor' ),
		) );
	}
}

Inventor_Customizations_Measurement::init();
