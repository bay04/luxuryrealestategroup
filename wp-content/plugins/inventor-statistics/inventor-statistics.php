<?php

/**
 * Plugin Name: Inventor Statistics
 * Version: 1.2.0
 * Description: Collects listing views and search queries and transforms it to statistics.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-statistics/
 * Text Domain: inventor-statistics
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! class_exists( 'Inventor_Statistics' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Statistics
     *
     * @class Inventor_Statistics
     * @package Inventor_Statistics
     * @author Pragmatic Mates
     */
    final class Inventor_Statistics {
        const DOMAIN = 'inventor-statistics';

        /**
         * Initialize Inventor_Statistics plugin
         */
        public function __construct() {
            $this->init();
            $this->constants();
            $this->includes();
            $this->activation_hooks();
            if ( class_exists( 'Inventor_Utilities' ) ) {
                Inventor_Utilities::load_plugin_textdomain( self::DOMAIN, __FILE__ );
            }
        }

        /**
         * Initialize statistics functionality
         *
         * @access public
         * @return void
         */
        public static function init() {
            add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
        }

        /**
         * Registers menu items
         *
         * @access public
         * @return void
         */
        public static function menu() {
            add_submenu_page( 'inventor', __( 'Listing Views', 'inventor-statistics' ), __( 'Listing views', 'inventor-statistics' ), 'manage_options', 'listing_views', array( __CLASS__, 'listing_views_template' ) );
            add_submenu_page( 'inventor', __( 'Search Queries', 'inventor-statistics' ), __( 'Search Queries', 'inventor-statistics' ), 'manage_options', 'search_queries', array( __CLASS__, 'search_queries_template' ) );
        }

        /**
         * Defines constants
         *
         * @access public
         * @return void
         */
        public function constants() {
            define( 'INVENTOR_STATISTICS_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_STATISTICS_TOTAL_VIEWS_META', 'inventor_statistics_post_total_views' );
        }

        /**
         * Search queries template
         *
         * @access public
         * @return void
         */
        public static function search_queries_template() {
            echo Inventor_Template_Loader::load( 'admin/search-queries', array(), $plugin_dir = INVENTOR_STATISTICS_DIR );
        }

        /**
         * Property views template
         *
         * @access public
         * @return void
         */
        public static function listing_views_template() {
            echo Inventor_Template_Loader::load( 'admin/listing-views', array(), $plugin_dir = INVENTOR_STATISTICS_DIR);
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_STATISTICS_DIR . 'includes/class-inventor-statistics-customizations.php';
            require_once INVENTOR_STATISTICS_DIR . 'includes/class-inventor-statistics-scripts.php';
            require_once INVENTOR_STATISTICS_DIR . 'includes/class-inventor-statistics-logic.php';
        }

        /**
         * Fires activation hooks
         *
         * @access public
         * @return void
         */
        public function activation_hooks() {
            register_activation_hook( __FILE__, array( __CLASS__, 'install_search_queries' ) );
            register_activation_hook( __FILE__, array( __CLASS__, 'install_listing_views' ) );
        }

        /**
         * Installs search query table
         *
         * @access public
         * @return void
         */
        public static function install_search_queries() {
            global $wpdb;

            $table_name = $wpdb->prefix . 'query_stats';

            if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name )  {
                $charset_collate = $wpdb->get_charset_collate();

                $sql = 'CREATE TABLE `'. $table_name .'` (
                    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `key` varchar(200) NOT NULL DEFAULT \'\',
                    `value` text NOT NULL,
                    `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `key` (`key`)
                ) ENGINE=InnoDB DEFAULT CHARSET=' . $charset_collate . ';';

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
            }
        }

        /**
         * Installs listing views table
         *
         * @access public
         * @return void
         */
        public static function install_listing_views() {
            global $wpdb;

            $table_name = $wpdb->prefix . 'listing_stats';

            if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name )  {
                $charset_collate = $wpdb->get_charset_collate();

                $sql = 'CREATE TABLE `'. $table_name .'` (
                    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `key` varchar(200) NOT NULL DEFAULT \'\',
                    `value` text NOT NULL,
                    `ip` varchar(200) NOT NULL DEFAULT \'\',
                    `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `key` (`key`)
                ) ENGINE=InnoDB DEFAULT CHARSET=' . $charset_collate . ';';

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
            }
        }
    }

    new Inventor_Statistics();
}