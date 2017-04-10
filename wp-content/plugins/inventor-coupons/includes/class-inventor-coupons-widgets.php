<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Coupons_Widgets
 *
 * @class Inventor_Coupons_Widgets
 * @package Inventor_Coupons/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Coupons_Widgets {
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
		require_once INVENTOR_COUPONS_DIR . 'includes/widgets/class-inventor-coupons-widget-coupon-detail.php';
		require_once INVENTOR_COUPONS_DIR . 'includes/widgets/class-inventor-coupons-widget-coupon-listings.php';
	}

	/**
	 * Register widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function register() {
		register_widget( 'Inventor_Coupons_Widget_Coupon_Detail' );
		register_widget( 'Inventor_Coupons_Widget_Coupon_Listings' );
	}
}

Inventor_Coupons_Widgets::init();
