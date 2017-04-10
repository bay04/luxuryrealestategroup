<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Customizations
 *
 * @access public
 * @package Inventor_Favorites/Classes/Customizations
 * @return void
 */
class Inventor_Favorites_Customizations {
    /**
     * Initialize customizations
     *
     * @access public
     * @return void
     */
    public static function init() {
        self::includes();
    }

    /**
     * Include all customizations
     *
     * @access public
     * @return void
     */
    public static function includes() {
        require_once INVENTOR_FAVORITES_DIR . 'includes/customizations/class-inventor-favorites-customizations-favorites.php';
    }
}

Inventor_Favorites_Customizations::init();