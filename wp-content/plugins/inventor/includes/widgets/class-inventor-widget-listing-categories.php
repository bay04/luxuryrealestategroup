<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Widget_Listing_Categories
 *
 * @class Inventor_Widget_Listing_Categories
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Listing_Categories extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'listing_categories',
			__( 'Listing Categories', 'inventor' ),
			array(
				'description' => __( 'Displays listing categories.', 'inventor' ),
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
		$data = array(
			'hide_empty'    => false,
			'parent'        => 0
		);

		if ( ! empty( $instance['listing_categories'] ) && is_array( $instance['listing_categories'] ) && count( $instance['listing_categories'] ) > 0 ) {
			$data['include'] = implode( ',', $instance['listing_categories'] );
		}

		$terms = get_terms( 'listing_categories', $data );

		$appearance = empty( $instance['appearance'] ) ? 'tabs' : $instance['appearance'];

		if ( 'tabs' == $appearance ) {
			include Inventor_Template_Loader::locate( 'widgets/listing-categories-tabs' );
		}

		if ( 'cards' == $appearance ) {
			include Inventor_Template_Loader::locate( 'widgets/listing-categories-cards' );
		}

		wp_reset_query();
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
		include Inventor_Template_Loader::locate( 'widgets/listing-categories-admin' );
		include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
		include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
	}
}