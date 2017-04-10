<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Shortcodes
 *
 * @class Inventor_Favorites_Shortcodes
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Shortcodes {
    /**
     * Initialize shortcodes
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_shortcode( 'inventor_favorites', array( __CLASS__, 'favorites' ) );
        add_shortcode( 'inventor_favorites_create_collection', array( __CLASS__, 'create_collection' ) );
    }

    /**
     * Favorites
     *
     * @access public
     * @param $atts
     * @return void
     */
    public static function favorites( $atts ) {
        if ( ! is_user_logged_in() ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed' );
            return;
        }

        $collection_id = empty( $_GET['collection-id'] ) ? null : esc_attr( $_GET['collection-id'] );
        Inventor_Favorites_Logic::loop_my_favorites( $collection_id );
        echo Inventor_Template_Loader::load( 'favorites', $atts, $plugin_dir = INVENTOR_FAVORITES_DIR );
        wp_reset_query();
    }

    /**
     * Create collection
     *
     * @access public
     * @param $atts
     * @return void
     */
    public static function create_collection( $atts ) {
        if ( ! is_user_logged_in() ) {
            echo Inventor_Template_Loader::load( 'misc/not-allowed' );
            return;
        }

        echo Inventor_Template_Loader::load( 'create-collection', $atts, $plugin_dir = INVENTOR_FAVORITES_DIR );
    }
}

Inventor_Favorites_Shortcodes::init();