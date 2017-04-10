<?php

/**
 * Plugin Name: Inventor Partners
 * Version: 1.0.0
 * Description: Provides custom post type for partners which logos could be displayed by widget.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-partners/
 * Text Domain: inventor-partners
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Partners' ) && class_exists( 'Inventor' ) ) {
	/**
	 * Class Inventor_Partners
	 *
	 * @class Inventor_Partners
	 * @package Inventor_Partners
	 * @author Pragmatic Mates
	 */
	final class Inventor_Partners {
		const DOMAIN = 'inventor-partners';

		/**
		 * Initialize Inventor_Partners plugin
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
			define( 'INVENTOR_PARTNERS_DIR', plugin_dir_path( __FILE__ ) );
			define( 'INVENTOR_PARTNERS_PREFIX', 'partner_' );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once INVENTOR_PARTNERS_DIR . 'includes/class-inventor-partners-post-types.php';
			require_once INVENTOR_PARTNERS_DIR . 'includes/class-inventor-partners-widgets.php';
		}

        /**
         * Loads frontend files
         *
         * @access public
         * @return void
         */
        public static function enqueue_frontend() {
			wp_enqueue_style( 'inventor-partners', plugins_url( '/inventor-partners/assets/style.css' ) );
        }
	}

	new Inventor_Partners();
}