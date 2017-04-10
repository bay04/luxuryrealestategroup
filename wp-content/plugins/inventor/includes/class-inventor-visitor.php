<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Visitor
 *
 * @class Inventor_Visitor
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Visitor {
    /**
     * Initialize class
     *
     * @access public
     * @return void
     */
    public static function init() {
    }

    /**
     * Saves visitor data
     *
     * @access public
     * @param string $key
     * @param string $value
     * @param int $expire
     * @return void
     */
    public static function save_data( $key, $value, $expire = 0 ) {
        if ( 'SESSION' == apply_filters( 'inventor_visitor_data_storage', INVENTOR_DEFAULT_VISITOR_DATA_STORAGE ) ) {
            $_SESSION[ $key ] = $value;
        } else {
            $value = json_encode( $value );
            setcookie( $key, $value, $expire, $path = '/' );
        }
    }

    /**
     * Returns visitor data by key
     *
     * @access public
     * @param string $key
     * @return mixed
     */
    public static function get_data( $key ) {
        if ( 'SESSION' == apply_filters( 'inventor_visitor_data_storage', INVENTOR_DEFAULT_VISITOR_DATA_STORAGE ) ) {
            if ( isset( $_SESSION[ $key ] ) ) {
                return $_SESSION[ $key ];
            }
        } else {
            if ( isset( $_COOKIE[ $key ] ) ) {
                return json_decode( stripcslashes($_COOKIE[ $key ]), true);
            }
        }

        return null;
    }

    /**
     * Returns visitor data by key
     *
     * @access public
     * @param string $key
     * @return mixed
     */
    public static function unset_data( $key ) {
        if ( 'SESSION' == apply_filters( 'inventor_visitor_data_storage', INVENTOR_DEFAULT_VISITOR_DATA_STORAGE ) ) {
            if ( isset( $_SESSION[ $key ] ) ) {
                unset ( $_SESSION[ $key ] );
            }
        } else {
            if ( isset( $_COOKIE[ $key ] ) ) {
                unset ( $_COOKIE[ $key ] );
                setcookie( $key, null, strtotime('-1 day'), '/' );
            }
        }
    }
}

Inventor_Visitor::init();