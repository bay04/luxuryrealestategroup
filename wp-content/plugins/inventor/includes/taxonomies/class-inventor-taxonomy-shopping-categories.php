<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Shopping_Categories
 *
 * @class Inventor_Taxonomy_Shopping_Categories
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Shopping_Categories {
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
            'name'              => __( 'Shopping Categories', 'inventor' ),
            'singular_name'     => __( 'Shopping Category', 'inventor' ),
            'search_items'      => __( 'Search Shopping Category', 'inventor' ),
            'all_items'         => __( 'All Shopping Categories', 'inventor' ),
            'parent_item'       => __( 'Parent Shopping Category', 'inventor' ),
            'parent_item_colon' => __( 'Parent Shopping Category:', 'inventor' ),
            'edit_item'         => __( 'Edit Shopping Category', 'inventor' ),
            'update_item'       => __( 'Update Shopping Category', 'inventor' ),
            'add_new_item'      => __( 'Add New Shopping Category', 'inventor' ),
            'new_item_name'     => __( 'New Shopping Category', 'inventor' ),
            'menu_name'         => __( 'Shopping Categories', 'inventor' ),
            'not_found'         => __( 'No shopping categories found.', 'inventor' ),
        );

        register_taxonomy( 'shopping_categories', array( 'shopping' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'shopping-category',
            'rewrite'           => array( 'slug' => _x( 'shopping-category', 'URL slug', 'inventor' ), 'hierarchical' => true ),
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
     * Set active menu for taxonomy shopping category
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'shopping_categories' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Shopping_Categories::init();
