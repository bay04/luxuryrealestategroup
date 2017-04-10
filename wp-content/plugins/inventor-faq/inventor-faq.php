<?php

/**
 * Plugin Name: Inventor FAQ
 * Version: 1.1.0
 * Description: Provides custom post type for Frequently Asked Questions which could be displayed by widget.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-faq/
 * Text Domain: inventor-faq
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_FAQ' ) && class_exists( 'Inventor' ) ) {
	/**
	 * Class Inventor_FAQ
	 *
	 * @class Inventor_FAQ
	 * @package Inventor_FAQ
	 * @author Pragmatic Mates
	 */
	final class Inventor_FAQ {
		const DOMAIN = 'inventor-faq';

		/**
		 * Initialize Inventor_FAQ plugin
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
			define( 'INVENTOR_FAQ_DIR', plugin_dir_path( __FILE__ ) );
			define( 'INVENTOR_FAQ_PREFIX', 'faq_' );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once INVENTOR_FAQ_DIR . 'includes/class-inventor-faq-post-types.php';
			require_once INVENTOR_FAQ_DIR . 'includes/class-inventor-faq-widgets.php';
		}
	}

	new Inventor_FAQ();
}
