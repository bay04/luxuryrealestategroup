<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Invoices_Customizations
 *
 * @access public
 * @package Inventor_Invoices/Classes/Customizations
 * @return void
 */
class Inventor_Invoices_Customizations {
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
        require_once INVENTOR_INVOICES_DIR . 'includes/customizations/class-inventor-invoices-customizations-invoices.php';
    }
}

Inventor_Invoices_Customizations::init();