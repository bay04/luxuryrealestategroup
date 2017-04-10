<?php
/**
 * Common functions
 *
 * @author Yithemes
 * @package YITH Infinite Scrolling
 * @version 1.0.0
 */
if ( ! defined( 'YITH_INFS' ) ) {
	exit;
} // Exit if accessed directly

if( ! function_exists( 'yinfs_get_option' ) ) {
    /**
     * Get plugin options
     *
     * @since 1.0.6
     * @author Francesco Licandro
     * @param string $option
     * @param boolean $default
     * @return mixed
     */
    function yinfs_get_option( $option, $default = false ){
        // get all options
        $options = get_option( YITH_INFS_OPTION_NAME );

        if( isset( $options[ $option ] ) ) {
            return $options[ $option ];
        }

        return $default;
    }
}