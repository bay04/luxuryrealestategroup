<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Packages_Shortcodes
 *
 * @class Inventor_Packages_Shortcodes
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Packages_Shortcodes {
    /**
     * Initialize shortcodes
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_shortcode( 'inventor_package_info', array( __CLASS__, 'package_info' ) );
    }


    /**
     * Package information
     *
     * @access public
     * @param $atts
     * @return string
     */
    public static function package_info( $atts = array() ) {
        if ( ! is_user_logged_in() ) {
            return Inventor_Template_Loader::load( 'misc/not-allowed' );
        }

        return Inventor_Template_Loader::load( 'package-info', array(), INVENTOR_PACKAGES_DIR );
    }
}

Inventor_Packages_Shortcodes::init();
