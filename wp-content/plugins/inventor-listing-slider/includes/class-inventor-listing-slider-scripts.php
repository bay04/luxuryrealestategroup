<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Listing_Slider_Scripts
 *
 * @class Inventor_Listing_Slider_Scripts
 * @package Inventor_Listing_Slider/Classes
 * @author Pragmatic Mates
 */
class Inventor_Listing_Slider_Scripts {
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
		wp_enqueue_script( 'owl-carousel', plugins_url( '/inventor-listing-slider/libraries/owl.carousel/owl.carousel.min.js' ), array( 'jquery' ), false, true );
		wp_enqueue_style( 'owl-carousel', plugins_url( '/inventor-listing-slider/libraries/owl.carousel/owl.carousel.css' ) );
	}
}

Inventor_Listing_Slider_Scripts::init();