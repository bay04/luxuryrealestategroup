<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Post_Type_Mail_Template
 *
 * @class Inventor_Post_Type_Mail_Template
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Mail_Template {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_filter( 'cmb2_init', array( __CLASS__, 'fields' ) );

        add_filter( 'manage_edit-mail_template_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_mail_template_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Mail templates', 'inventor-mail-templates' ),
            'singular_name'         => __( 'Mail template', 'inventor-mail-templates' ),
            'add_new'               => __( 'Add New Mail Template', 'inventor-mail-templates' ),
            'add_new_item'          => __( 'Add New Mail Template', 'inventor-mail-templates' ),
            'edit_item'             => __( 'Edit Mail Template', 'inventor-mail-templates' ),
            'new_item'              => __( 'New Mail Template', 'inventor-mail-templates' ),
            'all_items'             => __( 'Mail Templates', 'inventor-mail-templates' ),
            'view_item'             => __( 'View Mail Template', 'inventor-mail-templates' ),
            'search_items'          => __( 'Search Mail Template', 'inventor-mail-templates' ),
            'not_found'             => __( 'No Mail Templates found', 'inventor-mail-templates' ),
            'not_found_in_trash'    => __( 'No Mail Templates Found in Trash', 'inventor-mail-templates' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'mail-templates', 'inventor-mail-templates' ),
        );

        register_post_type( 'mail_template',
            array(
                'labels'                => $labels,
                'show_in_menu'          => class_exists( 'Inventor_Admin_Menu') ? 'inventor' : true,
                'supports'              => array( 'title', 'editor', 'author' ),
                'public'                => false,
                'exclude_from_search'   => true,
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
            'id'                        => INVENTOR_MAIL_TEMPLATE_PREFIX . 'general',
            'title'                     => __( 'General', 'inventor-mail-templates' ),
            'object_types'              => array( 'mail_template' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
        ) );

        $action_choices = apply_filters( 'inventor_mail_actions_choices', array() );

        $cmb->add_field( array(
            'name'              => __( 'Action', 'inventor-mail-templates' ),
            'id'                => INVENTOR_MAIL_TEMPLATE_PREFIX  . 'action',
            'type'              => 'select',
            'options'           => $action_choices
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
            'title' 		    => __( 'Title', 'inventor-mail-templates' ),
            'action' 		    => __( 'Action', 'inventor-mail-templates' ),
            'author' 			=> __( 'Author', 'inventor-mail-templates' ),
            'date'              => __( 'Date and status', 'inventor-mail-templates' ),
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
                $action = get_post_meta( get_the_ID(), INVENTOR_MAIL_TEMPLATE_PREFIX . 'action', true );
                $mail_actions = apply_filters( 'inventor_mail_actions_choices', array() );
                echo ( empty ( $mail_actions[$action] ) ) ? $action : $mail_actions[$action];
        }
    }
}

Inventor_Post_Type_Mail_template::init();