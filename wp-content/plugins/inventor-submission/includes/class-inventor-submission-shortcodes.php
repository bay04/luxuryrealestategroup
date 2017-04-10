<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Submission_Shortcodes
 *
 * @class Inventor_Submission_Shortcodes
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Submission_Shortcodes {
    /**
     * Initialize shortcodes
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_shortcode( 'inventor_submission', array( __CLASS__, 'submission' ) );
        add_shortcode( 'inventor_submission_steps', array( __CLASS__, 'submission_steps' ) );
        add_shortcode( 'inventor_submission_remove', array( __CLASS__, 'submission_remove' ) );
        add_shortcode( 'inventor_submission_list', array( __CLASS__, 'submission_list' ) );
    }

    /**
     * Submission steps
     *
     * @param $atts
     * @param $atts|array
     * @return string
     */
    public static function submission_steps( $atts = array() ) {
        $post_type = ! empty( $_GET['type'] ) ? $_GET['type'] : null;
        $steps = Inventor_Submission_Logic::get_submission_steps( $post_type );
        $steps_keys = array_keys( $steps );
        $first_step = ( is_array( $steps ) && count( $steps ) > 0 ) ? $steps_keys[0] : null;
        $current_step = ! empty( $_GET['step'] ) ? $_GET['step'] : $first_step;

        return Inventor_Template_Loader::load( 'submission/steps', array(
            'steps'         => $steps,
            'post_type'     => $post_type,
            'current_step'  => $current_step,
        ), INVENTOR_SUBMISSION_DIR );
    }

    /**
     * Frontend submission
     *
     * @access public
     * @param $atts|array
     * @return string|null
     */
    public static function submission( $atts = array() ) {
        if ( ! is_user_logged_in() ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed' );
            return null;
        }

        $object_id = ! empty( $_GET['id'] ) ? $_GET['id'] : false;
        if ( empty( $post_id ) && ! empty( $_POST['object_id'] ) ) {
            $object_id = $_POST['object_id'];
        }

        if ( empty( $object_id ) && ! Inventor_Submission_Logic::is_allowed_to_add_submission( get_current_user_id() ) ) {
            $args = array();

            if( class_exists( 'Inventor_Packages' ) ) {
                $args['message'] = __( 'Check your package.', 'inventor-submission' );  // TODO: move to inventor-packages or use filter
            }

            echo Inventor_Template_Loader::load( 'misc/not-allowed' , $args );

            return null;
        }

        // Post type
        $post_type = ! empty( $_GET['type'] ) ? $_GET['type'] : null;

        // Post type reference in URL not found
        if ( empty( $post_type ) ) {
            return Inventor_Template_Loader::load( 'submission/type-not-found', array(), INVENTOR_SUBMISSION_DIR );
        }

        // Post type object
        $post_type_object = get_post_type_object( $post_type );

        $allowed_post_types = apply_filters( 'inventor_submission_allowed_listing_post_types', Inventor_Post_Types::get_listing_post_types() );

        if ( ! in_array( $post_type, $allowed_post_types ) && ! $object_id ) {
           return __( 'You are not allowed to submit this type.', 'inventor-submission' );
        }

        // if object_id is empty, user wants to submit new post
        if ( empty( $object_id ) ) {
            $object_id = 'fake-id';
        }

        $steps = Inventor_Submission_Logic::get_submission_steps( $post_type );

        // No steps defined for current post type
        if ( is_array( $steps ) && count( $steps ) == 0 ) {
            return Inventor_Template_Loader::load( 'submission/steps-not-found', array(), INVENTOR_SUBMISSION_DIR );
        }

        $steps_keys = array_keys( $steps );
        $current_step = ! empty( $_GET['step'] ) ? $_GET['step'] : $steps_keys[0];

        if ( array_key_exists( $current_step, $steps ) ) {
            $metabox_id = $steps[ $current_step ]['metabox_id'];
        } else {
            $metabox_id = Inventor_Metaboxes::get_metabox_id( $current_step, $_GET['type'] );
        }

        $meta_box = cmb2_get_metabox( $metabox_id, $object_id );
        $icons = apply_filters( 'inventor_poi_icons', array() );
        $listing_type_icon = ! empty( $post_type_object->labels->icon ) && array_key_exists( $post_type_object->labels->icon, $icons ) ? $icons[ $post_type_object->labels->icon ] : null;
        $single_step = get_theme_mod( 'inventor_submission_single_step', false );

        $title = Inventor_Template_Loader::load( 'submission/step-title', array(
            'steps'         		=> $steps,
            'current_step'  		=> $current_step,
            'listing_type_title'	=> $post_type_object->labels->singular_name,
            'listing_type_icon' 	=> $listing_type_icon,
            'single_step' 	        => $single_step
        ), INVENTOR_SUBMISSION_DIR );

        $is_last_step = $current_step == $steps_keys[ count( $steps_keys ) - 1 ];
        $save_button = empty( $_GET['id'] ) ? ( $is_last_step ? __( 'Done', 'inventor-submission' ) : __( 'Proceed to next step', 'inventor-submission' ) ) : __( 'Save', 'inventor-submission' );
        $action = empty( $_GET['id'] ) ? ( $is_last_step ? 'save' : '' ) : 'save';
        $icon_class = empty( $_GET['id'] ) ? ( $is_last_step ? 'done' : 'next' ) : 'save';

        $submit_button = '
        <div class="input-group submit-group">
            <input type="hidden" name="action" value="'. $action . '">
            <input type="submit" name="submit-submission" value="%4$s" class="button">
            <span class="input-group-addon"><i class="'. $icon_class .'"></i></span>
        </div>';

        return cmb2_get_metabox_form( $meta_box, $object_id, array(
            'form_format' => '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="cmb-form submission-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"> ' . $title . '<input type="hidden" name="object_id" value="%2$s">%3$s'. $submit_button .'</form>',
            'save_button' => $save_button,
        ) );
    }

    /**
     * Remove listing
     *
     * @access public
     * @param $atts|array
     * @return void
     */
    public static function submission_remove( $atts = array() ) {
        if ( ! is_user_logged_in() || empty( $_GET['id'] ) ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed' );
            return;
        }

        $post = get_post( $_GET['id'] );
        if ( empty( $post ) ) {
            echo Inventor_Template_Loader::load( 'misc/object-does-not-exist' );
            return;
        }

        $is_allowed = Inventor_Utilities::is_allowed_to_remove( get_current_user_id(), $_GET['id'] );
        if ( ! $is_allowed ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed' );
            return;
        }

        $atts = array(
            'listing' => Inventor_Post_Types::get_listing( $_GET['id'] )
        );

        echo Inventor_Template_Loader::load( 'submission/remove-form', $atts, INVENTOR_SUBMISSION_DIR );
    }

    /**
     * List of user listings
     *
     * @access public
     * @param $atts
     * @return void|string
     */
    public static function submission_list( $atts = array() ) {
        if ( ! is_user_logged_in() ) {
            return Inventor_Template_Loader::load( 'misc/not-allowed' );
        }

        return Inventor_Template_Loader::load( 'submission/list', array(), INVENTOR_SUBMISSION_DIR );
    }
}

Inventor_Submission_Shortcodes::init();
