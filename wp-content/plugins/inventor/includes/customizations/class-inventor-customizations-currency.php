<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Customizations_Currency
 *
 * @class Inventor_Customizations_Currency
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Customizations_Currency {
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
		$wp_customize->add_section( 'inventor_currencies[0]', array(
			'title'     => __( 'Inventor Currency', 'inventor' ),
			'priority'  => 1,
		) );

		// Currency symbol
		$wp_customize->add_setting( 'inventor_currencies[0][symbol]', array(
			'default'           => '$',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_currencies[0][symbol]', array(
			'label'     => __( 'Currency Symbol', 'inventor' ),
			'section'   => 'inventor_currencies[0]',
			'settings'  => 'inventor_currencies[0][symbol]',
		) );

		// Currency code
		$wp_customize->add_setting( 'inventor_currencies[0][code]', array(
			'default'           => 'USD',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_currencies[0][code]', array(
			'label'     => __( 'Currency Code', 'inventor' ),
			'section'   => 'inventor_currencies[0]',
			'settings'  => 'inventor_currencies[0][code]',
		) );

		// Show after
		$wp_customize->add_setting( 'inventor_currencies[0][show_after]', array(
			'default'           => false,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_currencies[0][show_after]', array(
			'type'      => 'checkbox',
			'label'     => __( 'Show Symbol After Amount', 'inventor' ),
			'section'   => 'inventor_currencies[0]',
			'settings'  => 'inventor_currencies[0][show_after]',
		) );

		// Decimal places
		$wp_customize->add_setting( 'inventor_currencies[0][money_decimals]', array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inventor_currencies[0][money_decimals]', array(
			'label'         => __( 'Decimal places', 'inventor' ),
			'section'       => 'inventor_currencies[0]',
			'settings'      => 'inventor_currencies[0][money_decimals]',
			'type'          => 'select',
			'choices'       => array(
				0               => '0',
				1               => '1',
				2               => '2',
			),
		) );

		// Decimal Separator
		$wp_customize->add_setting( 'inventor_currencies[0][money_dec_point]', array(
			 'default'           => '.',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_currencies[0][money_dec_point]', array(
			'label'         => __( 'Decimal Separator', 'inventor' ),
			'section'       => 'inventor_currencies[0]',
			'settings'      => 'inventor_currencies[0][money_dec_point]',
			'type'          => 'select',
			'choices'       => array(
				'.'               => __ ( '. (dot)', 'inventor-currencies' ),
				','               => __ ( ', (comma)', 'inventor-currencies' ),
			),
		) );

		// Thousands Separator
		$wp_customize->add_setting( 'inventor_currencies[0][money_thousands_separator]', array(
			'default'           => ',',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'inventor_currencies[0][money_thousands_separator]', array(
			'label'         => __( 'Thousands Separator', 'inventor' ),
			'section'       => 'inventor_currencies[0]',
			'settings'      => 'inventor_currencies[0][money_thousands_separator]',
			'type'          => 'select',
			'choices'       => array(
				'.'               => __ ( '. (dot)', 'inventor-currencies' ),
				','               => __ ( ', (comma)', 'inventor-currencies' ),
				'space'           => __ ( '" " (space)', 'inventor-currencies' ),
				''                => __ ( '"" (empty string)', 'inventor-currencies' ),
			),
		) );
	}
}

Inventor_Customizations_Currency::init();
