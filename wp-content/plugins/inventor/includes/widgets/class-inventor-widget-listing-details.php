<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Widget_Listing_Details
 *
 * @class Inventor_Widget_Listing_Details
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Listing_Details extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     */
    function __construct() {
        parent::__construct(
            'listing_details',
            __( 'Listing details', 'inventor' ),
            array(
                'description' => __( 'Displays listing details.', 'inventor' ),
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
        include Inventor_Template_Loader::locate( 'widgets/listing-details' );
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
        include Inventor_Template_Loader::locate( 'widgets/listing-details-admin' );
        include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
        include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
    }
}