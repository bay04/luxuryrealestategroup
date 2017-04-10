<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Customizations
 *
 * @access public
 * @package Inventor/Classes/Customizations
 * @return void
 */
class Inventor_Customizations {
	/**
	 * Initialize customizations
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'customize_register', array( __CLASS__, 'types' ) );
		self::includes();
	}

	/**
	 * Register new types for customizer
	 *
	 * @return void
	 */
	public static function types() {
		require_once INVENTOR_DIR . 'includes/customizations/class-inventor-customizations-types.php';
	}

	/**
	 * Include all customizations
	 *
	 * @access public
	 * @return void
	 */
	public static function includes() {
		require_once INVENTOR_DIR . 'includes/customizations/class-inventor-customizations-general.php';
		require_once INVENTOR_DIR . 'includes/customizations/class-inventor-customizations-currency.php';
		require_once INVENTOR_DIR . 'includes/customizations/class-inventor-customizations-measurement.php';
		require_once INVENTOR_DIR . 'includes/customizations/class-inventor-customizations-pages.php';
		require_once INVENTOR_DIR . 'includes/customizations/class-inventor-customizations-users.php';
		require_once INVENTOR_DIR . 'includes/customizations/class-inventor-customizations-wire-transfer.php';
	}
}

Inventor_Customizations::init();