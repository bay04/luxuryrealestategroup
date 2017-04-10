<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Hotel_Classes
 *
 * @class Inventor_Taxonomy_Hotel_Classes
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Hotel_Classes {
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
            'name'              => __( 'Hotel Classes', 'inventor' ),
            'singular_name'     => __( 'Hotel Class', 'inventor' ),
            'search_items'      => __( 'Search Hotel Class', 'inventor' ),
            'all_items'         => __( 'All Hotel Classes', 'inventor' ),
            'parent_item'       => __( 'Parent Hotel Class', 'inventor' ),
            'parent_item_colon' => __( 'Parent Hotel Class:', 'inventor' ),
            'edit_item'         => __( 'Edit Hotel Class', 'inventor' ),
            'update_item'       => __( 'Update Hotel Class', 'inventor' ),
            'add_new_item'      => __( 'Add New Hotel Class', 'inventor' ),
            'new_item_name'     => __( 'New Hotel Class', 'inventor' ),
            'menu_name'         => __( 'Hotel Classes', 'inventor' ),
            'not_found'         => __( 'No hotel classes found.', 'inventor' ),
        );

        register_taxonomy( 'hotel_classes', array( 'hotel' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'hotel-class',
            'rewrite'           => array( 'slug' => _x( 'hotel-class', 'URL slug', 'inventor' ), 'hierarchical' => true ),
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
     * Set active menu for taxonomy hotel class
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'hotel_classes' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Hotel_Classes::init();
