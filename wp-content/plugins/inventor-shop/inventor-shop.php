<?php

/**
 * Plugin Name: Inventor Shop
 * Version: 1.1.0
 * Description: Listing purchasing support.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-shop/
 * Text Domain: inventor-shop
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Shop' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Shop
     *
     * @class Inventor_Shop
     * @package Inventor_Shop
     * @author Pragmatic Mates
     */
    final class Inventor_Shop {
        const DOMAIN = 'inventor-shop';

        /**
         * Initialize Inventor_Shop plugin
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
            define( 'INVENTOR_SHOP_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_SHOP_PREFIX', 'shop_' );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_SHOP_DIR . 'includes/class-inventor-shop-logic.php';
        }
    }

    new Inventor_Shop();
}