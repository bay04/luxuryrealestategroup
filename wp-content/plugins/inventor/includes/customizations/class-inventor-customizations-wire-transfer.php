<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Customizations_Wire_Transfer
 *
 * @class Inventor_Customizations_Wire_Transfer
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Customizations_Wire_Transfer {
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
	 * Returns control label by its id
	 *
	 * @access public
	 * @param string $id
	 * @return string
	 */
	public static function get_control_label( $id ) {
		$labels = array(
			'inventor_wire_transfer_account_number' => __( 'Account number', 'inventor' ),
			'inventor_wire_transfer_swift' => __( 'Bank code', 'inventor' ),
			'inventor_wire_transfer_full_name' => __( 'Full name', 'inventor' ),
			'inventor_wire_transfer_street' => __( 'Street / P.O.Box', 'inventor' ),
			'inventor_wire_transfer_postcode' => __( 'Postcode', 'inventor' ),
			'inventor_wire_transfer_city' => __( 'City', 'inventor' ),
			'inventor_wire_transfer_country' => __( 'Country', 'inventor' ),
		);

		return array_key_exists( $id, $labels ) ? $labels[ $id ] : $id;
	}

	/**
	 * Customizations
	 *
	 * @access public
	 * @param object $wp_customize
	 * @return void
	 */
	public static function customizations( $wp_customize ) {
		$wp_customize->add_section( 'inventor_wire_transfer', array(
			'title'     => __( 'Inventor Wire Transfer', 'inventor' ),
			'priority'  => 1,
		) );

		// Account number
		$wp_customize->add_setting( 'inventor_wire_transfer_account_number', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_wire_transfer_account_number', array(
			'label'         => self::get_control_label( 'inventor_wire_transfer_account_number' ),
			'section'       => 'inventor_wire_transfer',
			'settings'      => 'inventor_wire_transfer_account_number',
			'description'   => __( 'Bank account number [mandatory]', 'inventor' ),
		) );

		// Bank code
		$wp_customize->add_setting( 'inventor_wire_transfer_swift', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_wire_transfer_swift', array(
			'label'         => self::get_control_label( 'inventor_wire_transfer_swift' ),
			'section'       => 'inventor_wire_transfer',
			'settings'      => 'inventor_wire_transfer_swift',
			'description'   => __( 'SWIFT or BIC of your bank [mandatory]', 'inventor' ),
		) );

		// Full name
		$wp_customize->add_setting( 'inventor_wire_transfer_full_name', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_wire_transfer_full_name', array(
			'label'         => self::get_control_label( 'inventor_wire_transfer_full_name' ),
			'section'       => 'inventor_wire_transfer',
			'settings'      => 'inventor_wire_transfer_full_name',
			'description'   => __( 'Your full name [mandatory]', 'inventor' ),
		) );

		// Street
		$wp_customize->add_setting( 'inventor_wire_transfer_street', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_wire_transfer_street', array(
			'label'         => self::get_control_label( 'inventor_wire_transfer_street' ),
			'section'       => 'inventor_wire_transfer',
			'settings'      => 'inventor_wire_transfer_street',
			'description'   => __( 'Enter your street.', 'inventor' ),
		) );

		// Postcode
		$wp_customize->add_setting( 'inventor_wire_transfer_postcode', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_wire_transfer_postcode', array(
			'label'         => self::get_control_label( 'inventor_wire_transfer_postcode' ),
			'section'       => 'inventor_wire_transfer',
			'settings'      => 'inventor_wire_transfer_postcode',
			'description'   => __( 'Enter your postcode (ZIP).', 'inventor' ),
		) );

		// City
		$wp_customize->add_setting( 'inventor_wire_transfer_city', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_wire_transfer_city', array(
			'label'         => self::get_control_label( 'inventor_wire_transfer_city' ),
			'section'       => 'inventor_wire_transfer',
			'settings'      => 'inventor_wire_transfer_city',
			'description'   => __( 'Enter your city.', 'inventor' ),
		) );

		// Country
		$wp_customize->add_setting( 'inventor_wire_transfer_country', array(
			'default'           => null,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_wire_transfer_country', array(
			'label'         => self::get_control_label( 'inventor_wire_transfer_country' ),
			'section'       => 'inventor_wire_transfer',
			'settings'      => 'inventor_wire_transfer_country',
			'description'   => __( 'Enter your country [mandatory]', 'inventor' ),
		) );
	}
}

Inventor_Customizations_Wire_Transfer::init();
