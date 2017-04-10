<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Jobs_Customizations
 *
 * @access public
 * @package Inventor_Jobs/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Jobs_Customizations {
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
        require_once INVENTOR_JOBS_DIR . 'includes/customizations/class-inventor-jobs-customizations-jobs.php';
    }
}

Inventor_Jobs_Customizations::init();