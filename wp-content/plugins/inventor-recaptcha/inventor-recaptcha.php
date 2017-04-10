<?php

/**
 * Plugin Name: Inventor reCAPTCHA
 * Version: 1.6.0
 * Description: Support for Google reCAPTCHA.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-recaptcha/
 * Text Domain: inventor-recaptcha
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Recaptcha' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Recaptcha
     *
     * @class Inventor_Recaptcha
     * @package Inventor_Recaptcha
     * @author Pragmatic Mates
     */
    final class Inventor_Recaptcha {
        const DOMAIN = 'inventor-recaptcha';

        /**
         * Initialize Inventor_Recaptcha plugin
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
            define( 'INVENTOR_RECAPTCHA_URL', 'https://www.google.com/recaptcha/api/siteverify' );
            define( 'INVENTOR_RECAPTCHA_DIR', plugin_dir_path( __FILE__ ) );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_RECAPTCHA_DIR . 'includes/class-inventor-recaptcha-customizations.php';
            require_once INVENTOR_RECAPTCHA_DIR . 'includes/class-inventor-recaptcha-scripts.php';
            require_once INVENTOR_RECAPTCHA_DIR . 'includes/class-inventor-recaptcha-logic.php';
        }
    }

    new Inventor_Recaptcha();
}
