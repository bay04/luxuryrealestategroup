<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Google_Map_Widgets
 *
 * @class Inventor_Google_Map_Widgets
 * @package Inventor_Google_Map/Classes
 * @author Pragmatic Mates
 */
class Inventor_Google_Map_Widgets {
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
		require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/widgets/class-inventor-google-map-widget-google-map.php';
	}

	/**
	 * Register widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function register() {
		register_widget( 'Inventor_Google_Map_Widget_Google_Map' );
	}

	/**
	 * Checks if the map widget is open or closed
	 *
	 * @access public
	 * @param $widget_id
	 * @param $instance
	 * @return bool
	 */
	public static function is_closed( $widget_id, $instance ) {
		// check cookie
		$cookie_id = 'map-toggle-' . $widget_id;
		$cookie_value = ! empty( $_COOKIE[ $cookie_id ] ) ? $_COOKIE[ $cookie_id ] : null;
		if ( ! empty( $cookie_value ) && 'closed' == $cookie_value ) {
			// preserve cookie state
			return true;
		}

		// if filter is set, map is open
		if ( Inventor_Filter::has_filter() ) {
			return false;
		}

		// check default value
		if ( ! empty( $instance['toggle_default'] ) && $instance['toggle_default'] == 'closed' ) {
			return true;
		}

		return false;
	}
}

Inventor_Google_Map_Widgets::init();