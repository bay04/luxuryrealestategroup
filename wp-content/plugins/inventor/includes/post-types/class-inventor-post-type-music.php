<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Post_Type_Music
 *
 * @class Inventor_Post_Type_Music
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Music {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Musics', 'inventor' ),
            'singular_name'         => __( 'Music', 'inventor' ),
            'add_new'               => __( 'Add New Music', 'inventor' ),
            'add_new_item'          => __( 'Add New Music', 'inventor' ),
            'edit_item'             => __( 'Edit Music', 'inventor' ),
            'new_item'              => __( 'New Music', 'inventor' ),
            'all_items'             => __( 'Musics', 'inventor' ),
            'view_item'             => __( 'View Music', 'inventor' ),
            'search_items'          => __( 'Search Music', 'inventor' ),
            'not_found'             => __( 'No Musics found', 'inventor' ),
            'not_found_in_trash'    => __( 'No Musics Found in Trash', 'inventor' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Musics', 'inventor' ),
            'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-guitar', 'music' )
        );

        register_post_type( 'music',
            array(
                'labels'            => $labels,
                'show_in_menu'	    => 'listings',
                'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
                'has_archive'       => true,
                'rewrite'           => array( 'slug' => _x( 'musics', 'URL slug', 'inventor' ) ),
                'public'            => true,
                'show_ui'           => true,
                'show_in_rest'      => true,
                'categories'        => array(),
            )
        );
    }

    /**
     * Defines custom fields
     *
     * @access public
     * @return array
     */
    public static function fields() {
        Inventor_Post_Types::add_metabox( 'music', array( 'general', 'banner', 'gallery', 'price' ) );
    }
}

Inventor_Post_Type_Music::init();