<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_FAQ_Widgets
 *
 * @class Inventor_FAQ_Widgets
 * @package Inventor_FAQ/Classes
 * @author Pragmatic Mates
 */
class Inventor_FAQ_Widgets {
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
		require_once INVENTOR_FAQ_DIR . 'includes/widgets/class-inventor-faq-widget-faq.php';
	}

	/**
	 * Register widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function register() {
		register_widget( 'Inventor_FAQ_Widget_FAQ' );
	}
}

Inventor_FAQ_Widgets::init();