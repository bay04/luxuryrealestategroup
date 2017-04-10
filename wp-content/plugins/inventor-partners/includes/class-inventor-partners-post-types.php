<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Partners_Post_Types
 *
 * @class Inventor_Partners_Post_Types
 * @package Inventor_Partners/Classes
 * @author Pragmatic Mates
 */
class Inventor_Partners_Post_Types {
	/**
	 * Initialize property types
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		self::includes();
	}

	/**
	 * Loads property types
	 *
	 * @access public
	 * @return void
	 */
	public static function includes() {
		require_once INVENTOR_PARTNERS_DIR . 'includes/post-types/class-inventor-partners-post-type-partner.php';
	}
}

Inventor_Partners_Post_Types::init();
