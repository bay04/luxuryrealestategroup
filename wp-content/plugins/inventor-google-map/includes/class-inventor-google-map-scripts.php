<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Google_Map_Scripts
 *
 * @class Inventor_Google_Map_Scripts
 * @package Inventor_Google_Map/Classes
 * @author Pragmatic Mates
 */
class Inventor_Google_Map_Scripts {
	/**
	 * Initialize scripts
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
	}

	/**
	 * Loads frontend files
	 *
	 * @access public
	 * @return void
	 */
	public static function enqueue_frontend() {
		$browser_key = get_theme_mod( 'inventor_general_google_browser_key' );
		$key = empty( $browser_key ) ? '' : 'key='. $browser_key . '&';

//		wp_enqueue_script( 'mapescape', plugins_url( '/inventor-google-map/libraries/mapescape/js/mapescape.js' ), array( 'jquery' ), false, true );
//		wp_enqueue_style( 'mapescape.css', plugins_url( '/inventor-google-map/libraries/mapescape/css/mapescape.css' ) );

		wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?'. $key .'libraries=weather,geometry,visualization,places,drawing' );
		wp_enqueue_script( 'infobox', plugins_url( '/inventor-google-map/libraries/jquery-google-map/infobox.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'markerclusterer', plugins_url( '/inventor-google-map/libraries/jquery-google-map/markerclusterer.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'cookie', plugins_url( '/inventor-google-map/libraries/js-cookie.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'jquery-google-map', plugins_url( '/inventor-google-map/libraries/jquery-google-map/jquery-google-map.js' ), array( 'jquery' ), '20161208', true );
		wp_enqueue_script( 'inventor-google-map', plugins_url( '/inventor-google-map/assets/js/inventor-google-map.js' ), array( 'jquery' ), '20161206', true );
	}
}

Inventor_Google_Map_Scripts::init();