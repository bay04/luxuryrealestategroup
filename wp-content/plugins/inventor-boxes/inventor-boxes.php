<?php

/**
 * Plugin Name: Inventor Boxes
 * Version: 1.0.0
 * Description: Simple widget for displaying boxes.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-boxes/
 * Text Domain: inventor-cover
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Boxes' ) && class_exists( 'Inventor' ) ) {
	/**
	 * Class Inventor_Boxes
	 *
	 * @class Inventor_Boxes
	 * @package Inventor_Boxes
	 * @author Pragmatic Mates
	 */
	final class Inventor_Boxes {
		const DOMAIN = 'inventor-boxes';

		/**
		 * Initialize Inventor_Boxes plugin
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
			define( 'INVENTOR_BOXES_DIR', plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once INVENTOR_BOXES_DIR . 'includes/class-inventor-boxes-scripts.php';
			require_once INVENTOR_BOXES_DIR . 'includes/class-inventor-boxes-widgets.php';
		}
	}

	new Inventor_Boxes();
}