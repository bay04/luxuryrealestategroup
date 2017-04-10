<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Recaptcha_Scripts
 *
 * @class Inventor_Recaptcha_Scripts
 * @package Inventor_Recaptcha/Classes
 * @author Pragmatic Mates
 */
class Inventor_Recaptcha_Scripts {
    /**
     * Initialize scripts
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
        add_filter( 'inventor_asynchronous_scripts', array( __CLASS__, 'asynchronous_scripts' ) );
    }

    /**
     * Adds JavaScript files to load asynchronously using async defer attributes
     *
     * @access public
     * @param $handles
     * @return array
     */
    public static function asynchronous_scripts( $handles ) {
        $handles[] = 'recaptcha';
        $handles[] = 'inventor-recaptcha';
        return $handles;
    }

    /**
     * Loads frontend files
     *
     * @access public
     * @return void
     */
    public static function enqueue_frontend() {
        if ( Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) {
            wp_enqueue_script( 'inventor-recaptcha', plugins_url( '/inventor-recaptcha/assets/js/inventor-recaptcha.js' ), array(), true, true );
            wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit', array(), true, true );
        }
    }
}

Inventor_Recaptcha_Scripts::init();