<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Properties_Customizations
 *
 * @access public
 * @package Inventor_Properties/Classes/Customizations
 * @return void
 */
class Inventor_Properties_Customizations {
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
        require_once INVENTOR_PROPERTIES_DIR . 'includes/customizations/class-inventor-properties-customizations-properties.php';
    }
}

Inventor_Properties_Customizations::init();