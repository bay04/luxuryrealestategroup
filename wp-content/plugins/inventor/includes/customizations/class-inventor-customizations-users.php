<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Customizations_Users
 *
 * @class Inventor_Customizations_Users
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Customizations_Users {
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
        $wp_customize->add_section( 'inventor_users', array(
            'title' 	=> __( 'Inventor Users', 'inventor' ),
            'priority' 	=> 1,
        ) );

        // Log in after registration
        $wp_customize->add_setting( 'inventor_log_in_after_registration', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_log_in_after_registration', array(
            'type'          => 'checkbox',
            'label'         => __( 'Automatically log user in after registration', 'inventor' ),
            'description'	=> __( "User won't have to sing in after registration", 'inventor' ),
            'section'       => 'inventor_users',
            'settings'      => 'inventor_log_in_after_registration',
        ) );

        // Disable user billing details
        // @TODO: rename to inventor_disable_user_billing_details
        $wp_customize->add_setting( 'inventor_general_disable_user_billing_details', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_disable_user_billing_details', array(
            'type'      	=> 'checkbox',
            'label'     	=> __( 'Disable user billing details', 'inventor' ),
            'description'	=> __( 'Hide billing fields from user profile', 'inventor' ),
            'section'   	=> 'inventor_users',
            'settings'  	=> 'inventor_general_disable_user_billing_details',
        ) );

        // Show country field as a dropdown
        $wp_customize->add_setting( 'inventor_users_country_dropdown_enabled', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_users_country_dropdown_enabled', array(
            'type'      	=> 'checkbox',
            'label'     	=> __( 'Country dropdown', 'inventor' ),
            'description'	=> __( 'Show user address country field as a dropdown', 'inventor' ),
            'section'   	=> 'inventor_users',
            'settings'  	=> 'inventor_users_country_dropdown_enabled',
        ) );
    }
}

Inventor_Customizations_Users::init();
