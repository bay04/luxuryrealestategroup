<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_FAQ_Widget_FAQ
 *
 * @class Inventor_FAQ_Widget_FAQ
 * @package Inventor_FAQ/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_FAQ_Widget_FAQ extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'faq', __( 'FAQ', 'inventor-faq' ),
			array(
				'description' => __( 'Displays FAQ.', 'inventor-faq' ),
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
			'post_type'         => 'faq',
			'posts_per_page'    => -1,
		) );

		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/faq', INVENTOR_FAQ_DIR );
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
		if ( class_exists('Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/faq-admin', INVENTOR_FAQ_DIR );
			include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}