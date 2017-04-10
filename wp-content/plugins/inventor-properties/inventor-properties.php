<?php

/**
 * Plugin Name: Inventor Properties
 * Version: 1.2.0
 * Description: Properties listing support.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-properties/
 * Text Domain: inventor-properties
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Properties' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Properties
     *
     * @class Inventor_Properties
     * @package Inventor_Properties
     * @author Pragmatic Mates
     */
    final class Inventor_Properties {
        const DOMAIN = 'inventor-properties';

        /**
         * Initialize Inventor_Properties plugin
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
            define( 'INVENTOR_PROPERTIES_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_PROPERTY_PREFIX', 'property_' );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_PROPERTIES_DIR . 'includes/class-inventor-properties-post-types.php';
            require_once INVENTOR_PROPERTIES_DIR . 'includes/class-inventor-properties-taxonomies.php';
            require_once INVENTOR_PROPERTIES_DIR . 'includes/class-inventor-properties-customizations.php';
            require_once INVENTOR_PROPERTIES_DIR . 'includes/class-inventor-properties-logic.php';
        }
    }

    new Inventor_Properties();
}
