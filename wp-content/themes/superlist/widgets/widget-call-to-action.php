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
 * Class Superlist_Widget_Call_To_Action
 *
 * @class Superlist_Widget_Cover
 * @package Superlist/Widgets
 * @author Pragmatic Mates
 */
class Superlist_Widget_Call_To_Action extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'call_to_action',
			__( 'Call to action', 'superlist' ),
			array(
				'description' => __( 'Call to action widget.', 'superlist' ),
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
		include 'templates/widget-call-to-action.php';
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
		include 'templates/widget-call-to-action-admin.php';
		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}
