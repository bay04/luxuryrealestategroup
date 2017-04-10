<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Currencies_Shortcodes
 *
 * @class Inventor_Currencies_Shortcodes
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Currencies_Shortcodes {
    /**
     * Initialize shortcodes
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_shortcode( 'inventor_currencies', array( __CLASS__, 'currencies' ) );
    }

    /**
     * Currency switcher
     *
     * @access public
     * @return void|bool|string
     */
    public static function currencies( $atts ) {
        $atts = shortcode_atts( array(), $atts, 'inventor_currencies' );

        $currencies = get_theme_mod( 'inventor_currencies' );
        if ( $currencies == false ) {
            $currencies = array(
                array(
                    'symbol'                    => '$',
                    'code'                      => 'USD',
                    'show_after'                => false,
                    'money_decimals'            => 2,
                    'money_dec_point'           => '.',
                    'money_thousands_separator' => ','
                ),
            );
        } elseif ( ! is_array( $currencies ) ) {
            return false;
        }

        array_splice( $currencies, (int) get_theme_mod( 'inventor_currencies_other', 0 ) + 1 );
        $result = '';

        if ( ! empty( $currencies ) && is_array( $currencies ) ) {
            ksort($currencies);
            $currency_code = Inventor_Currencies_Logic::get_current_currency_code();

            $result = '';

            ob_start();
            include Inventor_Template_Loader::locate( 'currencies', $plugin_dir = INVENTOR_CURRENCIES_DIR );
            $result = ob_get_contents();
            ob_end_clean();
        }

        return $result;
    }
}

Inventor_Currencies_Shortcodes::init();