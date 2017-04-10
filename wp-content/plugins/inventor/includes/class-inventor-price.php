<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Price
 *
 * @class Inventor_Price
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Price {
	/**
	 * Gets listing price amount
	 *
	 * @access public
	 * @param $listing_id
	 * @return bool|float
	 */
	public static function get_listing_price( $listing_id ) {
		$price = get_post_meta( $listing_id, INVENTOR_LISTING_PREFIX . 'price', true );

		if ( empty( $price ) || ! is_numeric( $price ) ) {
			return false;
		}

		return $price;
	}

	/**
	 * Returns formatted price with currency and prefix + suffix
	 *
	 * @access public
	 * @param null $post_id
	 * @return bool|string
	 */
	public static function get_price( $post_id = null ) {
		if ( null == $post_id ) {
			$post_id = get_the_ID();
		}

		$custom = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . 'price_custom', true );

		if ( ! empty( $custom ) ) {
			return $custom;
		}

		$price = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . 'price', true );

		if ( empty( $price ) || ! is_numeric( $price ) ) {
			return false;
		}

		// specify currency
		$currency = self::current_currency();
		$currency = apply_filters( 'inventor_currency', $currency, $post_id );

		// format price using currency settings
		$price = self::format_price( $price, false, $currency );

		$prefix = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . 'price_prefix', true );
		$suffix = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . 'price_suffix', true );

		if ( ! empty( $prefix ) ) {
			$price = $prefix . ' ' . $price;
		}

		if ( ! empty( $suffix ) ) {
			$price = $price .  ' ' . $suffix;
		}

		return $price;
	}

    /**
     * Gets price in cents format
     *
     * @access public
     * @param $amount
     * @return int
     */
    public static function get_price_in_cents( $amount ) {
        return intval( $amount * 100 );
    }

	/**
	 * Formats price with current currency
	 *
	 * @access public
	 * @param $amount float
	 * @param $show_zero_decimals bool
	 * @param $currency array
	 * @return bool|string
	 */
	public static function format_price( $amount, $show_zero_decimals = false, $currency = null ) {
		if ( ! isset( $amount ) ) {
			echo $amount. ' is not set';
		}

		if ( ! isset( $amount ) || ! is_numeric( $amount ) ) {
			return false;
		}

		if ( empty( $currency ) ) {
			$currency = self::current_currency();
		}

		$amount = $amount * $currency['rate'];

		$amount_parts_dot = explode( '.', $amount );
		$amount_parts_col = explode( ',', $amount );

		$show_decimals = count( $amount_parts_dot ) > 1 || count( $amount_parts_col ) > 1;

		if ( $show_decimals || $show_zero_decimals ) {
			$decimals = $currency['money_decimals'];
		} else {
			$decimals = 0;
		}

		$dec_point = $currency['money_dec_point'];
		$thousands_separator = $currency['money_thousands_separator'];
		$thousands_separator = str_replace("space", " ", $thousands_separator );

		$amount = number_format( $amount, $decimals, $dec_point, $thousands_separator );

		$currency_symbol = $currency['symbol'];
		$currency_show_symbol_after = $currency['show_symbol_after'];

		if ( ! empty( $currency_symbol ) ) {
			if ( $currency_show_symbol_after ) {
				$price = $amount . $currency_symbol;
			} else {
				$price = $currency_symbol . $amount;
			}
		} else {
			$price = $amount;
		}

		return $price;
	}

	/**
	 * Returns current currency
	 *
	 * @access public
	 * @return string
	 */
	public static function current_currency() {
		$currencies = get_theme_mod( 'inventor_currencies' );

		$currency_index = 0;
		$currency_rate = 1;

		// Inventor Currencies filters
		$currency_index = apply_filters( 'inventor_currencies_current_currency_index', $currency_index );
		$currency_rate = apply_filters( 'inventor_currencies_current_currency_rate', $currency_rate );

		$currency_code = ! empty( $currencies[$currency_index]['code'] ) ? $currencies[$currency_index]['code'] : 'USD';
		$currency_symbol = ! empty( $currencies[$currency_index]['symbol'] ) ? $currencies[$currency_index]['symbol'] : '$';
		$currency_show_symbol_after = ! empty( $currencies[$currency_index]['show_after'] ) ? true : false; // TODO: show_after > show_symbol_after

		$decimals = ! empty( $currencies[$currency_index]['money_decimals'] ) ? $currencies[$currency_index]['money_decimals'] : 0;
		$dec_point = ! empty( $currencies[$currency_index]['money_dec_point'] ) ? $currencies[$currency_index]['money_dec_point'] : '.';
		$thousands_separator = (
			! empty( $currencies[$currency_index]['money_thousands_separator'] ) ||
			( isset( $currencies[$currency_index]['money_thousands_separator'] ) && $currencies[$currency_index]['money_thousands_separator'] == '' )
		) ? $currencies[$currency_index]['money_thousands_separator'] : ',';

		return array(
			'code'						=> $currency_code,
			'symbol'					=> $currency_symbol,
			'show_symbol_after'			=> $currency_show_symbol_after,
			'rate'						=> $currency_rate,
			'money_decimals'			=> $decimals,
			'money_dec_point'			=> $dec_point,
			'money_thousands_separator'	=> $thousands_separator,
		);
	}

	/**
	 * Returns default currency
	 *
	 * @access public
	 * @return string
	 */
	public static function default_currency() {
		return array(
			'code'		=> self::default_currency_code(),
			'symbol'	=> self::default_currency_symbol(),
			'rate'		=> 1
		);
	}

	/**
	 * Returns default currency code
	 *
	 * @access public
	 * @return string
	 */
	public static function default_currency_code() {
		$currencies = get_theme_mod( 'inventor_currencies', array() );

		if ( ! empty( $currencies ) && is_array( $currencies ) ) {
			$currency = array_shift( $currencies );
			$currency_code = $currency['code'];
		} else {
			$currency_code = 'USD';
		}

		return $currency_code;
	}

	/**
	 * Returns default currency symbol
	 *
	 * @access public
	 * @return string
	 */
	public static function default_currency_symbol() {
		$currencies = get_theme_mod( 'inventor_currencies', array() );

		if ( ! empty( $currencies ) && is_array( $currencies ) ) {
			$currency = array_shift( $currencies );
			$currency_code = $currency['symbol'];
		} else {
			$currency_code = '$';
		}

		return $currency_code;
	}
}