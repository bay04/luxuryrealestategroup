<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Properties_Taxonomy_Property_Types
 *
 * @class Inventor_Properties_Taxonomy_Property_Types
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Properties_Taxonomy_Property_Types {
    /**
     * Initialize taxonomy
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'parent_file', array( __CLASS__, 'menu' ) );
    }

    /**
     * Widget definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'              => __( 'Property Types', 'inventor-properties' ),
            'singular_name'     => __( 'Property Type', 'inventor-properties' ),
            'search_items'      => __( 'Search Property Type', 'inventor-properties' ),
            'all_items'         => __( 'All Property Types', 'inventor-properties' ),
            'parent_item'       => __( 'Parent Property Type', 'inventor-properties' ),
            'parent_item_colon' => __( 'Parent Property Type:', 'inventor-properties' ),
            'edit_item'         => __( 'Edit Property Type', 'inventor-properties' ),
            'update_item'       => __( 'Update Property Type', 'inventor-properties' ),
            'add_new_item'      => __( 'Add New Property Type', 'inventor-properties' ),
            'new_item_name'     => __( 'New Property Type', 'inventor-properties' ),
            'menu_name'         => __( 'Property Types', 'inventor-properties' ),
            'not_found'         => __( 'No property types found.', 'inventor-properties' ),
        );

        register_taxonomy( 'property_types', array( 'property' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'property-type',
            'rewrite'           => array( 'slug' => _x( 'property-type', 'URL slug', 'inventor-properties' ), 'hierarchical' => true ),
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'      => 'lexicon',
            'show_in_nav_menus' => true,
            'show_in_rest'      => true,
            'meta_box_cb'       => false,
            'show_admin_column' => true,
        ) );
    }

    /**
     * Set active menu for taxonomy property type
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'property_types' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Properties_Taxonomy_Property_Types::init();
