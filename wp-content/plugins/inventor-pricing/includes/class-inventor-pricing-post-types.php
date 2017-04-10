<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Pricing_Post_Types
 *
 * @class Inventor_Pricing_Post_Types
 * @package Inventor_Pricing/Classes
 * @author Pragmatic Mates
 */
class Inventor_Pricing_Post_Types {
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
		require_once INVENTOR_PRICING_DIR . 'includes/post-types/class-inventor-pricing-post-type-pricing-table.php';
	}
}

Inventor_Pricing_Post_Types::init();
