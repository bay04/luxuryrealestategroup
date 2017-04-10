<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Recaptcha_Logic
 *
 * @class Inventor_Recaptcha_Logic
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Recaptcha_Logic {
    /**
     * Checks if reCAPTCHA is enabled
     *
     * @access public
     * @return bool
     */
    public static function is_recaptcha_enabled() {
        $site_key = get_theme_mod( 'inventor_recaptcha_site_key', null );
        $secret_key = get_theme_mod( 'inventor_recaptcha_secret_key', null );

        if ( ! empty( $site_key ) && ! empty( $secret_key ) ) {
            return true;
        }

        return false;
    }

    /**
     * Checks if reCAPTCHA is valid
     *
     * @access public
     * @param $recaptcha_response string
     * @return bool
     */
    public static function is_recaptcha_valid( $recaptcha_response ) {
        $secret_key = get_theme_mod( 'inventor_recaptcha_secret_key', null );
        $url = INVENTOR_RECAPTCHA_URL . '?secret=' . $secret_key . '&response=' . $recaptcha_response;

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );

        $output = curl_exec( $ch );
        $result = json_decode( $output, true );

        if ( array_key_exists( 'success', $result ) && 1 == $result['success'] ) {
            return true;
        }

        return false;
    }
}