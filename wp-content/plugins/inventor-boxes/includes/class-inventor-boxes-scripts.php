<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Boxes_Scripts
 *
 * @class Inventor_Boxes_Scripts
 * @package Inventor_Boxes/Classes
 * @author Pragmatic Mates
 */
class Inventor_Boxes_Scripts {
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
        wp_enqueue_script( 'inventor-boxes', plugins_url( '/inventor-boxes/assets/js/inventor-boxes.js' ), array( 'jquery' ), false, true );
        wp_enqueue_script( 'animateNumber', plugins_url( '/inventor-boxes/assets/libraries/jquery.animateNumber.min.js' ), array( 'jquery' ), false, true );
    }
}

Inventor_Boxes_Scripts::init();
