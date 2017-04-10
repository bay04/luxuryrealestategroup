<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Currencies_Customizations
 *
 * @access public
 * @package Inventor_Currencies/Classes/Customizations
 * @return void
 */
class Inventor_Currencies_Customizations {
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
        require_once INVENTOR_CURRENCIES_DIR . 'includes/customizations/class-inventor-currencies-customizations-currencies.php';
    }
}

Inventor_Currencies_Customizations::init();