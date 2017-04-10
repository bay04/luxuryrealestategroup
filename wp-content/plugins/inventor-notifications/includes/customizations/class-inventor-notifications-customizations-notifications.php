<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Customizations_Notifications
 *
 * @class Inventor_Notifications_Customizations_Notifications
 * @package Inventor_Notifications/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Notifications_Customizations_Notifications {
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
        $wp_customize->add_section( 'inventor_notifications', array(
            'title'     => __( 'Inventor Notifications', 'inventor-notifications' ),
            'priority'  => 1,
        ) );

        // Package expiration warning
        $wp_customize->add_setting( 'inventor_notifications_package_will_expire', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_notifications_package_will_expire', array(
            'label'         => __( 'Package expiration warning', 'inventor-notifications' ),
            'type'          => 'checkbox',
            'section'       => 'inventor_notifications',
            'settings'      => 'inventor_notifications_package_will_expire',
        ) );

        // Package expiration warning threshold
        $wp_customize->add_setting( 'inventor_notifications_package_expiration_warning_threshold', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'       => 7,
        ) );

        $wp_customize->add_control( 'inventor_notifications_package_expiration_warning_threshold', array(
            'label'         => __( 'Package expiration warning threshold', 'inventor-notifications' ),
            'type'          => 'select',
            'section'       => 'inventor_notifications',
            'settings'      => 'inventor_notifications_package_expiration_warning_threshold',
            'choices'       => array(
                3         => __('3 days', 'inventor_notifications'),
                7         => __('7 days', 'inventor_notifications'),
                14        => __('14 days', 'inventor_notifications'),
                30        => __('30 days', 'inventor_notifications'),
            ),
            'description'   => __( 'Set threshold in days.', 'inventor_notifications' ),
        ) );

        // Package expiration announcement
        $wp_customize->add_setting( 'inventor_notifications_package_expired', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_notifications_package_expired', array(
            'label'         => __( 'Package expiration announcement', 'inventor-notifications' ),
            'type'          => 'checkbox',
            'section'       => 'inventor_notifications',
            'settings'      => 'inventor_notifications_package_expired',
            'description'   => __( 'One day before package expiration.', 'inventor_notifications' ),
        ) );

        // Package purchased - for admin
        $wp_customize->add_setting( 'inventor_notifications_package_purchased_admin', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_notifications_package_purchased_admin', array(
            'label'         => __( 'Package purchased', 'inventor-notifications' ),
            'type'          => 'checkbox',
            'section'       => 'inventor_notifications',
            'settings'      => 'inventor_notifications_package_purchased_admin',
            'description'   => __( 'For admin', 'inventor_notifications' ),
        ) );

        // Pending submission waiting for review - for admin
        $wp_customize->add_setting( 'inventor_notifications_submission_pending_admin', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_notifications_submission_pending_admin', array(
            'label'         => __( 'Submission waiting for review', 'inventor-notifications' ),
            'type'          => 'checkbox',
            'section'       => 'inventor_notifications',
            'settings'      => 'inventor_notifications_submission_pending_admin',
            'description'   => __( 'For admin', 'inventor_notifications' ),
        ) );

        // Submission waiting for review - for user
        $wp_customize->add_setting( 'inventor_notifications_submission_pending_user', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_notifications_submission_pending_user', array(
            'label'         => __( 'Submission waiting for review', 'inventor-notifications' ),
            'type'          => 'checkbox',
            'section'       => 'inventor_notifications',
            'settings'      => 'inventor_notifications_submission_pending_user',
            'description'   => __( 'For user', 'inventor_notifications' ),
        ) );

        // Submission published - for admin
        $wp_customize->add_setting( 'inventor_notifications_submission_published_admin', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_notifications_submission_published_admin', array(
            'label'         => __( 'Submission published', 'inventor-notifications' ),
            'type'          => 'checkbox',
            'section'       => 'inventor_notifications',
            'settings'      => 'inventor_notifications_submission_published_admin',
            'description'   => __( 'For admin', 'inventor_notifications' ),
        ) );

        // Submission published - for user
        $wp_customize->add_setting( 'inventor_notifications_submission_published_user', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_notifications_submission_published_user', array(
            'label'         => __( 'Submission published', 'inventor-notifications' ),
            'type'          => 'checkbox',
            'section'       => 'inventor_notifications',
            'settings'      => 'inventor_notifications_submission_published_user',
            'description'   => __( 'For user', 'inventor_notifications' ),
        ) );
    }
}

Inventor_Notifications_Customizations_Notifications::init();
