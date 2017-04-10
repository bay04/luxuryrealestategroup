<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Partners_Widget_Partners
 *
 * @class Inventor_Partners_Widget_Partners
 * @package Inventor_Partners/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Partners_Widget_Partners extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'partners',
			__( 'Partners', 'inventor-partners' ),
			array(
				'description' => __( 'Displays partners widget', 'inventor-partners' ),
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
		$query = array(
			'post_type'         => 'partner',
			'posts_per_page'    => ! empty( $instance['count'] ) ? $instance['count'] : 3,
		);

		if ( ! empty( $instance['ids'] ) ) {
			$ids = explode( ',', $instance['ids'] );
			$query['post__in'] = $ids;
		}

		query_posts( $query );

		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/partners', INVENTOR_PARTNERS_DIR );
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
			include Inventor_Template_Loader::locate( 'widgets/partners-admin', INVENTOR_PARTNERS_DIR );
			include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}