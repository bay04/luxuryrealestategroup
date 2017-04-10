<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Food_Kinds
 *
 * @class Inventor_Taxonomy_Food_Kinds
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Food_Kinds {
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
            'name'              => __( 'Food Kinds', 'inventor' ),
            'singular_name'     => __( 'Food Kind', 'inventor' ),
            'search_items'      => __( 'Search Food Kind', 'inventor' ),
            'all_items'         => __( 'All Food Kinds', 'inventor' ),
            'parent_item'       => __( 'Parent Food Kind', 'inventor' ),
            'parent_item_colon' => __( 'Parent Food Kind:', 'inventor' ),
            'edit_item'         => __( 'Edit Food Kind', 'inventor' ),
            'update_item'       => __( 'Update Food Kind', 'inventor' ),
            'add_new_item'      => __( 'Add New Food Kind', 'inventor' ),
            'new_item_name'     => __( 'New Food Kind', 'inventor' ),
            'menu_name'         => __( 'Food Kinds', 'inventor' ),
            'not_found'         => __( 'No food kinds found.', 'inventor' ),
        );

        register_taxonomy( 'food_kinds', array( 'food' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'food-kind',
            'rewrite'           => array( 'slug' => _x( 'food-kind', 'URL slug', 'inventor' ), 'hierarchical' => true ),
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
     * Set active menu for taxonomy food kind
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'food_kinds' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Food_Kinds::init();
