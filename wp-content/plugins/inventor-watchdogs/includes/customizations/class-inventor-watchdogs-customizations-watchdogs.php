<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Watchdogs_Customizations_Watchdogs
 *
 * @class Inventor_Watchdogs_Customizations_Watchdogs
 * @package Inventor_Watchdogs/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Watchdogs_Customizations_Watchdogs {
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
        $pages = Inventor_Utilities::get_pages();

        $wp_customize->add_section( 'inventor_watchdogs', array(
            'title'     => __( 'Inventor Watchdogs', 'inventor-watchdogs' ),
            'priority'  => 1,
        ) );

        // Watchdogs
        $wp_customize->add_setting('inventor_watchdogs_page', array(
            'default' => null,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('inventor_watchdogs_page', array(
            'type' => 'select',
            'label' => __('Watchdogs', 'inventor-watchdogs'),
            'section' => 'inventor_pages',
            'settings' => 'inventor_watchdogs_page',
            'choices' => $pages,
        ));

        // Listing logging
        $wp_customize->add_setting( 'inventor_watchdogs_enable_search_queries', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_watchdogs_enable_search_queries', array(
            'type'     => 'checkbox',
            'label'    => __( 'Enable Search Queries Watchdogs', 'inventor-watchdogs' ),
            'section'  => 'inventor_watchdogs',
            'settings' => 'inventor_watchdogs_enable_search_queries',
        ) );
    }
}

Inventor_Watchdogs_Customizations_Watchdogs::init();
