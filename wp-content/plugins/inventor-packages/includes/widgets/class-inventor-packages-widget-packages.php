<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Packages_Widget_Packages
 *
 * @class Inventor_Packages_Widget_Packages
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Packages_Widget_Packages extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     */
    function __construct() {
        parent::__construct(
            'packages',
            __( 'Packages', 'inventor-packages' ),
            array(
                'description' => __( 'Displays available packages.', 'inventor-packages' ),
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
        query_posts( array(
            'post_type'         => 'package',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
        ) );

        if ( class_exists( 'Inventor_Template_Loader' ) ) {
            include Inventor_Template_Loader::locate( 'widgets/packages', INVENTOR_PACKAGES_DIR );
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
            include Inventor_Template_Loader::locate( 'widgets/packages-admin', INVENTOR_PACKAGES_DIR );
            include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
            include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
        }
    }
}