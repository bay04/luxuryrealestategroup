<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Submission_Customizations
 *
 * @access public
 * @package Inventor_Submission/Classes/Customizations
 * @return void
 */
class Inventor_Submission_Customizations {
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
        require_once INVENTOR_SUBMISSION_DIR . 'includes/customizations/class-inventor-submission-customizations-submission.php';
    }
}

Inventor_Submission_Customizations::init();