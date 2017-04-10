<?php

/**
 * Plugin Name: Inventor Google Places
 * Version: 0.3.0
 * Description: WP CLI command for downloading places.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-google-places/
 * Text Domain: inventor-google-places
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Google_Places' ) ) {
	/**
	 * Class Inventor_Google_Places
	 *
	 * @class Inventor_Google_Places
	 * @package Inventor_Google_Places
	 * @author Pragmatic Mates
	 */
	final class Inventor_Google_Places {
		const DOMAIN = 'inventor-google-places';

		/**
		 * Initialize Inventor_Google_Places plugin
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
			define( 'INVENTOR_GOOGLE_PLACES', plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			if ( defined('WP_CLI') && WP_CLI ) {
    			require_once INVENTOR_GOOGLE_PLACES . '/includes/commands/inventor-commands-google-places.php';
			}
		}
	}

	new Inventor_Google_Places();
}
