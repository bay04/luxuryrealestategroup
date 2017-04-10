<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Jobs_Post_Types
 *
 * @class Inventor_Jobs_Post_Types
 * @package Inventor_Jobs/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Jobs_Post_Types {
    public static $listings_types = array();

    /**
     * Initialize listing types
     *
     * @access public
     * @return void
     */
    public static function init() {
        self::includes();
    }

    /**
     * Loads listing types
     *
     * @access public
     * @return void
     */
    public static function includes() {
        require_once INVENTOR_JOBS_DIR . 'includes/post-types/class-inventor-jobs-post-type-job.php';
        require_once INVENTOR_JOBS_DIR . 'includes/post-types/class-inventor-jobs-post-type-resume.php';
        require_once INVENTOR_JOBS_DIR . 'includes/post-types/class-inventor-jobs-post-type-application.php';
    }
}

Inventor_Jobs_Post_Types::init();
