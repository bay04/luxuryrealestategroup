<?php

/**
 * Plugin Name: Inventor PayPal
 * Version: 1.4.0
 * Description: Adds PayPal payment gateway.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-paypal/
 * Text Domain: inventor-paypal
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_PayPal' ) && class_exists( 'Inventor' ) ) {
	/**
	 * Class Inventor_PayPal
	 *
	 * @class Inventor_PayPal
	 * @package Inventor_PayPal
	 * @author Pragmatic Mates
	 */
	final class Inventor_PayPal {
		const DOMAIN = 'inventor-paypal';

		/**
		 * Initialize Inventor_PayPal plugin
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
			define( 'INVENTOR_PAYPAL_DIR', plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once INVENTOR_PAYPAL_DIR . 'includes/class-inventor-paypal-customizations.php';
            require_once INVENTOR_PAYPAL_DIR . 'includes/class-inventor-paypal-logic.php';
		}
	}

	new Inventor_PayPal();
}