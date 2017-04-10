<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_UI_Kit_Widget_Slider
 *
 * @class Inventor_UI_Kit_Widget_Slider
 * @package Inventor_UI_Kit/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_UI_Kit_Widget_Slider extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     */
    function __construct() {
        parent::__construct(
            'inventor_slider',
            __( 'Slider', 'inventor-ui-kit' ),
            array(
                'description' => __( 'Displays slider.', 'inventor-ui-kit' ),
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
        $settings = get_option( 'widget_inventor_slider' );

        if ( is_array( $settings ) ) {
            foreach ( $settings as $key => $value ) {
                if ( is_active_widget( false, 'inventor_slider-' . $key, 'inventor_slider' ) ) {
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
        if ( class_exists( 'Inventor' ) ) {
            include Inventor_Template_Loader::locate( 'widgets/slider', INVENTOR_UI_KIT_DIR );
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
            include Inventor_Template_Loader::locate( 'widgets/slider-admin', INVENTOR_UI_KIT_DIR );
            include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
        }
    }
}