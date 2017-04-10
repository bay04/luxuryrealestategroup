<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Testimonials_Post_Types
 *
 * @class Inventor_Testimonials_Post_Types
 * @package Inventor_Testimonials/Classes
 * @author Pragmatic Mates
 */
class Inventor_Testimonials_Post_Types {
	/**
	 * Initialize post types
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		self::includes();
	}

	/**
	 * Loads post types
	 *
	 * @access public
	 * @return void
	 */
	public static function includes() {
		require_once INVENTOR_TESTIMONIALS_DIR . 'includes/post-types/class-inventor-testimonials-post-type-testimonial.php';
	}
}

Inventor_Testimonials_Post_Types::init();
