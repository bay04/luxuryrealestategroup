<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Taxonomy_Car_Transmissions
 *
 * @class Inventor_Taxonomy_Car_Transmissions
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomy_Car_Transmissions {
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
            'name'              => __( 'Car Transmissions', 'inventor' ),
            'singular_name'     => __( 'Car Transmission', 'inventor' ),
            'search_items'      => __( 'Search Car Transmission', 'inventor' ),
            'all_items'         => __( 'All Car Transmissions', 'inventor' ),
            'parent_item'       => __( 'Parent Car Transmission', 'inventor' ),
            'parent_item_colon' => __( 'Parent Car Transmission:', 'inventor' ),
            'edit_item'         => __( 'Edit Car Transmission', 'inventor' ),
            'update_item'       => __( 'Update Car Transmission', 'inventor' ),
            'add_new_item'      => __( 'Add New Car Transmission', 'inventor' ),
            'new_item_name'     => __( 'New Car Transmission', 'inventor' ),
            'menu_name'         => __( 'Car Transmissions', 'inventor' ),
            'not_found'         => __( 'No car transmissions found.', 'inventor' ),
        );

        register_taxonomy( 'car_transmissions', array( 'car' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'car-transmission',
            'rewrite'           => array( 'slug' => _x( 'car-transmission', 'URL slug', 'inventor' ), 'hierarchical' => true ),
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
     * Set active menu for taxonomy car transmission
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'car_transmissions' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Taxonomy_Car_Transmissions::init();
