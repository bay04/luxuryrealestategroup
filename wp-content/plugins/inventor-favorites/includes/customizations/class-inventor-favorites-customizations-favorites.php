<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Customizations_Favorites
 *
 * @class Inventor_Favorites_Customizations_Favorites
 * @package Inventor_Favorites/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Customizations_Favorites {
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

        // Favorites
        $wp_customize->add_setting( 'inventor_favorites_page', array(
            'default' => null,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_favorites_page', array(
            'type' => 'select',
            'label' => __( 'Favorite listings', 'inventor-favorites' ),
            'section' => 'inventor_pages',
            'settings' => 'inventor_favorites_page',
            'choices' => $pages,
        ) );

        // Create collection page
        $wp_customize->add_setting( 'inventor_favorites_create_collection_page', array(
            'default' => null,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_favorites_create_collection_page', array(
            'type' => 'select',
            'label' => __( 'Create collection', 'inventor-favorites' ),
            'section' => 'inventor_pages',
            'settings' => 'inventor_favorites_create_collection_page',
            'choices' => $pages,
        ) );
    }
}

Inventor_Favorites_Customizations_Favorites::init();
