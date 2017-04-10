<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Paypal_Customizations
 *
 * @access public
 * @package Inventor_Paypal/Classes/Customizations
 * @return void
 */
class Inventor_Paypal_Customizations {
	/**
	 * Initialize customizations
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		self::includes();
	}

	/**
	 * Include all customizations
	 *
	 * @access public
	 * @return void
	 */
	public static function includes() {
		require_once INVENTOR_PAYPAL_DIR . 'includes/customizations/class-inventor-paypal-customizations-paypal.php';
	}
}

Inventor_PayPal_Customizations::init();