<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Statistics_Customizations
 *
 * @access public
 * @package Inventor_Statistics/Classes/Customizations
 * @return void
 */
class Inventor_Statistics_Customizations {
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
        require_once INVENTOR_STATISTICS_DIR . 'includes/customizations/class-inventor-statistics-customizations-statistics.php';
    }
}

Inventor_Statistics_Customizations::init();