<?php

/**
 * Plugin Name: Inventor Jobs
 * Version: 1.1.0
 * Description: Adds support for job listing post type
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-jobs/
 * Text Domain: inventor-jobs
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Jobs' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Jobs
     *
     * @class Inventor_Jobs
     * @job Inventor_Jobs
     * @author Pragmatic Mates
     */
    final class Inventor_Jobs {
        const DOMAIN = 'inventor-jobs';

        /**
         * Initialize Inventor_Jobs plugin
         */
        public function __construct() {
            $this->constants();
            $this->includes();
            if ( class_exists( 'Inventor_Utilities' ) ) {
                Inventor_Utilities::load_plugin_textdomain( self::DOMAIN, __FILE__ );
            }
        }

        /**
         * Defines constants
         *
         * @access public
         * @return void
         */
        public function constants() {
            define( 'INVENTOR_JOBS_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_JOB_PREFIX', 'job_' );
            define( 'INVENTOR_RESUME_PREFIX', 'resume_' );
            define( 'INVENTOR_APPLICATION_PREFIX', 'application_' );
            define( 'INVENTOR_MAIL_ACTION_NEW_JOB_APPLICATION', 'NEW_JOB_APPLICATION' );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_JOBS_DIR . 'includes/class-inventor-jobs-customizations.php';
            require_once INVENTOR_JOBS_DIR . 'includes/class-inventor-jobs-shortcodes.php';
            require_once INVENTOR_JOBS_DIR . 'includes/class-inventor-jobs-post-types.php';
            require_once INVENTOR_JOBS_DIR . 'includes/class-inventor-jobs-taxonomies.php';
            require_once INVENTOR_JOBS_DIR . 'includes/class-inventor-jobs-logic.php';
        }
    }

    new Inventor_Jobs();
}
