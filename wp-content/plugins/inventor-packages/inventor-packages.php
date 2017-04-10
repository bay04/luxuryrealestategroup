<?php

/**
 * Plugin Name: Inventor Packages
 * Version: 1.5.0
 * Description: Adds support for user packages
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-packages/
 * Text Domain: inventor-packages
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Packages' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Packages
     *
     * @class Inventor_Packages
     * @package Inventor_Packages
     * @author Pragmatic Mates
     */
    final class Inventor_Packages {
        const DOMAIN = 'inventor-packages';

        /**
         * Initialize Inventor_Packages plugin
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
            define( 'INVENTOR_PACKAGES_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_PACKAGE_PREFIX', 'package_' );
            define( 'INVENTOR_PACKAGES_VALIDATION_THRESHOLD', 60 * 60 );  // 1 hour
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_PACKAGES_DIR . 'includes/class-inventor-packages-scripts.php';
            require_once INVENTOR_PACKAGES_DIR . 'includes/class-inventor-packages-customizations.php';
            require_once INVENTOR_PACKAGES_DIR . 'includes/class-inventor-packages-post-types.php';
            require_once INVENTOR_PACKAGES_DIR . 'includes/class-inventor-packages-shortcodes.php';
            require_once INVENTOR_PACKAGES_DIR . 'includes/class-inventor-packages-widgets.php';
            require_once INVENTOR_PACKAGES_DIR . 'includes/class-inventor-packages-logic.php';
        }
    }

    new Inventor_Packages();
}
