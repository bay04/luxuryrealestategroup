<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Scripts
 *
 * @class Inventor_Scripts
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Scripts {
	/**
	 * Initialize scripts
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_backend' ) );

		// available since WordPress 4.1
		add_filter( 'script_loader_tag', array( __CLASS__, 'load_scripts_asynchronously' ), 10, 2 );
	}

	/**
	 * Loads JavaScript files asynchronously using async defer attributes
	 *
	 * @access public
	 * @param $tag
	 * @param $handle
	 * @return string
	 */
	public static function load_scripts_asynchronously( $tag, $handle ) {
		$asynchronous_scripts = apply_filters( 'inventor_asynchronous_scripts', array() );
		return in_array( $handle, $asynchronous_scripts ) ? str_replace( ' src', ' async defer src', $tag ) : $tag;
	}

	/**
	 * Loads frontend files
	 *
	 * @access public
	 * @return void
	 */
	public static function enqueue_frontend() {
		wp_enqueue_script( 'inventor', plugins_url( '/inventor/assets/js/inventor.js' ), array( 'jquery' ), '20161208', true );
		wp_enqueue_style( 'inventor-poi', plugins_url( '/inventor/assets/fonts/inventor-poi/style.css' ) );
		wp_enqueue_script('masonry');
		wp_enqueue_script( 'js-cookie', plugins_url( '/inventor/libraries/js.cookie.js' ), array(), false, false );
		wp_enqueue_script( 'jquery-chained-remote', plugins_url( '/inventor/libraries/jquery.chained.remote.custom.min.js' ), array( 'jquery' ), false, false );
		wp_enqueue_style( 'fullcalendar', plugins_url( '/inventor/libraries/fullcalendar-3.0.1/fullcalendar.min.css' ) );
		wp_enqueue_script( 'moment', plugins_url( '/inventor/libraries/fullcalendar-3.0.1/lib/moment.min.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'fullcalendar', plugins_url( '/inventor/libraries/fullcalendar-3.0.1/fullcalendar.min.js' ), array( 'jquery' ), false, true );
	}

	/**
	 * Loads backend files
	 *
	 * @access public
	 * @return void
	 */
	public static function enqueue_backend( $hook ) {
		wp_enqueue_style( 'inventor-basic', plugins_url( '/inventor/assets/fonts/inventor-basic/style.css' ) );
		wp_enqueue_style( 'inventor-admin', plugins_url( '/inventor/assets/css/inventor-admin.css' ), array(), '20161211' );
		wp_enqueue_script( 'inventor-admin', plugins_url( '/inventor/assets/js/inventor-admin.js' ), array( 'jquery' ), '20161109', true );

		$browser_key = get_theme_mod( 'inventor_general_google_browser_key' );
		$key = empty( $browser_key ) ? '' : 'key='. $browser_key . '&';
        wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?'. $key .'libraries=weather,geometry,visualization,places,drawing' );

        if ( 'widgets.php' == $hook ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
        }

		wp_enqueue_style( 'inventor-poi', plugins_url( '/inventor/assets/fonts/inventor-poi/style.css' ) );
		wp_enqueue_script( 'jquery-chained-remote', plugins_url( '/inventor/libraries/jquery.chained.remote.custom.min.js' ), array( 'jquery' ), false, false );
	}
}

Inventor_Scripts::init();
