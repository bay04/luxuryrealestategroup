<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Widgets
 *
 * @class Inventor_Favorites_Widgets
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Widgets {
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
        require_once INVENTOR_FAVORITES_DIR . 'includes/widgets/class-inventor-favorites-widget-favorites.php';
        require_once INVENTOR_FAVORITES_DIR . 'includes/widgets/class-inventor-favorites-widget-collections.php';
    }

    /**
     * Register widgets
     *
     * @access public
     * @return void
     */
    public static function register() {
        register_widget( 'Inventor_Favorites_Widget_Favorites' );
        register_widget( 'Inventor_Favorites_Widget_Collections' );
    }
}

Inventor_Favorites_Widgets::init();