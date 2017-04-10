<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Fields_Post_Type_Metabox
 *
 * @class Inventor_Fields_Post_Type_Metabox
 * @package Inventor_Fields/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Fields_Post_Type_Metabox {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'pre_get_posts', array( __CLASS__, 'reorder_by_menu_order' ), 1 );
        add_filter( 'manage_edit-metabox_columns', array( __CLASS__, 'custom_columns' ) );

        add_action( 'cmb2_init', array( __CLASS__, 'fields' ), 13 );
        add_action( 'cmb2_init', array( __CLASS__, 'add_metaboxes_to_listing_types' ), 14 );

        add_filter( 'inventor_listing_detail_custom_sections', array( __CLASS__, 'add_metaboxes_to_custom_sections' ), 10, 2 );
    }

    /**
     * Custom admin columns
     *
     * @access public
     * @return array
     */
    public static function custom_columns( $columns ) {
        unset( $columns['date'] );
        return $columns;
    }

    /**
     * Reorder metaboxes in WP admin table by menu order
     *
     * @access public
     * @return void
     */
    public static function reorder_by_menu_order( $query ) {
        if ( ! is_admin() && ! $query->is_main_query() ) {
            return;
        }

        $post_type = empty ( $query->query['post_type']) ? null : $query->query['post_type'];
        if ( $post_type == 'metabox' ) {
            $query->set( 'order' , 'ASC' );
            $query->set( 'orderby', 'menu_order');
            return;
        }
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Metaboxes', 'inventor-fields' ),
            'singular_name'         => __( 'Metabox', 'inventor-fields' ),
            'add_new_item'          => __( 'Add New Metabox', 'inventor-fields' ),
            'add_new'               => __( 'Add New Metabox', 'inventor-fields' ),
            'edit_item'             => __( 'Edit Metabox', 'inventor-fields' ),
            'new_item'              => __( 'New Metabox', 'inventor-fields' ),
            'all_items'             => __( 'Metaboxes', 'inventor-fields' ),
            'view_item'             => __( 'View Metabox', 'inventor-fields' ),
            'search_items'          => __( 'Search Metabox', 'inventor-fields' ),
            'not_found'             => __( 'No Metaboxes found', 'inventor-fields' ),
            'not_found_in_trash'    => __( 'No Metaboxes found in Trash', 'inventor-fields' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Metaboxes', 'inventor-fields' ),
        );

        register_post_type( 'metabox',
            array(
                'labels'                => $labels,
                'supports'              => array( 'title', 'page-attributes' ),
                'public'                => false,
                'exclude_from_search'   => true,
                'publicly_queryable'    => false,
                'show_in_nav_menus'     => false,
                'show_ui'               => true,
                'show_in_menu'          => class_exists( 'Inventor_Admin_Menu' ) ? 'inventor' : true,
            )
        );
    }

    /**
     * Defines custom fields
     *
     * @access public
     */
    public static function fields() {
        // Settings
        $settings = new_cmb2_box( array(
            'id'            => INVENTOR_FIELDS_METABOX_PREFIX . 'settings',
            'title'         => __( 'Settings', 'inventor-fields' ),
            'object_types'  => array( 'metabox' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        // Identifier
        $settings->add_field( array(
            'name'          => __( 'Identifier', 'inventor-fields' ),
            'description'   => __( 'Unique identifier (Slug with lowercase characters).', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_METABOX_PREFIX . 'identifier',
            'after_field'  => sprintf( __( 'Final ID will be <b>%s$listing_type_$identifier</b>', 'inventor-fields' ), INVENTOR_LISTING_PREFIX ),
            'type'          => 'text',
            'column'        => true,
            'attributes'    => array(
                'required'      => 'required',
                'pattern'       => '^[a-z0-9]+(?:[-_][a-z0-9]+)*(!)?$',
                'maxlength'     => 40
            )
        ) );

        // Description
        $settings->add_field( array(
            'name'          => __( 'Description', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_METABOX_PREFIX . 'description',
            'type'          => 'text',
        ) );

        // Section
        $settings->add_field( array(
            'name'          => __( 'Section', 'inventor-fields' ),
            'description'   => __( 'Show as a section in the listing detail page.', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_METABOX_PREFIX . 'section',
            'type'          => 'checkbox',
        ) );

        if ( class_exists( 'Inventor_Packages' ) ) {
            // Package permission
            $settings->add_field( array(
                'name'          => __( 'Package permission', 'inventor-fields' ),
                'description'   => __( 'Allows you to set package permission for this metabox.', 'inventor-fields' ),
                'id'            => INVENTOR_FIELDS_METABOX_PREFIX . 'package_permission',
                'type'          => 'checkbox',
            ) );
        }

        // Listing types
        $settings->add_field( array(
            'name'          => __( 'Listing type', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_METABOX_PREFIX . 'listing_type',
            'type'          => 'multicheck',
            'options'       => Inventor_Post_Types::get_listing_post_types( false, true ),
            'column'        => true,
        ) );
    }

    /**
     * Adds defined metaboxes into post types
     *
     * @access public
     */
    public static function add_metaboxes_to_listing_types() {
        $query = new WP_Query( array(
            'post_type'         => 'metabox',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'orderby'           => 'menu_order',
            'order'             => 'ASC',
        ) );

        foreach ( $query->posts as $metabox ) {
            $listing_types = get_post_meta( $metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'listing_type', true );

            if ( ! is_array( $listing_types ) ) {
                continue;
            }

            $identifier = get_post_meta( $metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'identifier', true );
            $description = get_post_meta( $metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'description', true );

            foreach ( $listing_types as $listing_type ) {
                if ( substr ( $identifier, -1) == '!') {
                    $metabox_id = str_replace( '!', '', $identifier );
                } else {
                    $metabox_id = INVENTOR_LISTING_PREFIX . $listing_type . '_' . $identifier;
                    $metabox_id = apply_filters( 'inventor_metabox_id', $metabox_id, $listing_type );
                }

                $title = apply_filters( 'inventor_metabox_title', get_the_title( $metabox->ID ), $metabox_id, $listing_type );
                $description = apply_filters( 'inventor_metabox_description', $description, $metabox_id, $listing_type );

                new_cmb2_box( array(
                    'id'            => $metabox_id,
                    'title'         => $title,
                    'description'   => $description,
                    'object_types'  => array( $listing_type ),
                    'context'       => 'normal',
                    'priority'      => 'high',
                    'show_in_rest'  => true,
                ) );
            }
        }
    }

    /**
     * Adds metaboxes to custom sections
     *
     * @param array $custom_sections
     * @param string $post_type
     * @return array
     * @access public
     */
    public static function add_metaboxes_to_custom_sections( $custom_sections, $post_type ) {
        $query = new WP_Query( array(
            'post_type'         => 'metabox',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'orderby'           => 'menu_order',
            'order'             => 'ASC',
            'meta_key'          => INVENTOR_FIELDS_METABOX_PREFIX . 'section',
            'meta_value'        => 'on',
        ) );

        foreach ( $query->posts as $metabox ) {
            $listing_types = get_post_meta( $metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'listing_type', true );

            if ( ! is_array( $listing_types ) ) {
                continue;
            }

            $identifier = get_post_meta( $metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'identifier', true );
            $title = get_the_title( $metabox->ID );

            foreach ( $listing_types as $listing_type ) {
                if ( substr ( $identifier, -1) == '!') {
                    $metabox_id = str_replace( '!', '', $identifier );
                    $metabox_key = $metabox_id;
                } else {
                    $metabox_id = INVENTOR_LISTING_PREFIX . $listing_type . '_' . $identifier;
                    $metabox_id = apply_filters( 'inventor_metabox_id', $metabox_id, $listing_type );
                    $metabox_key = Inventor_Metaboxes::get_metabox_key( $metabox_id, $listing_type );
                }

                if ( $listing_type == $post_type ) {
                    $custom_sections[ $metabox_key ] = $title;
                }
            }
        }

        return $custom_sections;
    }
}

Inventor_Fields_Post_Type_Metabox::init();