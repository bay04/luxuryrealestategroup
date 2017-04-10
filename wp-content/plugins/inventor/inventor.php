<?php
/**
 * Plugin Name: Inventor
 * Version: 2.0.0
 * Description: Directory plugin for all kinds of listings.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor/
 * Text Domain: inventor
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package Inventor
 */

if ( ! class_exists( 'Inventor' ) ) {

	/**
	 * Class Inventor
	 *
	 * @class Inventor
	 * @package Inventor
	 * @author Pragmatic Mates
	 */
	final class Inventor {
		const DOMAIN = 'inventor';

		/**
		 * Initialize plugin
		 */
		public function __construct() {
			$this->constants();
			$this->libraries();
			$this->includes();
			Inventor_Utilities::load_plugin_textdomain( self::DOMAIN, __FILE__ );

			if ( 'SESSION' == apply_filters( 'inventor_visitor_data_destination', INVENTOR_DEFAULT_VISITOR_DATA_STORAGE ) ) {
				add_action( 'init', array(__CLASS__, 'start_session'), 1 );
			}

			add_action( 'activated_plugin', array( __CLASS__, 'plugin_order' ) );
			add_action( 'tgmpa_register', array( __CLASS__, 'register_plugins' ) );
		}

		/**
		 * Defines constants
		 *
		 * @access public
		 * @return void
		 */
		public function constants() {
			define( 'INVENTOR_DIR', plugin_dir_path( __FILE__ ) );
			define( 'INVENTOR_LISTING_PREFIX', 'listing_' );
			define( 'INVENTOR_LISTING_CATEGORY_PREFIX', 'listing_category_' );
			define( 'INVENTOR_TRANSACTION_PREFIX', 'transaction_' );
			define( 'INVENTOR_REPORT_PREFIX', 'report_' );
			define( 'INVENTOR_USER_PREFIX', 'user_' );
			define( 'INVENTOR_MAIL_ACTION_REPORTED_LISTING', 'REPORTED_LISTING' );
			define( 'INVENTOR_DEFAULT_VISITOR_DATA_STORAGE', 'COOKIE' );

			define( 'INVENTOR_API_ENDPOINT', 'http://inventorwp.com/api/v1/' );
			define( 'INVENTOR_API_VERIFY_URL', INVENTOR_API_ENDPOINT . 'verify/' );
		}

		/**
		 * Include classes
		 *
		 * @access public
		 * @return void
		 */
		public function includes() {
			if ( apply_filters( 'inventor_database_session_handler_enabled', false ) ) {
				require_once INVENTOR_DIR . 'includes/class-inventor-session-handler.php';
			}
			require_once INVENTOR_DIR . 'includes/class-inventor-scripts.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-template-loader.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-metaboxes.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-post-types.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-field-types.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-taxonomies.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-price.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-widgets.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-filter.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-visitor.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-utilities.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-query.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-shortcodes.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-social.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-billing.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-wire-transfer.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-reports.php';
			require_once INVENTOR_DIR . 'includes/class-inventor-customizations.php';

			// Admin
			if ( is_admin() ) {
				require_once INVENTOR_DIR . 'includes/admin/class-inventor-admin-menu.php';
				require_once INVENTOR_DIR . 'includes/admin/class-inventor-admin-notices.php';
				require_once INVENTOR_DIR . 'includes/admin/class-inventor-admin-updates.php';
				require_once INVENTOR_DIR . 'includes/admin/class-inventor-admin-dashboard.php';
			}
		}

		/**
		 * Loads third party libraries
		 *
		 * @access public
		 * @return void
		 */
		public static function libraries() {
			require_once INVENTOR_DIR . 'libraries/class-tgm-plugin-activation.php';
			require_once INVENTOR_DIR . 'libraries/cmb_field_map/cmb-field-map.php';
			require_once INVENTOR_DIR . 'libraries/cmb_field_street_view/cmb-field-street-view.php';
		}

		/**
		 * Install plugins
		 *
		 * @access public
		 * @return void
		 */
		public static function register_plugins() {
			$plugins = array(
				array(
					'name'      			=> 'CMB2',
					'slug'      			=> 'cmb2',
					'is_automatic'          => true,
					'required'  			=> true,
					'version'				=> '2.2.2.1'
				),
			);

			tgmpa( $plugins );
		}

        /**
         * Start session
         *
         * @access public
         * @return void
         */
        public static function start_session() {
			session_id() or session_start();
        }

		/**
		 * Loads this plugin first
		 *
		 * @access public
		 * @return void
		 */
		public static function plugin_order() {
			$wp_path_to_this_file = preg_replace( '/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR.'/$2', __FILE__ );
			$this_plugin = plugin_basename( trim( $wp_path_to_this_file ) );
			$active_plugins = get_option( 'active_plugins' );

			$this_plugin_key = array_search( $this_plugin, $active_plugins );

			if ( $this_plugin_key ) {
				array_splice( $active_plugins, $this_plugin_key, 1 );
				array_unshift( $active_plugins, $this_plugin );
				update_option( 'active_plugins', $active_plugins );
			}
		}
	}

	new Inventor();
}
