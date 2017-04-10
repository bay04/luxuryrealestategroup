<?php

/**
 * Plugin Name: Inventor Submission
 * Version: 2.0.0
 * Description: Adds ability for frontend listing submission.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-submission/
 * Text Domain: inventor-submission
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Submission' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Submission
     *
     * @class Inventor_Submission
     * @package Inventor_Submission
     * @author Pragmatic Mates
     */
    final class Inventor_Submission {
        const DOMAIN = 'inventor-submission';

        /**
         * Initialize Inventor_Submission plugin
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
            define( 'INVENTOR_SUBMISSION_DIR', plugin_dir_path( __FILE__ ) );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_SUBMISSION_DIR . 'includes/class-inventor-submission-customizations.php';
            require_once INVENTOR_SUBMISSION_DIR . 'includes/class-inventor-submission-logic.php';
            require_once INVENTOR_SUBMISSION_DIR . 'includes/class-inventor-submission-shortcodes.php';
        }
    }

    new Inventor_Submission();
}