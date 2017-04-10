<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Notifications_Customizations
 *
 * @access public
 * @package Inventor_Notifications/Classes/Customizations
 * @return void
 */
class Inventor_Notifications_Customizations {
    /**
     * Initialize customizations
     *
     * @access public
     * @return void
     */
    public static function init() {
        self::includes();
    }

    /**
     * Include all customizations
     *
     * @access public
     * @return void
     */
    public static function includes() {
        require_once INVENTOR_NOTIFICATIONS_DIR . 'includes/customizations/class-inventor-notifications-customizations-notifications.php';
    }
}

Inventor_Notifications_Customizations::init();