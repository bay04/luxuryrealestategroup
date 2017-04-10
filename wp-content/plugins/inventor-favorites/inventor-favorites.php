<?php

/**
 * Plugin Name: Inventor Favorites
 * Version: 1.2.0
 * Description: Adds favorite listings.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-favorites/
 * Text Domain: inventor-favorites
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Favorites' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Favorites
     *
     * @class Inventor_Favorites
     * @package Inventor_Favorites
     * @author Pragmatic Mates
     */
    final class Inventor_Favorites {
        const DOMAIN = 'inventor-favorites';

        /**
         * Initialize Inventor_Favorites plugin
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
            define( 'INVENTOR_FAVORITES_DIR', plugin_dir_path( __FILE__ ) );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-customizations.php';
            require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-shortcodes.php';
            require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-widgets.php';
            require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-scripts.php';
            require_once INVENTOR_FAVORITES_DIR . 'includes/class-inventor-favorites-logic.php';
        }
    }

    new Inventor_Favorites();
}