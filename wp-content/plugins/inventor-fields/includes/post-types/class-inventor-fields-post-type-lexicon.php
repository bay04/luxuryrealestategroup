<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Fields_Post_Type_Lexicon
 *
 * @class Inventor_Fields_Post_Type_Lexicon
 * @package Inventor_Fields/Classes/Lexicon
 * @author Pragmatic Mates
 */
class Inventor_Fields_Post_Type_Lexicon {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'init', array( __CLASS__, 'register_lexicons' ), 11 );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ), 11 );
        add_action( 'parent_file', array( __CLASS__, 'menu' ) );

        add_filter( 'manage_edit-lexicon_columns', array( __CLASS__, 'custom_columns' ) );
    }

    /**
     * Custom admin columns
     *
     * @access public
     * @return array
     */
    public static function custom_columns( $columns ) {
        unset( $columns['date'] );
        return $columns;
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Lexicons', 'inventor-fields' ),
            'singular_name'         => __( 'Lexicon', 'inventor-fields' ),
            'add_new_item'          => __( 'Add New Lexicon', 'inventor-fields' ),
            'add_new'               => __( 'Add New Lexicon', 'inventor-fields' ),
            'edit_item'             => __( 'Edit Lexicon', 'inventor-fields' ),
            'new_item'              => __( 'New Lexicon', 'inventor-fields' ),
            'all_items'             => __( 'Lexicons', 'inventor-fields' ),
            'view_item'             => __( 'View Lexicon', 'inventor-fields' ),
            'search_items'          => __( 'Search Lexicon', 'inventor-fields' ),
            'not_found'             => __( 'No Lexicons found', 'inventor-fields' ),
            'not_found_in_trash'    => __( 'No Lexicons found in Trash', 'inventor-fields' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Lexicons', 'inventor-fields' ),
        );

        register_post_type( 'lexicon',
            array(
                'labels'                => $labels,
                'supports'              => array( 'title' ),
                'public'                => false,
                'exclude_from_search'   => true,
                'publicly_queryable'    => false,
                'show_in_nav_menus'     => false,
                'show_ui'               => true,
                'show_in_menu'          => class_exists( 'Inventor_Admin_Menu' ) ? 'inventor' : true,
            )
        );
    }

    /**
     * Defines custom fields
     *
     * @access public
     */
    public static function fields() {
        // Settings
        $settings = new_cmb2_box( array(
            'id'            => INVENTOR_FIELDS_LEXICON_PREFIX  . 'settings',
            'title'         => __( 'Settings', 'inventor-fields' ),
            'object_types'  => array( 'lexicon' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        // Singular name
        $settings->add_field( array(
            'name'          => __( 'Singular name', 'inventor-fields' ),
            'description'   => __( 'Name for one object of this post type (Set title to plural name).', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_LEXICON_PREFIX  . 'singular_name',
            'type'          => 'text',
            'attributes'    => array(
                'required'      => 'required'
            )
        ) );

        // Identifier
        $settings->add_field( array(
            'name'          => __( 'Identifier', 'inventor-fields' ),
            'description'   => __( 'Unique identifier (Slug with lowercase characters).', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_LEXICON_PREFIX  . 'identifier',
            'type'          => 'text',
            'column'        => true,
            'attributes'    => array(
                'required'      => 'required',
                'pattern'       => '[a-z0-9]+(?:-[a-z0-9]+)*',
                'maxlength'     => 20
            )
        ) );

        // URL Slug
        $settings->add_field( array(
            'name'          => __( 'URL Slug', 'inventor-fields' ),
            'description'   => __( "Don't forget to resave permalinks in Settings > Permalinks.", 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_LEXICON_PREFIX  . 'slug',
            'type'          => 'text',
            'attributes'    => array(
                'required'      => 'required'
            )
        ) );

        // Listing types
        $settings->add_field( array(
            'name'          => __( 'Listing types', 'inventor-fields' ),
            'description'   => __( 'Specify for which listing types will be this lexicon available for.', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_LEXICON_PREFIX  . 'listing_types',
            'type'          => 'multicheck',
            'options'       => Inventor_Post_Types::get_listing_post_types( false, true ),
            'column'        => true
        ) );
    }

    /**
     * Registers custom lexicons
     *
     * @access public
     */
    public static function register_lexicons() {
        $query = new WP_Query( array(
            'post_type'         => 'lexicon',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
        ) );

        foreach ( $query->posts as $lexicon ) {
            $plural_name = get_the_title( $lexicon->ID );
            $identifier = get_post_meta( $lexicon->ID, INVENTOR_FIELDS_LEXICON_PREFIX  . 'identifier', true );
            $slug = get_post_meta( $lexicon->ID, INVENTOR_FIELDS_LEXICON_PREFIX  . 'slug', true );
            $singular_name = get_post_meta( $lexicon->ID, INVENTOR_FIELDS_LEXICON_PREFIX  . 'singular_name', true );
            $listing_types = get_post_meta( $lexicon->ID, INVENTOR_FIELDS_LEXICON_PREFIX  . 'listing_types', true );

            $labels = array(
                'name'                  => $plural_name,
                'singular_name'         => $singular_name,
                'add_new_item'          => sprintf( __( 'Add New %s', 'inventor-fields' ), $singular_name ),
                'add_new'               => sprintf( __( 'Add New %s', 'inventor-fields' ), $singular_name ),
                'edit_item'             => sprintf( __( 'Edit %s', 'inventor-fields' ), $singular_name ),
                'new_item'              => sprintf( __( 'New %s', 'inventor-fields' ), $singular_name ),
                'all_items'             => $plural_name,
                'view_item'             => sprintf( __( 'View %s', 'inventor-fields' ), $singular_name ),
                'search_items'          => sprintf( __( 'Search %s', 'inventor-fields' ), $plural_name ),
                'not_found'             => sprintf( __( 'No %s found', 'inventor-fields' ), $plural_name ),
                'not_found_in_trash'    => sprintf( __( 'No %s found in Trash', 'inventor-fields' ), $plural_name ),
                'parent_item_colon'     => '',
                'menu_name'             => $plural_name,
            );

            register_taxonomy( $identifier, $listing_types, array(
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => false, // note: Can't be set to $slug, because filter fields can contain multivalues which can't be properly encoded by WordPress
                'rewrite'           => array( 'slug' => $slug, 'hierarchical' => true ),
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'	    => 'lexicon',
                'show_in_nav_menus' => true,
                'show_in_rest'      => true,
                'meta_box_cb'       => false,
                'show_admin_column' => true,
            ) );
        }
    }

    /**
     * Set active menu for taxonomy location
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        $query = new WP_Query( array(
            'post_type'         => 'lexicon',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
        ) );

        $lexicons = array();
        foreach ( $query->posts as $lexicon ) {
            $identifier = get_post_meta( $lexicon->ID, INVENTOR_FIELDS_LEXICON_PREFIX  . 'identifier', true );
            $lexicons[] = $identifier;
        }

        if ( in_array( $taxonomy, $lexicons ) ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Fields_Post_Type_Lexicon::init();