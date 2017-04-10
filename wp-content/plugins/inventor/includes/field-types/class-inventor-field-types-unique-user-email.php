<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Field_Types_Unique_User_Email
 *
 * @access public
 * @package Inventor/Classes/Field_Types
 * @return void
 */
class Inventor_Field_Types_Unique_User_Email {
    /**
	 * Initialize customizations
	 *
	 * @access public
	 * @return void
	 */
    public static function init() {
        add_action( 'cmb2_render_text_unique_user_email', array( __CLASS__, 'render' ), 10, 5 );
        add_filter( 'cmb2_sanitize_text_unique_user_email', array( __CLASS__, 'sanitize' ), 10, 5 );
    }

    /**
     * Adds new field type
     *
     * @access public
     * @param $field
     * @param $value
     * @param $object_id
     * @param $object_tyoe
     * @param $field_type_object
     * @return void
     */
    public static function render( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
        echo $field_type_object->input( array( 'type' => 'email' ) );
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
    public static function sanitize( $override_value, $value, $object_id, $field_args, $sanitizer_object ) {
        $old_value = $sanitizer_object->field->value;
        $object_type = $sanitizer_object->field->object_type;

        if( $object_type != 'user' ) {
            return $value;
        }

        // not an email?
        if ( ! is_email( $value ) ) {
            Inventor_Utilities::show_message( 'danger', __( 'Invalid E-mail value.', 'inventor' ) );
            return $old_value;
        }

        $user_with_email = email_exists( $value );
        if( $user_with_email && $user_with_email != $object_id ) {
            // message
            Inventor_Utilities::show_message( 'danger', __( 'E-mail already exists.', 'inventor' ) );
            return $old_value;
        }

        if( $object_type == 'user' ) {
            wp_update_user( array( 'ID' => $object_id, 'user_email' => $value ) );
        }

        return $value;
    }
}

Inventor_Field_Types_Unique_User_Email::init();
