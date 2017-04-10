<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Widget_Collections
 *
 * @class Inventor_Favorites_Widget_Collections
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Widget_Collections extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     */
    function __construct() {
        parent::__construct(
            'favorite_collections_widget',
            __( 'Collections', 'inventor-favorites' ),
            array(
                'description' => __( 'Collections of listings.', 'inventor-favorites' ),
            )
        );
    }

    /**
     * Frontend
     *
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget( $args, $instance ) {
        if ( class_exists( 'Inventor_Template_Loader' ) ) {
            include Inventor_Template_Loader::locate( 'widgets/collections', $plugin_dir = INVENTOR_FAVORITES_DIR );
        }
    }

    /**
     * Update
     *
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    /**
     * Backend
     *
     * @access public
     * @param array $instance
     * @return void
     */
    function form( $instance ) {
        if ( class_exists( 'Inventor_Template_Loader' ) ) {
            include Inventor_Template_Loader::locate( 'widgets/collections-admin', INVENTOR_FAVORITES_DIR );
            include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
            include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
        }
    }
}