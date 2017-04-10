<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Customizations_Statistics
 *
 * @class Inventor_Statistics_Customizations_Statistics
 * @package Inventor_Statistics/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Statistics_Customizations_Statistics {
    /**
     * Initialize customization type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'customize_register', array( __CLASS__, 'customizations' ) );
    }

    /**
     * Customizations
     *
     * @access public
     * @param object $wp_customize
     * @return void
     */
    public static function customizations( $wp_customize ) {
        $wp_customize->add_section( 'inventor_statistics', array(
            'title'     => __( 'Inventor Statistics', 'inventor-statistics' ),
            'priority'  => 1,
        ) );

        // Query logging
        $wp_customize->add_setting( 'inventor_statistics_enable_query_logging', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_statistics_enable_query_logging', array(
            'type'     => 'checkbox',
            'label'    => __( 'Enable Search Query Logging', 'inventor-statistics' ),
            'section'  => 'inventor_statistics',
            'settings' => 'inventor_statistics_enable_query_logging',
        ) );

        // Listing logging
        $wp_customize->add_setting( 'inventor_statistics_enable_listing_logging', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_statistics_enable_listing_logging', array(
            'type'     => 'checkbox',
            'label'    => __( 'Enable Listing Views Logging', 'inventor-statistics' ),
            'section'  => 'inventor_statistics',
            'settings' => 'inventor_statistics_enable_listing_logging',
        ) );
    }
}

Inventor_Statistics_Customizations_Statistics::init();
