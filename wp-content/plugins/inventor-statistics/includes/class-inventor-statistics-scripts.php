<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Statistics_Scripts
 *
 * @class Inventor_Statistics_Scripts
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Statistics_Scripts {
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
        wp_enqueue_script( 'd3', plugins_url( '/inventor-statistics/libraries/d3/d3.v3.js' ), array( 'jquery' ), false, true );
        wp_enqueue_script( 'nvd3', plugins_url( '/inventor-statistics/libraries/nvd3/nv.d3.min.js' ), array( 'jquery' ), false, true );
        wp_enqueue_style( 'nvd3', plugins_url( '/inventor-statistics/libraries/nvd3/nv.d3.min.css' ) );
        wp_enqueue_script( 'inventor-statistics-charts', plugins_url( '/inventor-statistics/assets/js/inventor-statistics.js' ), array( 'jquery' ), false, true );
        wp_enqueue_style( 'inventor-statistics', plugins_url( '/inventor-statistics/assets/css/inventor-statistics.css' ) );
    }
}

Inventor_Statistics_Scripts::init();