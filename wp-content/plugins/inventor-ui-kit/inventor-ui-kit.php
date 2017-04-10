<?php

/**
 * Plugin Name: Inventor UI Kit
 * Version: 1.0.1
 * Description: Amazing widgets.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-ui-kit/
 * Text Domain: inventor-ui-kit
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_UI_Kit' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_UI_Kit
     *
     * @class Inventor_UI_Kit
     * @package Inventor_UI_Kit
     * @author Pragmatic Mates
     */
    final class Inventor_UI_Kit {
        const DOMAIN = 'inventor-ui-kit';

        /**
         * Initialize Inventor_UI_Kit plugin
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
            define( 'INVENTOR_UI_KIT_DIR', plugin_dir_path( __FILE__ ) );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_UI_KIT_DIR . 'includes/class-inventor-ui-kit-widgets.php';
        }
    }

    new Inventor_UI_Kit();
}