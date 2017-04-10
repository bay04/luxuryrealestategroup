<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Pricing_Widget_Pricing_Tables
 *
 * @class Inventor_Pricing_Widget_Pricing_Tables
 * @package Inventor_Pricing/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Pricing_Widget_Pricing_Tables extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'pricing',
			__( 'Pricing Tables', 'inventor-pricing' ),
			array(
				'description' => __( 'Displays pricing tables', 'inventor-pricing' ),
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
		query_posts( array(
			'post_type'         => 'pricing_table',
            'posts_per_page'    => -1,
		) );

		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/pricing', INVENTOR_PRICING_DIR );
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
		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/pricing-admin', INVENTOR_PRICING_DIR );
			include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}