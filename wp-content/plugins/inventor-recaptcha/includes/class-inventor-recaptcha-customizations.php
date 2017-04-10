<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Recaptcha_Customizations
 *
 * @access public
 * @package Inventor_Recaptcha/Classes/Customizations
 * @return void
 */
class Inventor_Recaptcha_Customizations {
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
        require_once INVENTOR_RECAPTCHA_DIR . 'includes/customizations/class-inventor-recaptcha-customizations-recaptcha.php';
    }
}

Inventor_Recaptcha_Customizations::init();