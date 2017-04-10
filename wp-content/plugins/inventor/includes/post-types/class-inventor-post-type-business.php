<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Post_Type_Business
 *
 * @class Inventor_Post_Type_Business
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Business {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
        add_filter( 'inventor_claims_allowed_listing_post_types', array( __CLASS__, 'allowed_claiming' ) );
    }

    /**
     * Defines if post type can be claimed
     *
     * @access public
     * @param array $post_types
     * @return array
     */
    public static function allowed_claiming( $post_types ) {
        $post_types[] = 'business';
        return $post_types;
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Businesses', 'inventor' ),
            'singular_name'         => __( 'Business', 'inventor' ),
            'add_new'               => __( 'Add New Business', 'inventor' ),
            'add_new_item'          => __( 'Add New Business', 'inventor' ),
            'edit_item'             => __( 'Edit Business', 'inventor' ),
            'new_item'              => __( 'New Business', 'inventor' ),
            'all_items'             => __( 'Businesses', 'inventor' ),
            'view_item'             => __( 'View Business', 'inventor' ),
            'search_items'          => __( 'Search Business', 'inventor' ),
            'not_found'             => __( 'No Businesses found', 'inventor' ),
            'not_found_in_trash'    => __( 'No Businesses Found in Trash', 'inventor' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Businesses', 'inventor' ),
            'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-condominium', 'business' )
        );

        register_post_type( 'business',
            array(
                'labels'            => $labels,
                'show_in_menu'	    => 'listings',
                'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
                'has_archive'       => true,
                'rewrite'           => array( 'slug' => _x( 'businesses', 'URL slug', 'inventor' ) ),
                'public'            => true,
                'show_ui'           => true,
                'show_in_rest'      => true,
                'categories'        => array(),
            )
        );
    }
    /**
     * Defines custom fields
     *
     * @access public
     * @return array
     */
    public static function fields() {
        Inventor_Post_Types::add_metabox( 'business', array( 'general', 'banner', 'gallery', 'video', 'opening_hours', 'contact', 'social', 'flags', 'location', 'faq', 'branding', 'listing_category' ) );
    }
}

Inventor_Post_Type_Business::init();