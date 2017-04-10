<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_UI_Kit_Widgets
 *
 * @class Inventor_UI_Kit_Widgets
 * @package Inventor_Listing_Slider/Classes
 * @author Pragmatic Mates
 */
class Inventor_UI_Kit_Widgets {
    /**
     * Initialize widgets
     *
     * @access public
     * @return void
     */
    public static function init() {
        self::includes();
        add_action( 'widgets_init', array( __CLASS__, 'register' ) );
    }

    /**
     * Include widget classes
     *
     * @access public
     * @return void
     */
    public static function includes() {
        require_once INVENTOR_UI_KIT_DIR . 'includes/widgets/class-inventor-ui-kit-widget-cover.php';
        require_once INVENTOR_UI_KIT_DIR . 'includes/widgets/class-inventor-ui-kit-widget-slider.php';
    }

    /**
     * Register widgets
     *
     * @access public
     * @return void
     */
    public static function register() {
        register_widget( 'Inventor_UI_Kit_Widget_Cover' );
        register_widget( 'Inventor_UI_Kit_Widget_Slider' );
    }
}

Inventor_UI_Kit_Widgets::init();