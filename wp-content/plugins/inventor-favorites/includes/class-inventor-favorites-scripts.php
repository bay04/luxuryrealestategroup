<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Scripts
 *
 * @class Inventor_Favorites_Scripts
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Scripts {
    /**
     * Initialize scripts
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
    }

    /**
     * Loads frontend files
     *
     * @access public
     * @return void
     */
    public static function enqueue_frontend() {
        wp_enqueue_script( 'inventor-favorites', plugins_url( '/inventor-favorites/assets/js/inventor-favorites.js' ), array( 'jquery' ), '20161119', true );
    }
}

Inventor_Favorites_Scripts::init();