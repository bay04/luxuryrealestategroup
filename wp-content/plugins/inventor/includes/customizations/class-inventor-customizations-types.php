<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Multiple checkbox customize control class.
 *
 * @class Customize_Control_Checkbox_Multiple
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Customize_Control_Checkbox_Multiple extends WP_Customize_Control {
	public $type = 'checkbox-multiple';

	/**
	 * Sanitize
	 *
	 * @access public
	 * @param $values
	 * @return array
	 */
	public static function sanitize( $values ) {
		$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;
		return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
	}

	/**
	 * Enqueue.
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'inventor-customize-controls', plugins_url( '/inventor/assets/js/customize-controls.js' ), array( 'jquery' ) );
	}

	/**
	 * Displays the control content.
	 *
	 * @access public
	 * @return void
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		include Inventor_Template_Loader::locate( 'controls/checkbox-multiple' );
	}
}