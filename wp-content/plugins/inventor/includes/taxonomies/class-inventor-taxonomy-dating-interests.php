<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Dating_Interests
 *
 * @class Inventor_Taxonomy_Dating_Interests
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Dating_Interests {
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
            'name'              => __( 'Dating Interests', 'inventor' ),
            'singular_name'     => __( 'Dating Status', 'inventor' ),
            'search_items'      => __( 'Search Dating Status', 'inventor' ),
            'all_items'         => __( 'All Dating Interests', 'inventor' ),
            'parent_item'       => __( 'Parent Dating Status', 'inventor' ),
            'parent_item_colon' => __( 'Parent Dating Status:', 'inventor' ),
            'edit_item'         => __( 'Edit Dating Status', 'inventor' ),
            'update_item'       => __( 'Update Dating Status', 'inventor' ),
            'add_new_item'      => __( 'Add New Dating Status', 'inventor' ),
            'new_item_name'     => __( 'New Dating Status', 'inventor' ),
            'menu_name'         => __( 'Dating Interests', 'inventor' ),
            'not_found'         => __( 'No dating interests found.', 'inventor' ),
        );

        register_taxonomy( 'dating_interests', array( 'dating' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'dating-interest',
            'rewrite'           => array( 'slug' => _x( 'dating-interest', 'URL slug', 'inventor' ), 'hierarchical' => true ),
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
     * Set active menu for taxonomy dating interest
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'dating_interests' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Dating_Interests::init();
