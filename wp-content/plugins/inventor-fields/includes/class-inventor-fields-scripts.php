<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Fields_Scripts
 *
 * @class Inventor_Fields_Scripts
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Fields_Scripts {
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
    public static function enqueue_backend() {
        wp_enqueue_script( 'inventor-fields', plugins_url( '/inventor-fields/assets/js/inventor-fields.js' ), array( 'jquery' ), '20160526', true );
    }
}

Inventor_Fields_Scripts::init();