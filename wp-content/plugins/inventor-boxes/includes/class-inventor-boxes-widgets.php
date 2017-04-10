<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Boxes_Widgets
 *
 * @class Inventor_Boxes_Widgets
 * @package Inventor_Boxes/Classes
 * @author Pragmatic Mates
 */
class Inventor_Boxes_Widgets {
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
		require_once INVENTOR_BOXES_DIR . 'includes/widgets/class-inventor-boxes-widget-boxes.php';
	}

	/**
	 * Register widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function register() {
		register_widget( 'Inventor_Boxes_Widget_Boxes' );
	}
}

Inventor_Boxes_Widgets::init();