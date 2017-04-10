<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Listing_Slider_Widgets
 *
 * @class Inventor_Listing_Slider_Widgets
 * @package Inventor_Listing_Slider/Classes
 * @author Pragmatic Mates
 */
class Inventor_Listing_Slider_Widgets {
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
		require_once INVENTOR_LISTING_SLIDER_DIR . 'includes/widgets/class-inventor-listing-slider-widget-listing-slider.php';
	}

	/**
	 * Register widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function register() {
		register_widget( 'Inventor_Listing_Slider_Widget_Listing_Slider' );
	}
}

Inventor_Listing_Slider_Widgets::init();