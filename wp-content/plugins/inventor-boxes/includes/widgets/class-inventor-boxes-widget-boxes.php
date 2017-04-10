<?php
/**
 * Widget definition file
 *
 * @package Invento_Boxes
 * @subpackage Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Boxes_Widget_Boxes
 *
 * @class Inventor_Boxes_Widget_Boxes
 * @package Inventor_Boxes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Boxes_Widget_Boxes extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'inventor_boxes',
			__( 'Boxes', 'inventor-boxes' ),
			array(
				'description' => __( 'Displays information boxes.', 'inventor-boxes' ),
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
		$boxes = array();

		for ( $i = 1; $i <= 4; $i++ ) {
			$params = array(
				'title',
				'content',
				'icon',
				'number',
				'link',
				'background_image',
				'css_class'
			);

			$box = array();

			foreach ( $params as $param ) {
				$param_id = $param . '_' . $i;
				$box[ $param ] = empty( $instance[ $param_id ] ) ? '' : $instance[ $param_id ];
			}

			if (
				! empty ( $box[ 'title' ] ) ||
				! empty ( $box[ 'content' ] ) ||
				! empty ( $box[ 'icon' ] ) ||
				! empty ( $box[ 'number' ] )
			) {
				$boxes[] = $box;
			}
		}

		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/boxes', INVENTOR_BOXES_DIR );
		}
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
		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/boxes-admin', INVENTOR_BOXES_DIR );
			include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}