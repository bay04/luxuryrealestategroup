<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Widget_Listing_Inquire
 *
 * @class Inventor_Widget_Listing_Inquire
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Listing_Inquire extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'listing_inquire',
			__( 'Listing Inquire', 'inventor' ),
			array(
				'description' => __( 'Listing inquire widget for sending inquire messages.', 'inventor' ),
			)
		);
	}

	/**
	 * Frontend
	 *
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		include Inventor_Template_Loader::locate( 'widgets/listing-inquire' );
	}

	/**
	 * Update
	 *
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Backend
	 *
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		include Inventor_Template_Loader::locate( 'widgets/listing-inquire-admin' );
		include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
		include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
	}
}