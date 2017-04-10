<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Currencies_Logic
 *
 * @class Inventor_Currencies_Logic
 * @package Inventor_Currencies/Classes
 * @author Pragmatic Mates
 */
class Inventor_Currencies_Logic {
    /**
     * Initialize Currencies functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'set_currency_code' ) );
        add_action( 'init', array( __CLASS__, 'currencies_refresh' ) );

        add_filter( 'inventor_currencies_current_currency_index', array( __CLASS__, 'get_current_currency_index' ) );
        add_filter( 'inventor_currencies_current_currency_rate', array( __CLASS__, 'get_current_currency_rate' ) );
        add_filter( 'inventor_filter_params', array( __CLASS__, 'modify_filter_price_param' ) );
    }

    /**
     * Gets Currencies config.
     *
     * @access public
     * @return array|bool
     */
    public static function get_config() {
        $currencylayer_api_key = get_theme_mod( 'inventor_currencies_currencylayer_api_key', null );

        $currencies_config = array(
            "currencylayer_api_key" => $currencylayer_api_key,
        );

        return $currencies_config;
    }

    /**
     * Refresh all currency rates
     *
     * @access public
     * @return void
     */
    public static function currencies_refresh() {
        $rates = get_option( 'inventor_rates', null );
        $currencies = get_theme_mod( 'inventor_currencies' );
        $config = self::get_config();
        $api_key = $config['currencylayer_api_key'];
        $update = false;

        if ( $rates == null ) {
            $update = true;
        } elseif ( ( time() - $rates['modified'] ) > ( INVENTOR_CURRENCY_REFRESH ) ) {
            $update = true;
        }

        if ( empty($api_key) ) {
            return;
        }

        if ( $update && is_array( $currencies ) && count( $currencies ) > 0 ) {
            $currency_default = $currencies[0];
            $not_default_currency_codes = array();

            $index = 0;
            foreach ( $currencies as $currency ) {
                if ( $index != 0 ) {
                    array_push($not_default_currency_codes, $currency['code']);
                }
                $index++;
            }

            $query = sprintf( 'http://apilayer.net/api/live?source=%s&currencies=%s&access_key=%s', $currency_default['code'], implode(",", $not_default_currency_codes), $api_key );
            $contents = @file_get_contents( $query );

            if ( ! empty( $contents ) ) {
                $json = json_decode( $contents );
                if ( ! empty( $json ) && $json->success ) {
                    $quotes = (array)$json->quotes;

                    $index = 0;
                    foreach ( $currencies as $currency ) {
                        if ( $index != 0 ) {
                            $code_key = $currency_default['code'].$currency['code'];

                            $rate = round($quotes[$code_key], 6);

                            if (!empty($rate)) {
                                $currencies[$index]['rate'] = $rate;
                            }
                        }
                        $index++;
                    }
                }
            }

            set_theme_mod( 'inventor_currencies', $currencies);
            update_option( 'inventor_rates', array('modified' => time()) );
        }
    }

    /**
     * Set default currency
     *
     * @access public
     * @return void
     */
    public static function set_currency_code() {
        if ( ! empty( $_GET['currency_code'] ) ) {
            setcookie( 'currency_code', $_GET['currency_code'], $expires = 0, $path = '/' );
        }
    }

    /**
     * Gets current currency code
     *
     * @access public
     * @return string
     */
    public static function get_current_currency_code() {
        if ( ! empty( $_GET['currency_code'] ) ) {
            return $_GET['currency_code'];
        }

        if ( ! empty( $_COOKIE['currency_code'] ) ) {
            return $_COOKIE['currency_code'];
        }

        $currencies = get_theme_mod( 'inventor_currencies');
        $code = ! empty( $currencies['0']['code'] ) ? $currencies[0]['code'] : 'USD';
        return $code;
    }

    /**
     * Gets current currency symbol
     *
     * @access public
     * @return string
     */
    public static function get_current_currency_symbol() {
        $currency_index = self::get_current_currency_index();

        $currencies = get_theme_mod( 'inventor_currencies');
        $symbol = ! empty( $currencies[$currency_index]['symbol'] ) ? $currencies[$currency_index]['symbol'] : '$';
        return $symbol;
    }

    /**
     * Gets current currency index in customization
     *
     * @access public
     * @return int
     */
    public static function get_current_currency_index() {
        $currency_code = self::get_current_currency_code();

        if ( ! empty( $currency_code ) ) {
            $currencies = get_theme_mod( 'inventor_currencies' );

            if ( ! empty( $currencies ) && is_array( $currencies ) ) {
                foreach( $currencies as $key => $currency ) {
                    if ( $currency['code'] == self::get_current_currency_code() ) {
                        return $key;
                    }
                }
            }
        }

        return 0;
    }

    /**
     * Gets current currency rate
     *
     * @access public
     * @return float
     */
    public static function get_current_currency_rate() {
        $currencies = get_theme_mod( 'inventor_currencies' );
        $currency_index = self::get_current_currency_index();
        $rate = ! empty( $currencies[$currency_index]['rate'] ) ? $currencies[$currency_index]['rate'] : 1;
        return $rate;
    }

    /**
     * Modifies listing filter price param by current currency
     *
     * @access public
     * @return array
     */
    public static function modify_filter_price_param( $params ) {
        if( empty( $params['price'] ) ) {
            return $params;
        }

        $price_range = Inventor_Filter::get_field_range( 'price', $params );

        if( ! $price_range ) {
            return $params;
        }

        $currency_rate = self::get_current_currency_rate();

        if( $currency_rate == 1 ) {
            return $params;
        }

        $price_from = $price_range['from'];
        $price_to = $price_range['to'];

        if( $price_from ) {
            $price_from /= $currency_rate;
        }

        if( $price_to ) {
            $price_to /= $currency_rate;
        }

        if ( $price_from && $price_to ) {
            $price = "{$price_from}-{$price_to}";
        } else if ( $price_from && ! $price_to ) {
            $price = "{$price_from}-";
        } else if ( ! $price_from && $price_to ) {
            $price = "{$price_to}";
        } else {
            $price = $params['price'];
        }

        $params['price'] = $price;

        return $params;
    }
}

Inventor_Currencies_Logic::init();
