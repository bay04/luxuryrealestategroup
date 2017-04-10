<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Packages_Widgets
 *
 * @class Inventor_Packages_Widgets
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Packages_Widgets {
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
        require_once INVENTOR_PACKAGES_DIR . 'includes/widgets/class-inventor-packages-widget-packages.php';
    }

    /**
     * Register widgets
     *
     * @access public
     * @return void
     */
    public static function register() {
        register_widget( 'Inventor_Packages_Widget_Packages' );
    }
}

Inventor_Packages_Widgets::init();