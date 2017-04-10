<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Testimonials_Widget_Testimonials
 *
 * @class Inventor_Testimonials_Widget_Testimonials
 * @package Inventor_Testimonials/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Testimonials_Widget_Testimonials extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'testimonials', __( 'Testimonials', 'inventor-testimonials' ),
			array(
				'description' => __( 'Displays Testimonials.', 'inventor-testimonials' ),
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
			'post_type'         => 'testimonial',
			'posts_per_page'    => ! empty( $instance['count'] ) ? $instance['count'] : 4,
		) );

		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/testimonials', INVENTOR_TESTIMONIALS_DIR );
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
			include Inventor_Template_Loader::locate( 'widgets/testimonials-admin', INVENTOR_TESTIMONIALS_DIR );
			include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}
