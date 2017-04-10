<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Post_Type_Notification
 *
 * @class Inventor_Post_Type_Notification
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Notification {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_filter( 'cmb2_init', array( __CLASS__, 'fields' ) );

        add_filter( 'manage_edit-notification_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_notification_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Notifications', 'inventor-notifications' ),
            'singular_name'         => __( 'Notification', 'inventor-notifications' ),
            'add_new'               => __( 'Add New Notification', 'inventor-notifications' ),
            'add_new_item'          => __( 'Add New Notification', 'inventor-notifications' ),
            'edit_item'             => __( 'Edit Notification', 'inventor-notifications' ),
            'new_item'              => __( 'New Notification', 'inventor-notifications' ),
            'all_items'             => __( 'Notifications', 'inventor-notifications' ),
            'view_item'             => __( 'View Notification', 'inventor-notifications' ),
            'search_items'          => __( 'Search Notification', 'inventor-notifications' ),
            'not_found'             => __( 'No Notifications found', 'inventor-notifications' ),
            'not_found_in_trash'    => __( 'No Notifications Found in Trash', 'inventor-notifications' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Notifications', 'inventor-notifications' ),
        );

        register_post_type( 'notification',
            array(
                'labels'                => $labels,
                'show_in_menu'          => class_exists( 'Inventor_Admin_Menu') ? 'inventor' : true,
                'supports'              => array( 'title', 'editor', 'author' ),
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
            'id'                        => INVENTOR_NOTIFICATION_PREFIX . 'general',
            'title'                     => __( 'General', 'inventor-notifications' ),
            'object_types'              => array( 'notification' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
        ) );

        $cmb->add_field( array(
            'name'              => __( 'Action', 'inventor-notifications' ),
            'id'                => INVENTOR_NOTIFICATION_PREFIX  . 'action',
            'type'              => 'select',
            'options'           => Inventor_Notifications_Logic::get_notification_types()
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
            'title' 		    => __( 'Title', 'inventor-notifications' ),
            'action' 		    => __( 'Action', 'inventor-notifications' ),
            'author' 			=> __( 'Author', 'inventor-notifications' ),
            'date'              => __( 'Date and status', 'inventor-notifications' ),
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
            case 'action':
                $action = get_post_meta( get_the_ID(), INVENTOR_NOTIFICATION_PREFIX . 'action', true );
                $notification_types = Inventor_Notifications_Logic::get_notification_types();
                echo ( empty ( $notification_types[$action] ) ) ? $action : $notification_types[$action];
        }
    }
}

Inventor_Post_Type_Notification::init();