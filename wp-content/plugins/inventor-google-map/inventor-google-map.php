<?php

/**
 * Plugin Name: Inventor Google Map
 * Version: 1.4.0
 * Description: Provides Google Map widget with advanced settings.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-google-map/
 * Text Domain: inventor-google-map
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Google_Map' ) && class_exists( 'Inventor' ) ) {
	/**
	 * Class Inventor_Google_Map
	 *
	 * @class Inventor_Google_Map
	 * @package Inventor_Google_Map
	 * @author Pragmatic Mates
	 */
	final class Inventor_Google_Map {
		const DOMAIN = 'inventor-google-map';

		/**
		 * Initialize Inventor_Google_Map plugin
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
			define( 'INVENTOR_GOOGLE_MAP_DIR', plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/class-inventor-google-map-ajax.php';
			require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/class-inventor-google-map-scripts.php';
			require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/class-inventor-google-map-styles.php';
			require_once INVENTOR_GOOGLE_MAP_DIR . 'includes/class-inventor-google-map-widgets.php';
		}

		/**
		 * Get filter params
		 *
		 * @access public
		 * @return string
		 */
		public static function get_current_filter_query_uri() {
			return $_SERVER["QUERY_STRING"];
		}
	}

	new Inventor_Google_Map();
}
