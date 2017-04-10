<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Post_Type_Watchdog
 *
 * @class Inventor_Post_Type_Watchdog
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Watchdog {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_filter( 'cmb2_init', array( __CLASS__, 'fields' ) );

        add_filter( 'manage_edit-watchdog_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_watchdog_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Watchdogs', 'inventor-watchdogs' ),
            'singular_name'         => __( 'Watchdog', 'inventor-watchdogs' ),
            'add_new'               => __( 'Add New Watchdog', 'inventor-watchdogs' ),
            'add_new_item'          => __( 'Add New Watchdog', 'inventor-watchdogs' ),
            'edit_item'             => __( 'Edit Watchdog', 'inventor-watchdogs' ),
            'new_item'              => __( 'New Watchdog', 'inventor-watchdogs' ),
            'all_items'             => __( 'Watchdogs', 'inventor-watchdogs' ),
            'view_item'             => __( 'View Watchdog', 'inventor-watchdogs' ),
            'search_items'          => __( 'Search Watchdog', 'inventor-watchdogs' ),
            'not_found'             => __( 'No Watchdogs found', 'inventor-watchdogs' ),
            'not_found_in_trash'    => __( 'No Watchdogs Found in Trash', 'inventor-watchdogs' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Watchdogs', 'inventor-watchdogs' ),
        );

        register_post_type( 'watchdog',
            array(
                'labels'                => $labels,
                'show_in_menu'          => class_exists( 'Inventor_Admin_Menu') ? 'inventor' : true,
                'supports'              => array( 'author' ),
                'public'                => false,
                'exclude_from_search'   => true,
                'publicly_queryable'    => false,
                'show_in_nav_menus'     => false,
                'has_archive'           => false,
                'show_ui'               => true,
                'categories'            => array(),
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
        $cmb = new_cmb2_box( array(
            'id'                        => INVENTOR_WATCHDOG_PREFIX . 'general',
            'title'                     => __( 'General', 'inventor-watchdogs' ),
            'object_types'              => array( 'watchdog' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
        ) );

        $cmb->add_field( array(
            'id'                => INVENTOR_WATCHDOG_PREFIX . 'type',
            'name'              => __( 'Type', 'inventor-watchdogs' ),
            'type'              => 'radio_inline',
            'options'           => array(
                INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY     => __( 'Search query', 'inventor-watchdogs' ),
            ),
        ) );

        $cmb->add_field( array(
            'id'                => INVENTOR_WATCHDOG_PREFIX. 'lookup',
            'name'              => __( 'Data', 'inventor-watchdogs' ),
            'type'              => 'textarea',
        ) );
    }

    /**
     * Custom admin columns
     *
     * @access public
     * @return array
     */
    public static function custom_columns() {
        $fields = array(
            'cb' 				=> '<input type="checkbox" />',
            'type' 		        => __( 'Type', 'inventor-watchdogs' ),
            'lookup'     	    => __( 'Lookup', 'inventor-watchodgs' ),
            'value'     	    => __( 'Value', 'inventor-watchdogs' ),
            'author' 			=> __( 'Author', 'inventor-watchdogs' ),
            'date' 			    => __( 'Date', 'inventor-watchdogs' ),
        );
        return $fields;
    }

    /**
     * Custom admin columns implementation
     *
     * @access public
     * @param string $column
     * @return array
     */
    public static function custom_columns_manage( $column ) {
        switch ( $column ) {
            case 'type':
                $type = get_post_meta( get_the_ID(), INVENTOR_WATCHDOG_PREFIX . 'type', true );
                echo $type;
                break;
            case 'lookup':
                Inventor_Watchdogs_Logic::render_watchdog_lookup( get_the_ID() );
                break;
        }
    }

    /**
     * Unserialize watchdog lookup
     *
     * @access public
     * @return object
     */
    public static function get_lookup( $watchdog_id ) {
        $lookup = get_post_meta( $watchdog_id, INVENTOR_WATCHDOG_PREFIX . 'lookup', true );
        if ( empty( $lookup ) ) {
            return null;
        }
        return unserialize( $lookup );
    }
}

Inventor_Post_Type_Watchdog::init();