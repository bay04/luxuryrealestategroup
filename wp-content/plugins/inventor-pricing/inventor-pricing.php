<?php

/**
 * Plugin Name: Inventor Pricing
 * Version: 1.1.0
 * Description: Provides custom post type for pricing tables, which could be displayed by widget.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-pricing/
 * Text Domain: inventor-pricing
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! class_exists( 'Inventor_Pricing' ) && class_exists( 'Inventor' ) ) {
	/**
	 * Class Inventor_Pricing
	 *
	 * @class Inventor_Pricing
	 * @package Inventor_Pricing
	 * @author Pragmatic Mates
	 */
	final class Inventor_Pricing {
		const DOMAIN = 'inventor-pricing';

		/**
		 * Initialize Inventor_Pricing plugin
		 */
		public function __construct() {
			$this->constants();
			$this->includes();
			if ( class_exists( 'Inventor_Utilities' ) ) {
				Inventor_Utilities::load_plugin_textdomain( self::DOMAIN, __FILE__ );
			}

			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
		}

		/**
		 * Defines constants
		 *
		 * @access public
		 * @return void
		 */
		public function constants() {
			define( 'INVENTOR_PRICING_DIR', plugin_dir_path( __FILE__ ) );
			define( 'INVENTOR_PRICING_PREFIX', 'pricing_' );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once INVENTOR_PRICING_DIR . 'includes/class-inventor-pricing-post-types.php';
			require_once INVENTOR_PRICING_DIR . 'includes/class-inventor-pricing-widgets.php';
			require_once INVENTOR_PRICING_DIR . 'includes/class-inventor-pricing-logic.php';
		}

        /**
         * Loads frontend files
         *
         * @access public
         * @return void
         */
        public static function enqueue_frontend() {
			wp_enqueue_style( 'inventor-pricing', plugins_url( '/inventor-pricing/assets/style.css' ) );
        }
	}

	new Inventor_Pricing();
}