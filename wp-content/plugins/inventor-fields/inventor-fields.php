<?php

/**
 * Plugin Name: Inventor Fields
 * Version: 1.5.0
 * Description: Custom fields manager for Inventor plugin
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-fields/
 * Text Domain: inventor-fields
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Fields' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Fields
     *
     * @class Inventor_Fields
     * @package Inventor_Fields
     * @author Pragmatic Mates
     */
    final class Inventor_Fields {
        const DOMAIN = 'inventor-fields';

        /**
         * Initialize Inventor_Fields plugin
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
            define( 'INVENTOR_FIELDS_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_FIELDS_FIELD_PREFIX', 'field_' );
            define( 'INVENTOR_FIELDS_METABOX_PREFIX', 'metabox_' );
            define( 'INVENTOR_FIELDS_LISTING_TYPE_PREFIX', 'listing_type_' );
            define( 'INVENTOR_FIELDS_LEXICON_PREFIX', 'lexicon_' );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_FIELDS_DIR . 'includes/class-inventor-fields-post-types.php';
            require_once INVENTOR_FIELDS_DIR . 'includes/class-inventor-fields-scripts.php';
            require_once INVENTOR_FIELDS_DIR . 'includes/class-inventor-fields-logic.php';
            require_once INVENTOR_FIELDS_DIR . 'includes/class-inventor-fields-migrations.php';
        }
    }

    new Inventor_Fields();
}
