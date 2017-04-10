<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Pricing_Widgets
 *
 * @class Inventor_Pricing_Widgets
 * @package Inventor_Pricing/Classes
 * @author Pragmatic Mates
 */
class Inventor_Pricing_Widgets {
	/**
	 * Initialize widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		self::includes();
		add_action( 'widgets_init', array( __CLASS__, 'register' ) );
	}

	/**
	 * Include widget classes
	 *
	 * @access public
	 * @return void
	 */
	public static function includes() {
		require_once INVENTOR_PRICING_DIR . 'includes/widgets/class-inventor-pricing-widget-pricing-tables.php';
	}

	/**
	 * Register widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function register() {
		register_widget( 'Inventor_Pricing_Widget_Pricing_Tables' );
	}
}

Inventor_Pricing_Widgets::init();