<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Education_Subjects
 *
 * @class Inventor_Taxonomy_Education_Subjects
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Education_Subjects {
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
            'name'              => __( 'Education Subjects', 'inventor' ),
            'singular_name'     => __( 'Education Subject', 'inventor' ),
            'search_items'      => __( 'Search Education Subject', 'inventor' ),
            'all_items'         => __( 'All Education Subjects', 'inventor' ),
            'parent_item'       => __( 'Parent Education Subject', 'inventor' ),
            'parent_item_colon' => __( 'Parent Education Subject:', 'inventor' ),
            'edit_item'         => __( 'Edit Education Subject', 'inventor' ),
            'update_item'       => __( 'Update Education Subject', 'inventor' ),
            'add_new_item'      => __( 'Add New Education Subject', 'inventor' ),
            'new_item_name'     => __( 'New Education Subject', 'inventor' ),
            'menu_name'         => __( 'Education Subjects', 'inventor' ),
            'not_found'         => __( 'No education subjects found.', 'inventor' ),
        );

        register_taxonomy( 'education_subjects', array( 'education' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'education-subject',
            'rewrite'           => array( 'slug' => _x( 'education-subject', 'URL slug', 'inventor' ), 'hierarchical' => true ),
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
     * Set active menu for taxonomy education subject
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'education_subjects' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Education_Subjects::init();
