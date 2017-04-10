<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Submission_Customizations_Submission
 *
 * @class Inventor_Submission_Customizations_Submission
 * @package Inventor/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Submission_Customizations_Submission {
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

        $wp_customize->add_section( 'inventor_submission', array(
            'title'     => __( 'Inventor Submission', 'inventor-submission' ),
            'priority'  => 1,
        ) );

        // Type
        $wp_customize->add_setting( 'inventor_submission_type', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_type', array(
            'type'              => 'select',
            'label'             => __( 'Type', 'inventor-submission' ),
            'description'       => __( 'Defines what determines number of user listings.', 'inventor-submission' ),
            'section'           => 'inventor_submission',
            'settings'          => 'inventor_submission_type',
            'choices'           => apply_filters( 'inventor_submission_types', array(
                'free'  			=> __( 'Free for all', 'inventor-submission' ),
                'pay-per-post'      => __( 'Pay per post', 'inventor-submission' ),
            ) )
        ) );

        // Review before submission
        $wp_customize->add_setting( 'inventor_submission_review_before', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_review_before', array(
            'type'      => 'checkbox',
            'label'     => __( 'Review Before Submission', 'inventor-submission' ),
            'section'   => 'inventor_submission',
            'settings'  => 'inventor_submission_review_before',
        ) );

        // Show all metabox fields in single step
        $wp_customize->add_setting( 'inventor_submission_single_step', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_single_step', array(
            'type'      	=> 'checkbox',
            'label'     	=> __( 'Single step', 'inventor-submission' ),
            'description'	=> __( 'Merge all listing metaboxes into single submission step', 'inventor-submission' ),
            'section'   	=> 'inventor_submission',
            'settings'  	=> 'inventor_submission_single_step',
        ) );

        // Pay per post - post price
        $wp_customize->add_setting( 'inventor_submission_publish_price', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_publish_price', array(
            'label'         => __( 'Publish price', 'inventor-submission' ),
            'section'       => 'inventor_submission',
            'settings'      => 'inventor_submission_publish_price',
            'description'   => __( 'For "pay per post" submission type', 'inventor-submission' ),
            'type'          => 'number'
        ) );

        // Featured price
        $wp_customize->add_setting( 'inventor_submission_featured_price', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_featured_price', array(
            'label'         => __( 'Featured price', 'inventor-submission' ),
            'section'       => 'inventor_submission',
            'settings'      => 'inventor_submission_featured_price',
            'type'          => 'number'
        ) );

        // List Page
        $wp_customize->add_setting( 'inventor_submission_list_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_list_page', array(
            'type'          => 'select',
            'label'         => __( 'User listings', 'inventor-submission' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_submission_list_page',
            'choices'       => $pages,
        ) );

        // Create Page
        $wp_customize->add_setting( 'inventor_submission_create_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_create_page', array(
            'type'          => 'select',
            'label'         => __( 'Add listing', 'inventor-submission' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_submission_create_page',
            'choices'       => $pages,
        ) );

        // Edit Page
        $wp_customize->add_setting( 'inventor_submission_edit_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_edit_page', array(
            'type'          => 'select',
            'label'         => __( 'Edit listing', 'inventor-submission' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_submission_edit_page',
            'choices'       => $pages,
        ) );

        // Remove Page
        $wp_customize->add_setting( 'inventor_submission_remove_page', array(
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_submission_remove_page', array(
            'type'          => 'select',
            'label'         => __( 'Remove listing', 'inventor-submission' ),
            'section'       => 'inventor_pages',
            'settings'      => 'inventor_submission_remove_page',
            'choices'       => $pages,
        ) );
    }
}

Inventor_Submission_Customizations_Submission::init();
