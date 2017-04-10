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
 * Class Superlist_Widget_Simple_Map
 *
 * @class Superlist_Widget_Simple_Map
 * @package Superlist/Widgets
 * @author Pragmatic Mates
 */
class Superlist_Widget_Simple_Map extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'simple_map',
			__( 'Simple Map', 'superlist' ),
			array(
				'description' => __( 'Displays 1 place in the map.', 'superlist' ),
			)
		);
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
		include 'templates/widget-simple-map.php';
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
		include 'templates/widget-simple-map-admin.php';
		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}
