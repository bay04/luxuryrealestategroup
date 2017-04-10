<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Jobs_Logic
 *
 * @class Inventor_Jobs_Logic
 * @package Inventor_Jobs/Classes
 * @author Pragmatic Mates
 */
class Inventor_Jobs_Logic {
    /**
     * Initialize Jobs functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'process_apply_form' ), 9999 );
        add_action( 'wp_ajax_nopriv_inventor_jobs_ajax_can_apply', array( __CLASS__, 'ajax_can_apply' ) );
        add_action( 'wp_ajax_inventor_jobs_ajax_can_apply', array( __CLASS__, 'ajax_can_apply' ) );
        add_action( 'inventor_listing_detail', array( __CLASS__, 'render_total_job_applications' ), 0, 1 );
//        add_action( 'inventor_submission_list_row_actions', array( __CLASS__, 'render_applicants_button' ), 10, 1 );

        add_filter( 'inventor_mail_actions_choices', array( __CLASS__, 'mail_actions_choices' ) );
    }

    /**
     * Gets config
     *
     * @access public
     * @return array
     */
    public static function get_config() {
        $apply_page = get_theme_mod( 'inventor_jobs_apply_page', false );

        $config = array(
            "apply_page"    => $apply_page,
        );

        return $config;
    }

    /**
     * Adds jobs mail actions
     *
     * @access public
     * @param array $choices
     * @return array
     */
    public static function mail_actions_choices( $choices ) {
        $choices[ INVENTOR_MAIL_ACTION_NEW_JOB_APPLICATION ] = __( 'New job application', 'inventor-jobs' );
        return $choices;
    }

    /**
     * Ajax request. Checks if user can apply for a job.
     *
     * @access public
     * @return string
     */
    public static function ajax_can_apply() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        if ( ! empty( $_GET['id'] ) ) {
            $job_already_assigned = self::job_is_assigned( $_GET['id'] );

            if ( $job_already_assigned ) {
                $data = array(
                    'success' => false,
                    'message' => __( 'Job was already assigned to user.', 'inventor-jobs' ),
                );
            } else {
                $user_already_applied = self::user_already_applied( $_GET['id'], get_current_user_id() );

                if ( $user_already_applied ) {
                    $data = array(
                        'success' => false,
                        'message' => __( 'You have already applied for this job.', 'inventor-jobs' ),
                    );
                } else {
                    $data = array(
                        'success' => true,
                    );
                }
            }
        } else {
            $data = array(
                'success' => false,
                'message' => __( 'Job ID is missing.', 'inventor-jobs' ),
            );
        }

