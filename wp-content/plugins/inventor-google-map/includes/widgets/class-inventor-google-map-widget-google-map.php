<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Google_Map_Widget_Google_Map
 *
 * @class Inventor_Google_Map_Widget_Google_Map
 * @package Inventor_Google_Map/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Google_Map_Widget_Google_Map extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'google-map',
			__( 'Google Map', 'inventor-google-map' ),
			array(
				'description' => __( 'Displays listings in the google map.', 'inventor-google-map' ),
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
		$settings = get_option( 'widget_google-map' );
		
		if ( is_array( $settings ) ) {			
			foreach ( $settings as $key => $value ) {
				if ( is_active_widget( false, 'google-map-' . $key, 'google-map' ) ) {					
					if ( ! empty( $value['body_classes'] ) ) {
						$parts   = explode( ',', $value['body_classes'] );
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
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/google-map', INVENTOR_GOOGLE_MAP_DIR );
		}
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
			include Inventor_Template_Loader::locate( 'widgets/google-map-admin', INVENTOR_GOOGLE_MAP_DIR );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}