<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Customizations_Pages
 *
 * @class Inventor_Customizations_Pages
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Customizations_Pages {
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

        $wp_customize->add_section('inventor_pages', array(
            'title' => __( 'Inventor Pages', 'inventor' ),
            'priority' => 1,
        ));

        // Post Types
        $post_types = Inventor_Post_types::get_all_listing_post_types();
        $types = array();

        if ( is_array( $post_types ) ) {
            foreach ( $post_types as $obj ) {
                $types[ $obj->name ] = $obj->labels->name;
            }
        }

        // Login required
        $wp_customize->add_setting( 'inventor_general_login_required_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_login_required_page', array(
            'type'          => 'select',
            'label'         => __( 'Login Required', 'inventor' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_general_login_required_page',
            'choices'       => $pages,
        ) );

        // After login
        $wp_customize->add_setting( 'inventor_general_after_login_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_after_login_page', array(
            'type'          => 'select',
            'label'         => __( 'After Login', 'inventor' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_general_after_login_page',
            'choices'       => $pages,
        ) );

        // Registration
        $wp_customize->add_setting( 'inventor_general_registration_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_registration_page', array(
            'type'          => 'select',
            'label'         => __( 'Registration', 'inventor' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_general_registration_page',
            'choices'       => $pages,
        ) );

        // After register
        $wp_customize->add_setting( 'inventor_general_after_register_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_after_register_page', array(
            'type'          => 'select',
            'label'         => __( 'After Register', 'inventor' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_general_after_register_page',
            'choices'       => $pages,
        ) );

        // Profile
        $wp_customize->add_setting( 'inventor_general_profile_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_profile_page', array(
            'type'          => 'select',
            'label'         => __( 'Profile', 'inventor' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_general_profile_page',
            'choices'       => $pages,
        ) );

        // Change password
        $wp_customize->add_setting( 'inventor_general_password_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_password_page', array(
            'type'          => 'select',
            'label'         => __( 'Change password', 'inventor' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_general_password_page',
            'choices'       => $pages,
        ) );

        // Reset forgotten password
        $wp_customize->add_setting( 'inventor_general_reset_password_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_reset_password_page', array(
            'type'          => 'select',
            'label'         => __( 'Reset forgotten password', 'inventor' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_general_reset_password_page',
            'choices'       => $pages,
        ) );

        // Terms and conditions
        $wp_customize->add_setting('inventor_general_terms_and_conditions_page', array(
            'default' => null,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('inventor_general_terms_and_conditions_page', array(
            'type' => 'select',
            'label' => __('Terms & Conditions', 'inventor'),
            'section' => 'inventor_pages',
            'settings' => 'inventor_general_terms_and_conditions_page',
            'choices' => $pages,
        ));

        // Report listing
        $wp_customize->add_setting('inventor_general_report_page', array(
            'default' => null,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('inventor_general_report_page', array(
            'type' => 'select',
            'label' => __('Report listing', 'inventor'),
            'section' => 'inventor_pages',
            'settings' => 'inventor_general_report_page',
            'choices' => $pages,
        ));

        // Payment
        $wp_customize->add_setting( 'inventor_general_payment_page', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_payment_page', array(
            'type'              => 'select',
            'label'             => __( 'Payment', 'inventor' ),
            'section'           => 'inventor_pages',
            'settings'          => 'inventor_general_payment_page',
            'choices'           => $pages,
        ) );

        // After payment
        $wp_customize->add_setting( 'inventor_general_after_payment_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_after_payment_page', array(
            'type'          => 'select',
            'label'         => __( 'After Payment', 'inventor' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_general_after_payment_page',
            'choices'       => $pages,
        ) );

        // Transactions
        $wp_customize->add_setting( 'inventor_general_transactions_page', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_general_transactions_page', array(
            'type'              => 'select',
            'label'             => __( 'Transactions', 'inventor' ),
            'section'           => 'inventor_pages',
            'settings'          => 'inventor_general_transactions_page',
            'choices'           => $pages,
        ) );
    }
}

Inventor_Customizations_Pages::init();
