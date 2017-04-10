<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Widget_Favorites
 *
 * @class Inventor_Widget_Favorites
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Widget_Favorites extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     */
    function __construct() {
        parent::__construct(
            'favorites_widget',
            __( 'Favorite listings', 'inventor-favorites' ),
            array(
                'description' => __( 'Favorite listings.', 'inventor-favorites' ),
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
        Inventor_Favorites_Logic::loop_my_favorites();

        if ( class_exists( 'Inventor_Template_Loader' ) ) {
            include Inventor_Template_Loader::locate( 'widgets/favorites', $plugin_dir = INVENTOR_FAVORITES_DIR );
        }

        wp_reset_query();
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
            include Inventor_Template_Loader::locate( 'widgets/favorites-admin', INVENTOR_FAVORITES_DIR );
            include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
            include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
        }
    }
}