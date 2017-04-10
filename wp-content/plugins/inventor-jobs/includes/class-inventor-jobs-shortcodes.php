<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Jobs_Shortcodes
 *
 * @class Inventor_Jobs_Shortcodes
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Jobs_Shortcodes {
    /**
     * Initialize shortcodes
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_shortcode( 'inventor_jobs_apply_form', array( __CLASS__, 'jobs_apply_form' ) );
        add_shortcode( 'inventor_jobs_applicants', array( __CLASS__, 'jobs_applicants' ) );
    }

    /**
     * Apply for a job form
     *
     * @access public
     * @param $atts
     * @return void
     */
    public static function jobs_apply_form( $atts ) {
        if ( ! is_user_logged_in() ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed' );
            return;
        }

        $listing = Inventor_Post_Types::get_listing( $_GET['id'] );

        if ( 'job' != get_post_type( $listing ) ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed', array( 'message' => esc_attr__( 'Listing is not a job.', 'inventor-jobs' ) ) );
        }

        $user_resumes_query = Inventor_Jobs_Logic::get_user_resumes( get_current_user_id() );

        $attrs = array(
            'job' => $listing,
            'resumes' => $user_resumes_query->posts,
        );

        echo Inventor_Template_Loader::load( 'jobs-apply-form', $attrs, $plugin_dir = INVENTOR_JOBS_DIR );
    }

    /**
     * List of job applicants
     *
     * @access public
     * @param $atts
     * @return void
     */
    public static function jobs_applicants( $atts ) {
        if ( ! is_user_logged_in() ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed' );
            return;
        }

        $job_id = null;
        $applicants = Inventor_Jobs_Logic::get_jobs_applications( $job_id );
        echo Inventor_Template_Loader::load( 'jobs-applicants', array( 'applicants' => $applicants ), $plugin_dir = INVENTOR_JOBS_DIR );
    }
}

Inventor_Jobs_Shortcodes::init();