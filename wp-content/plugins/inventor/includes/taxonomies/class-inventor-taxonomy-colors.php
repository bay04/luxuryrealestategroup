<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Colors
 *
 * @class Inventor_Taxonomy_Colors
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Colors {
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
            'name'              => __( 'Colors', 'inventor' ),
            'singular_name'     => __( 'Color', 'inventor' ),
            'search_items'      => __( 'Search Color', 'inventor' ),
            'all_items'         => __( 'All Colors', 'inventor' ),
            'parent_item'       => __( 'Parent Color', 'inventor' ),
            'parent_item_colon' => __( 'Parent Color:', 'inventor' ),
            'edit_item'         => __( 'Edit Color', 'inventor' ),
            'update_item'       => __( 'Update Color', 'inventor' ),
            'add_new_item'      => __( 'Add New Color', 'inventor' ),
            'new_item_name'     => __( 'New Color', 'inventor' ),
            'menu_name'         => __( 'Colors', 'inventor' ),
            'not_found'         => __( 'No colors found.', 'inventor' ),
        );

        register_taxonomy( 'colors', Inventor_Post_Types::get_listing_post_types(), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'color',
            'rewrite'           => array( 'slug' => _x( 'color', 'URL slug', 'inventor' ), 'hierarchical' => true ),
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'	    => 'lexicon',
            'show_in_nav_menus' => true,
            'show_in_rest'      => true,
            'meta_box_cb'       => false,
            'show_admin_column' => false,
        ) );
    }

    /**
     * Set active menu for taxonomy color
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'colors' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Colors::init();
