<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Post_Type_Education
 *
 * @class Inventor_Post_Type_Education
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Education {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
        add_filter( 'inventor_shop_allowed_listing_post_types', array( __CLASS__, 'allowed_purchasing' ) );
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
        $post_types[] = 'education';
        return $post_types;
    }

    /**
     * Defines if post type can be purchased
     *
     * @access public
     * @param array $post_types
     * @return array
     */
    public static function allowed_purchasing( $post_types ) {
        $post_types[] = 'education';
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
            'name'                  => __( 'Educations', 'inventor' ),
            'singular_name'         => __( 'Education', 'inventor' ),
            'add_new'               => __( 'Add New Education', 'inventor' ),
            'add_new_item'          => __( 'Add New Education', 'inventor' ),
            'edit_item'             => __( 'Edit Education', 'inventor' ),
            'new_item'              => __( 'New Education', 'inventor' ),
            'all_items'             => __( 'Educations', 'inventor' ),
            'view_item'             => __( 'View Education', 'inventor' ),
            'search_items'          => __( 'Search Education', 'inventor' ),
            'not_found'             => __( 'No Educations found', 'inventor' ),
            'not_found_in_trash'    => __( 'No Educations Found in Trash', 'inventor' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Educations', 'inventor' ),
            'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-university', 'education' )
        );

        register_post_type( 'education',
            array(
                'labels'            => $labels,
                'show_in_menu'	    => 'listings',
                'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
                'has_archive'       => true,
                'rewrite'           => array( 'slug' => _x( 'educations', 'URL slug', 'inventor' ) ),
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
        Inventor_Post_Types::add_metabox( 'education', array( 'general' ) );

        $cmb = new_cmb2_box( array(
            'id'            => INVENTOR_LISTING_PREFIX . 'education_details',
            'title'         => __( 'Details', 'inventor' ),
            'object_types'  => array( 'education' ),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_in_rest'  => true,
        ) );

        $cmb->add_field( array(
            'name'              => __( 'Education subject', 'inventor' ),
            'id'                => INVENTOR_LISTING_PREFIX  . 'education_subject',
            'type'              => 'taxonomy_select',
            'taxonomy'          => 'education_subjects',
        ) );

        $cmb->add_field( array(
            'name'              => __( 'Education level', 'inventor' ),
            'id'                => INVENTOR_LISTING_PREFIX  . 'education_level',
            'type'              => 'taxonomy_radio_inline',
            'taxonomy'          => 'education_levels',
        ) );

        $cmb->add_field( array(
            'name'              => __( 'Lector', 'inventor' ),
            'id'                => INVENTOR_LISTING_PREFIX  . 'education_lector',
            'type'              => 'text',
        ) );

        Inventor_Post_Types::add_metabox( 'education', array( 'date_and_time_interval', 'gallery', 'banner', 'video', 'contact', 'social', 'price', 'flags', 'location', 'listing_category' ) );
    }
}

Inventor_Post_Type_Education::init();