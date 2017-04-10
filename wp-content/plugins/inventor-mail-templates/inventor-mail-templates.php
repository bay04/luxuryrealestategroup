<?php

/**
 * Plugin Name: Inventor Mail Templates
 * Version: 1.0.0
 * Description: Allows user to customize mail templates.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-mail-templates/
 * Text Domain: inventor-mail-templates
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Mail_Templates' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Mail_Templates
     *
     * @class Inventor_Mail_Templates
     * @package Inventor_Mail_Templates
     * @author Pragmatic Mates
     */
    final class Inventor_Mail_Templates {
        const DOMAIN = 'inventor-mail-templates';

        /**
         * Initialize Inventor_Mail_Templates plugin
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
            define( 'INVENTOR_MAIL_TEMPLATES_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_MAIL_TEMPLATE_PREFIX', 'mail_template_' );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_MAIL_TEMPLATES_DIR . 'includes/class-inventor-mail-templates-post-types.php';
            require_once INVENTOR_MAIL_TEMPLATES_DIR . 'includes/class-inventor-mail-templates-logic.php';
        }
    }

    new Inventor_Mail_Templates();
}