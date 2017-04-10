<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Properties_Taxonomy_Property_Amenities
 *
 * @class Inventor_Properties_Taxonomy_Property_Amenities
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Properties_Taxonomy_Property_Amenities {
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
            'name'              => __( 'Property Amenities', 'inventor-properties' ),
            'singular_name'     => __( 'Property Amenity', 'inventor-properties' ),
            'search_items'      => __( 'Search Property Amenity', 'inventor-properties' ),
            'all_items'         => __( 'All Property Amenities', 'inventor-properties' ),
            'parent_item'       => __( 'Parent Property Amenity', 'inventor-properties' ),
            'parent_item_colon' => __( 'Parent Property Amenity:', 'inventor-properties' ),
            'edit_item'         => __( 'Edit Property Amenity', 'inventor-properties' ),
            'update_item'       => __( 'Update Property Amenity', 'inventor-properties' ),
            'add_new_item'      => __( 'Add New Property Amenity', 'inventor-properties' ),
            'new_item_name'     => __( 'New Property Amenity', 'inventor-properties' ),
            'menu_name'         => __( 'Property Amenities', 'inventor-properties' ),
            'not_found'         => __( 'No property amenities found.', 'inventor-properties' ),
        );

        register_taxonomy( 'property_amenities', array( 'property' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'property-amenity',
            'rewrite'           => array( 'slug' => _x( 'property-amenity', 'URL slug', 'inventor-properties' ), 'hierarchical' => true ),
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'      => 'lexicon',
            'show_in_nav_menus' => true,
            'show_in_rest'      => true,
            'meta_box_cb'       => false,
            'show_admin_column' => false,
        ) );
    }

    /**
     * Set active menu for taxonomy amenity
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'property_amenities' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Properties_Taxonomy_Property_Amenities::init();
