<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Packages_Scripts
 *
 * @class Inventor_Scripts
 * @package Inventor_Packages/Classes
 * @author Pragmatic Mates
 */
class Inventor_Packages_Scripts {
    /**
     * Initialize scripts
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_backend' ) );
    }

    /**
     * Loads backend files
     *
     * @access public
     * @return void
     */
    public static function enqueue_backend( $hook ) {
        wp_enqueue_script( 'inventor-packages-admin', plugins_url( '/inventor-packages/assets/js/inventor-packages-admin.js' ), array( 'jquery' ), '20160517', true );
    }
}

Inventor_Packages_Scripts::init();
