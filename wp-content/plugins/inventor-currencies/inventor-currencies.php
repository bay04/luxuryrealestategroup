<?php

/**
 * Plugin Name: Inventor Currencies
 * Version: 0.9.0
 * Description: Adds multiple currencies support.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-currencies/
 * Text Domain: inventor-currencies
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Currencies' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Currencies
     *
     * @class Inventor_Currencies
     * @package Inventor_Currencies
     * @author Pragmatic Mates
     */
    final class Inventor_Currencies {
        const DOMAIN = 'inventor-currencies';

        /**
         * Initialize Inventor_Currencies plugin
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
            define( 'INVENTOR_CURRENCIES_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_CURRENCY_REFRESH', 24 * 60 * 60 );  // 1 day
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_CURRENCIES_DIR . 'includes/class-inventor-currencies-customizations.php';
            require_once INVENTOR_CURRENCIES_DIR . 'includes/class-inventor-currencies-shortcodes.php';
            require_once INVENTOR_CURRENCIES_DIR . 'includes/class-inventor-currencies-logic.php';
        }
    }

    new Inventor_Currencies();
}