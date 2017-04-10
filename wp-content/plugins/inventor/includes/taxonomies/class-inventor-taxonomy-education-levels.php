<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Education_Levels
 *
 * @class Inventor_Taxonomy_Education_Levels
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Education_Levels {
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
            'name'              => __( 'Education Levels', 'inventor' ),
            'singular_name'     => __( 'Education Level', 'inventor' ),
            'search_items'      => __( 'Search Education Level', 'inventor' ),
            'all_items'         => __( 'All Education Levels', 'inventor' ),
            'parent_item'       => __( 'Parent Education Level', 'inventor' ),
            'parent_item_colon' => __( 'Parent Education Level:', 'inventor' ),
            'edit_item'         => __( 'Edit Education Level', 'inventor' ),
            'update_item'       => __( 'Update Education Level', 'inventor' ),
            'add_new_item'      => __( 'Add New Education Level', 'inventor' ),
            'new_item_name'     => __( 'New Education Level', 'inventor' ),
            'menu_name'         => __( 'Education Levels', 'inventor' ),
            'not_found'         => __( 'No education levels found.', 'inventor' ),
        );

        register_taxonomy( 'education_levels', array( 'education' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'education-level',
            'rewrite'           => array( 'slug' => _x( 'education-level', 'URL slug', 'inventor' ), 'hierarchical' => true ),
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
     * Set active menu for taxonomy education level
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'education_levels' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Education_Levels::init();
