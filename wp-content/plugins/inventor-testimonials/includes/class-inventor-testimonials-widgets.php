<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Testimonials_Widgets
 *
 * @class Inventor_Testimonials_Widgets
 * @package Inventor_Testimonials/Classes
 * @author Pragmatic Mates
 */
class Inventor_Testimonials_Widgets {
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
		require_once INVENTOR_TESTIMONIALS_DIR . 'includes/widgets/class-inventor-testimonials-widget-testimonials.php';
	}

	/**
	 * Register widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function register() {
		register_widget( 'Inventor_Testimonials_Widget_Testimonials' );
	}
}

Inventor_Testimonials_Widgets::init();