        echo json_encode( $data );
        exit();
    }

    /**
     * Returns query of user resumes
     *
     * @access public
     * @param int $user_id
     * @return WP_Query
     */
    public static function get_user_resumes( $user_id ) {
        return new WP_Query( array(
            'author'            => $user_id,
            'post_type'         => 'resume',
            'posts_per_page'    => -1,
            'post_status'       => 'any',
        ) );
    }

    /**
     * Returns application by user_id and job_id
     *
     * @access public
     * @param $job_id int
     * @param $user_id int
     * @return object
     */
    public static function get_user_application( $job_id, $user_id ) {
        $wp_query = new WP_Query( array(
            'post_type'     => 'application',
            'post_status'   => 'any',
            'author'        => $user_id,
            'meta_query'    => array(
                array(
                    'key' => INVENTOR_APPLICATION_PREFIX . 'job_id',
                    'value' => $job_id,
                )
            )
        ) );

        if ( $wp_query->post_count <= 0 ) {
            return null;
        }

        return $wp_query->posts[0];
    }

    /**
     * Returns application by user_id and job_id
     *
     * @access public
     * @param $job_id int
     * @return array()
     */
    public static function get_jobs_applications( $job_id ) {
        $user_jobs_query = Inventor_Query::get_listings_by_user( get_current_user_id(), 'any', 'job' );
        $user_jobs = $user_jobs_query->posts;

        $user_jobs_ids = array_map( function( $j ) { return $j->ID; }, $user_jobs );

        $wp_query = new WP_Query( array(
            'post_type'     => 'application',
            'post_status'   => 'any',
            'meta_query'    => array(
                array(
                    'key'       => INVENTOR_APPLICATION_PREFIX . 'job_id',
                    'value'     => $user_jobs_ids,
                    'compare'   => 'IN'
                )
            )
        ) );

        if ( $wp_query->post_count <= 0 ) {
            return array();
        }

        return $wp_query->posts;
    }

    /**
     * Checks if job is already assigned to user
     *
     * @access public
     * @param $job_id int
     * @return bool
     */
    public static function job_is_assigned( $job_id ) {
        $assigned_to = get_post_meta( $job_id, INVENTOR_LISTING_PREFIX . 'job_assigned_to', true );
        return ! empty( $assigned_to );
    }

    /**
     * Checks if user already applied for specified job
     *
     * @access public
     * @param $job_id int
     * @param $user_id int
     * @return bool
     */
    public static function user_already_applied( $job_id, $user_id ) {
        $application = self::get_user_application( $job_id, $user_id );
        return ( ! empty( $application ) );
    }

    /**
     * Renders job apply button
     *
     * @access public
     * @param int $listing_id
     * @return void
     */
    public static function render_apply_button( $listing_id ) {
        if ( is_user_logged_in() && 'job' == get_post_type( $listing_id ) ) {
            $config = self::get_config();
            $apply_page = $config['apply_page'];
            $is_assigned = self::job_is_assigned( $listing_id );

            $attrs = array(
                'job_id'        => $listing_id,
                'apply_page'    => $apply_page,
                'is_assigned'   => $is_assigned
            );

            echo Inventor_Template_Loader::load( 'jobs-apply-button', $attrs, $plugin_dir = INVENTOR_JOBS_DIR );
        }
    }

    /**
     * Renders total job users info
     *
     * @access public
     * @param int $listing_id
     * @return void
     */
    public static function render_total_job_applications( $listing_id ) {
        if ( 'job' == get_post_type( $listing_id ) && in_array( 'resume', Inventor_Post_Types::get_listing_post_types() ) ) {
            $total_applications = self::get_total_job_applications( $listing_id );
            echo Inventor_Template_Loader::load( 'jobs-applications-total', array( 'total_applications' => $total_applications ), $plugin_dir = INVENTOR_JOBS_DIR );
        }
    }

    /**
     * Returns total job applications
     *
     * @access public
     * @param int $job_id
     * @return int
     */
    public static function get_total_job_applications( $job_id ) {
        $wp_query = new WP_Query( array(
            'post_type'     => 'application',
            'post_status'   => 'any',
            'meta_query'        => array(
                array(
                    'key' => INVENTOR_APPLICATION_PREFIX . 'job_id',
                    'value' => $job_id,
                )
            )
        ) );

        return $wp_query->post_count;
    }

    /**
     * Process apply form
     *
     * @access public
     * @return void
     */
    public static function process_apply_form() {
        if ( ! isset( $_POST['jobs_apply_form'] ) || empty( $_POST['job_id'] ) ) {
            return;
        }

        if ( class_exists( 'Inventor_Recaptcha' ) && Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) {
            if ( array_key_exists( 'g-recaptcha-response', $_POST ) ) {
                $is_recaptcha_valid = Inventor_Recaptcha_Logic::is_recaptcha_valid( $_POST['g-recaptcha-response'] );

                if ( ! $is_recaptcha_valid ) {
                    Inventor_Utilities::show_message( 'danger', __( 'reCAPTCHA is not valid.', 'inventor' ) );
                    return;
                }
            }
        }

        $user_already_applied = self::user_already_applied( $_POST['job_id'], get_current_user_id() );

        if ( $user_already_applied ) {
            Inventor_Utilities::show_message( 'danger', __( 'You have already applied for this job.', 'inventor-jobs' ) );
            return;
        }

        $job = get_post( $_POST['job_id'] );
        $resume = get_post( $_POST['resume'] );
        $user_id = $resume->post_author;
        $user_data = get_userdata( $user_id );
        $name = $user_data->display_name;
        $email = $user_data->user_email; // get_the_author_meta( 'user_email', $job->post_author );
        $message = esc_html( $_POST['message'] );

        $headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $name, $email );

        # template args
        $template_args = array(
            'job' => get_the_title( $job ),
            'resume' => get_the_title( $resume ),
            'url' => get_permalink( $job->ID ),
            'name' => $name,
            'email' => $email,
            'message' => $message,
        );

        # subject
        $subject = __( sprintf( 'New %s application', get_the_title( $job ) ), 'inventor-jobs' );
        $subject = apply_filters( 'inventor_mail_subject', $subject, INVENTOR_MAIL_ACTION_NEW_JOB_APPLICATION, $template_args );

        # body
        $body = '';
        $body = apply_filters( 'inventor_mail_body', $body, INVENTOR_MAIL_ACTION_NEW_JOB_APPLICATION, $template_args );

        if ( empty( $body ) ) {
            ob_start();
            include Inventor_Template_Loader::locate( 'jobs-apply-mail', $plugin_dir = INVENTOR_JOBS_DIR );
            $body = ob_get_contents();
            ob_end_clean();
        }

        # recipients
        $emails = array();

        # author
        $emails[] = get_the_author_meta( 'user_email', $job->post_author );

        $emails = array_unique( $emails );

        foreach ( $emails as $email ) {
            $status = wp_mail( $email, $subject, $body, $headers );
        }

        if ( ! empty( $status ) && 1 == $status ) {
            self::save_application( $job->ID, $resume->ID, $message );
            Inventor_Utilities::show_message( 'success', __( 'Message has been successfully sent.', 'inventor-jobs' ) );
        } else {
            Inventor_Utilities::show_message( 'danger', __( 'Unable to send a message.', 'inventor-jobs' ) );
        }

        wp_redirect( get_the_permalink( $job->ID ) );
        exit();
    }

    /**
     * Saves application
     *
     * @access public
     * @param $job_id int
     * @param $resume_id int
     * @param $message string
     * @return int
     */
    public static function save_application( $job_id, $resume_id, $message ) {
        $resume = get_post( $resume_id );
        $user_id = $resume->post_author;
        $user_data = get_userdata( $user_id );
        $name = $user_data->display_name;

        $application_id = wp_insert_post( array(
            'post_type'     => 'application',
            'post_status'   => 'publish',
            'post_author'   => $user_id,
            'post_title'    => $name,
            'post_content'  => $message,
        ) );

        update_post_meta( $application_id, INVENTOR_APPLICATION_PREFIX . 'job_id', $job_id );
        update_post_meta( $application_id, INVENTOR_APPLICATION_PREFIX . 'resume_id', $resume_id );

        return $application_id;
    }

    /**
     * Renders applicants button for specified job
     *
     * @access public
     * @param $listing_id int
     * @return void
     */
    public static function render_applicants_button( $listing_id ) {
        if ( 'job' == get_post_type( $listing_id ) && in_array( 'resume', Inventor_Post_Types::get_listing_post_types() ) ) {
            $jobs_applicants_page_id = get_theme_mod( 'inventor_jobs_applicants_page', false );
            if ( ! empty( $jobs_applicants_page_id ) ) {
                $attrs = array(
                    'page_id'           => $jobs_applicants_page_id,
                    'job_id'            => $listing_id,
                    'total_applicants'  => self::get_total_job_applications( $listing_id )
                );

                // TODO: applicants button template does not exist yet
                echo Inventor_Template_Loader::load( 'jobs-applicants-button', $attrs, $plugin_dir = INVENTOR_JOBS_DIR );
            }
        }
    }
}

Inventor_Jobs_Logic::init();