<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Field_Types_Opening_Hours
 *
 * @access public
 * @package Inventor/Classes/Field_Types
 * @return void
 */
class Inventor_Field_Types_Opening_Hours {
    /**
	 * Initialize customizations
	 *
	 * @access public
	 * @return void
	 */
    public static function init() {
        add_filter( 'cmb2_render_opening_hours', array( __CLASS__, 'render' ), 10, 5 );
        add_filter( 'cmb2_sanitize_opening_hours', array( __CLASS__, 'sanitize' ), 12, 4 );
    }

    /**
     * Adds new field type
     *
     * @access public
     * @param $field
     * @param $value
     * @param $object_id
     * @param $object_type
     * @param $field_type_object
     * @return void
     */
    public static function render( $field, $value, $object_id, $object_type, $field_type_object ) {
        CMB2_JS::add_dependencies( array( 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-datetimepicker' ) );

        echo Inventor_Template_Loader::load( 'controls/opening-hours', array(
            'field'             => $field,
            'value'             => $value,
            'object_id'         => $object_id,
            'object_type'       => $object_type,
            'field_type_object' => $field_type_object
        ) );
    }

    /**
     * Sanitizes the value
     *
     * @access public
     * @param $override_value
     * @param $value
     * @param $object_id
     * @param $field_args
     * @return mixed
     */
    public static function sanitize( $override_value, $value, $object_id, $field_args ) {
        return $value;
    }

    /**
     * Escapes the value
     *
     * @access public
     * @param @value
     * @return mixed
     */
    public static function escape( $value ) {
        return $value;
    }
}

Inventor_Field_Types_Opening_Hours::init();
