<?php
/**
 * Widget definition file
 *
 * @package Superlist
 * @subpackage Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Superlist_Widget_Cover
 *
 * @class Superlist_Widget_Cover
 * @package Superlist/Widgets
 * @author Pragmatic Mates
 */
class Superlist_Widget_Video_Cover extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'video_cover',
			__( 'Video Cover', 'superlist' ),
			array(
				'description' => __( 'Displays small filter with video or image background.', 'superlist' ),
			)
		);

		add_action( 'body_class', array( __CLASS__, 'add_body_class' ) );
	}

	/**
	 * Adds classes to body
	 *
	 * @param $classes array
	 *
	 * @access public
	 * @return array
	 */
	public static function add_body_class( $classes ) {
		$settings = get_option( 'widget_video_cover' );

		if ( is_array( $settings ) ) {
			foreach ( $settings as $key => $value ) {
				if ( is_active_widget( false, 'video_cover-' . $key, 'video_cover' ) ) {
					if ( ! empty( $value['classes'] ) ) {
						$parts   = explode( ',', $value['classes'] );
						$classes = array_merge( $classes, $parts );
					}
				}
			}
		}

		return $classes;
	}

	/**
	 * Frontend
	 *
	 * @access public
	 * @param array $args Widget arguments.
	 * @param array $instance Current widget instance.
	 * @return void
	 */
	function widget( $args, $instance ) {
		include 'templates/widget-video-cover.php';
	}

	/**
	 * Update
	 *
	 * @access public
	 * @param array $new_instance New widget instance.
	 * @param array $old_instance Old widget instance.
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Backend
	 *
	 * @access public
	 * @param array $instance Current widget instance.
	 * @return void
	 */
	function form( $instance ) {
		include 'templates/widget-video-cover-admin.php';

		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}
