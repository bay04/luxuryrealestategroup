<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Packages_Customizations
 *
 * @access public
 * @package Inventor_Packages/Classes/Customizations
 * @return void
 */
class Inventor_Packages_Customizations {
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
        require_once INVENTOR_PACKAGES_DIR . 'includes/customizations/class-inventor-packages-customizations-packages.php';
    }
}

Inventor_Packages_Customizations::init();