<?php
/**
 * Main class
 *
 * @author Yithemes
 * @package YITH Infinite Scrolling
 * @version 1.0.0
 */


if ( ! defined( 'YITH_INFS' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_INFS' ) ) {
	/**
	 * YITH Infinite Scrolling
	 *
	 * @since 1.0.0
	 */
	class YITH_INFS {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_INFS
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_INFS_VERSION;

		/**
		 * Plugin object
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $obj = null;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_INFS
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @return mixed YITH_INFS_Admin | YITH_INFS_Frontend
		 * @since 1.0.0
		 */
		public function __construct() {
			// Class admin
			if ( $this->is_admin() )  {

			    // require classes
                require_once( 'class.yith-infs-admin.php' );

				// Load Plugin Framework
				add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );

				YITH_INFS_Admin();
			}
			elseif( $this->load_frontend() ){

			    // require classes
                require_once( 'class.yith-infs-frontend.php' );

				// Frontend class
				YITH_INFS_Frontend();
			}
		}

        /**
         * Check if is admin
         *
         * @since 1.0.6
         * @author Francesco Licandro
         * @return boolean
         */
        public function is_admin(){
            $check_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;
            $check_context = isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend';

            return is_admin() && ! ( $check_ajax && $check_context );
        }

        /**
         * Check if load frontend class
         *
         * @since 1.0.6
         * @author Francesco Licandro
         * @return boolean
         */
        public function load_frontend(){
            $enable = yinfs_get_option( 'yith-infs-enable', 'yes' ) == 'yes';

            return $enable;
        }

		/**
		 * Load Plugin Framework
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 * @author Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if( ! empty( $plugin_fw_data ) ){
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file );
                }
			}
		}
	}
}

/**
 * Unique access to instance of YITH_INFS class
 *
 * @return \YITH_INFS
 * @since 1.0.0
 */
function YITH_INFS(){
	return YITH_INFS::get_instance();
}