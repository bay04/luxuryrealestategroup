<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Listing_Slider_Extend
 *
 * @class Inventor_Listing_Slider_Extend
 * @package Inventor_Listing_Slider/Classes
 * @author Pragmatic Mates
 */
class Inventor_Listing_Slider_Extend {
	/**
	 * Initialize scripts
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'cmb2_admin_init', array( __CLASS__, 'add_image_slider_field' ), 9999 );
	}

	public static function add_image_slider_field( $metaboxes ) {
		$cmb = new_cmb2_box( array(
			'id'            => INVENTOR_LISTING_PREFIX . 'listing_slider',
			'title'         => __( 'Image in listing slider', 'inventor-listing-slider' ),
			'object_types'  => Inventor_Post_Types::get_listing_post_types(),
			'context'       => 'side',
			'priority'      => 'low',
			'skip'          => true,
		) );

		$cmb->add_field( array(
			'id'                => INVENTOR_LISTING_PREFIX  . 'listing_slider_image',
			'type'              => 'file',
		) );
	}
}

Inventor_Listing_Slider_Extend::init();

