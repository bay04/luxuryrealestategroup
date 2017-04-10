<?php

/**
 * Plugin Name: Inventor Watchdogs
 * Version: 1.0.0
 * Description: Allows user to watch search queries and be notified about changes.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-watchdogs/
 * Text Domain: inventor-watchdogs
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Watchdogs' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Watchdogs
     *
     * @class Inventor_Watchdogs
     * @package Inventor_Watchdogs
     * @author Pragmatic Mates
     */
    final class Inventor_Watchdogs {
        const DOMAIN = 'inventor-watchodgs';

        /**
         * Initialize Inventor_Watchdogs plugin
         */
        public function __construct() {
            $this->init();
            $this->constants();
            $this->includes();
            if ( class_exists( 'Inventor_Utilities' ) ) {
                Inventor_Utilities::load_plugin_textdomain( self::DOMAIN, __FILE__ );
            }
        }

        /**
         * Initialize watchdogs functionality
         *
         * @access public
         * @return void
         */
        public static function init() {
        }

        /**
         * Defines constants
         *
         * @access public
         * @return void
         */
        public function constants() {
            define( 'INVENTOR_WATCHDOGS_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_WATCHDOG_PREFIX', 'watchdog_' );
            define( 'INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY', 'SEARCH_QUERY' );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_WATCHDOGS_DIR . 'includes/class-inventor-watchdogs-customizations.php';
            require_once INVENTOR_WATCHDOGS_DIR . 'includes/class-inventor-watchdogs-post-types.php';
            require_once INVENTOR_WATCHDOGS_DIR . 'includes/class-inventor-watchdogs-shortcodes.php';
            require_once INVENTOR_WATCHDOGS_DIR . 'includes/class-inventor-watchdogs-logic.php';
        }
    }

    new Inventor_Watchdogs();
}