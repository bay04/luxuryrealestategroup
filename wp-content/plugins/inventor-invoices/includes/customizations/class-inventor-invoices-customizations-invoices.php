<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Customizations_Invoices
 *
 * @class Inventor_Invoices_Customizations_Invoices
 * @package Inventor_Invoices/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Invoices_Customizations_Invoices {
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
        $wp_customize->add_section( 'inventor_invoices', array(
            'title'     => __( 'Inventor Invoices', 'inventor-invoices' ),
            'priority'  => 1,
        ) );

        // Invoices page
        $pages = Inventor_Utilities::get_pages();

        $wp_customize->add_setting('inventor_invoices_page', array(
            'default' => null,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('inventor_invoices_page', array(
            'type' => 'select',
            'label' => __('Invoices', 'inventor-invoices'),
            'section' => 'inventor_pages',
            'settings' => 'inventor_invoices_page',
            'choices' => $pages,
        ));
        
        // Payment term
        $wp_customize->add_setting( 'inventor_invoices_payment_term', array(
            'default'           => 15,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_invoices_payment_term', array(
            'label'         => __( 'Payment term', 'inventor-invoices' ),
            'section'       => 'inventor_invoices',
            'settings'      => 'inventor_invoices_payment_term',
            'description'   => __( 'In days', 'inventor-invoices' )
        ) );

        // Tax rate
        $wp_customize->add_setting( 'inventor_invoices_tax_rate', array(
            'default'           => 0,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_invoices_tax_rate', array(
            'label'         => __( 'Tax rate', 'inventor-invoices' ),
            'section'       => 'inventor_invoices',
            'settings'      => 'inventor_invoices_tax_rate',
            'description'   => __( 'In %', 'inventor-invoices' )
        ) );

        // Billing name
        $wp_customize->add_setting( 'inventor_invoices_billing_name', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_invoices_billing_name', array(
            'label'         => __( 'Billing name', 'inventor-invoices' ),
            'section'       => 'inventor_invoices',
            'settings'      => 'inventor_invoices_billing_name',
        ) );

        // Billing registration number
        $wp_customize->add_setting( 'inventor_invoices_billing_registration_number', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_invoices_billing_registration_number', array(
            'label'         => __( 'Reg. No.', 'inventor-invoices' ),
            'section'       => 'inventor_invoices',
            'settings'      => 'inventor_invoices_billing_registration_number',
        ) );

        // Billing VAT number
        $wp_customize->add_setting( 'inventor_invoices_billing_vat_number', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_invoices_billing_vat_number', array(
            'label'         => __( 'VAT No.', 'inventor-invoices' ),
            'section'       => 'inventor_invoices',
            'settings'      => 'inventor_invoices_billing_vat_number',
        ) );

        // Billing details
        $wp_customize->add_setting( 'inventor_invoices_billing_details', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => array( 'Inventor_Utilities', 'sanitize_textarea' ),
        ) );

        $wp_customize->add_control( 'inventor_invoices_billing_details', array(
            'label'         => __( 'Billing details', 'inventor-invoices' ),
            'section'       => 'inventor_invoices',
            'settings'      => 'inventor_invoices_billing_details',
            'type'          => 'textarea'
        ) );
    }
}

Inventor_Invoices_Customizations_Invoices::init();
