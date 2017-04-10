<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Meals_And_Drinks_Sections
 *
 * @class Inventor_Taxonomy_Meals_And_Drinks_Sections
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Meals_And_Drinks_Sections {
    /**
     * Initialize taxonomy
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ), 12 );
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
            'name'              => __( 'Meals and Drinks Sections', 'inventor' ),
            'singular_name'     => __( 'Meals and Drinks Section', 'inventor' ),
            'search_items'      => __( 'Search Meals and Drinks Section', 'inventor' ),
            'all_items'         => __( 'All Meals and Drinks Sections', 'inventor' ),
            'parent_item'       => __( 'Parent Meals and Drinks Section', 'inventor' ),
            'parent_item_colon' => __( 'Parent Meals and Drinks Section:', 'inventor' ),
            'edit_item'         => __( 'Edit Meals and Drinks Section', 'inventor' ),
            'update_itm'        => __( 'Update Meals and Drinks Section', 'inventor' ),
            'add_new_item'      => __( 'Add New Meals and Drinks Section', 'inventor' ),
            'new_item_name'     => __( 'New Meals and Drinks Section', 'inventor' ),
            'menu_name'         => __( 'Meals and Drinks Sections', 'inventor' ),
            'not_found'         => __( 'No Meals and Drinks Sections found.', 'inventor' ),
        );

        register_taxonomy( 'meals_and_drinks_sections', array( 'food' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'meals-and-drinks-section',
            'rewrite'           => array( 'slug' => _x( 'meals-and-drinks-section', 'URL slug', 'inventor' ), 'hierarchical' => true ),
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'	    => 'lexicon',
            'show_in_nav_menus' => true,
            'show_in_rest'      => true,
            'meta_box_cb'       => false,
            'show_admin_column' => true,
        ) );
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

        if ( 'meals_and_drinks_sections' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Meals_And_Drinks_Sections::init();
