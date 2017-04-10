<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Recaptcha_Customizations_Recaptcha
 *
 * @class Inventor_Recaptcha_Customizations_Recaptcha
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Recaptcha_Customizations_Recaptcha {
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
        $wp_customize->add_section( 'inventor_recaptcha', array(
            'title'     => __( 'Inventor reCAPTCHA', 'inventor' ),
            'priority'  => 1,
        ) );

        // Site key
        $wp_customize->add_setting( 'inventor_recaptcha_site_key', array(
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_recaptcha_site_key', array(
            'label'     => __( 'Site Key', 'inventor' ),
            'section'   => 'inventor_recaptcha',
            'settings'  => 'inventor_recaptcha_site_key',
        ) );

        // Secret key
        $wp_customize->add_setting( 'inventor_recaptcha_secret_key', array(
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_recaptcha_secret_key', array(
            'label'     => __( 'Secret Key', 'inventor' ),
            'section'   => 'inventor_recaptcha',
            'settings'  => 'inventor_recaptcha_secret_key',
        ) );
    }
}

Inventor_Recaptcha_Customizations_Recaptcha::init();
