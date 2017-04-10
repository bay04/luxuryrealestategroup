<?php

/**
 * Plugin Name: Inventor Notifications
 * Version: 0.9.0
 * Description: Adds email notifications.
 * Author: Pragmatic Mates
 * Author URI: http://inventorwp.com
 * Plugin URI: http://inventorwp.com/plugins/inventor-notifications/
 * Text Domain: inventor-notifications
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'Inventor_Notifications' ) && class_exists( 'Inventor' ) ) {
    /**
     * Class Inventor_Notifications
     *
     * @class Inventor_Notifications
     * @package Inventor_Notifications
     * @author Pragmatic Mates
     */
    final class Inventor_Notifications {
        const DOMAIN = 'inventor-notifications';

        /**
         * Initialize Inventor_Notifications plugin
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
            define( 'INVENTOR_NOTIFICATIONS_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INVENTOR_NOTIFICATION_PREFIX', 'notification_' );

            define( 'INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE', 'PACKAGE_WILL_EXPIRE' );
            define( 'INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED', 'PACKAGE_EXPIRED' );
            define( 'INVENTOR_MAIL_ACTION_PACKAGE_PURCHASED_ADMIN', 'PACKAGE_PURCHASED_ADMIN' );
            define( 'INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN', 'SUBMISSION_PENDING_ADMIN' );
            define( 'INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER', 'SUBMISSION_PENDING_USER' );
            define( 'INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN', 'SUBMISSION_PUBLISHED_ADMIN' );
            define( 'INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER', 'SUBMISSION_PUBLISHED_USER' );
        }

        /**
         * Include classes
         *
         * @access public
         * @return void
         */
        public function includes() {
            require_once INVENTOR_NOTIFICATIONS_DIR . 'includes/class-inventor-notifications-post-type-notification.php';
            require_once INVENTOR_NOTIFICATIONS_DIR . 'includes/class-inventor-notifications-customizations.php';
            require_once INVENTOR_NOTIFICATIONS_DIR . 'includes/class-inventor-notifications-logic.php';
        }
    }

    new Inventor_Notifications();
}