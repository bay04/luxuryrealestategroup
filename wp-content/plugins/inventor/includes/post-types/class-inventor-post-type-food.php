<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Post_Type_Food
 *
 * @class Inventor_Post_Type_Food
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Food {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
        add_filter( 'inventor_bookings_allowed_listing_post_types', array( __CLASS__, 'allowed_booking' ) );
        add_filter( 'inventor_claims_allowed_listing_post_types', array( __CLASS__, 'allowed_claiming' ) );
        add_filter( 'manage_edit-food_columns', array( __CLASS__, 'custom_columns' ) );
    }

    /**
     * Defines if post type can be claimed
     *
     * @access public
     * @param array $post_types
     * @return array
     */
    public static function allowed_claiming( $post_types ) {
        $post_types[] = 'food';
        return $post_types;
    }

    /**
     * Defines if post type can be booked
     *
     * @access public
     * @param array $post_types
     * @return array
     */
    public static function allowed_booking( $post_types ) {
        $post_types[] = 'food';
        return $post_types;
    }

    /**
     * Custom admin columns
     *
     * @access public
     * @return array
     */
    public static function custom_columns( $columns ) {
        unset( $columns['taxonomy-meals_and_drinks_sections'] );
        return $columns;
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Food & Drinks', 'inventor' ),
            'singular_name'         => __( 'Food & Drink', 'inventor' ),
            'add_new'               => __( 'Add New Food & Drink', 'inventor' ),
            'add_new_item'          => __( 'Add New Food & Drink', 'inventor' ),
            'edit_item'             => __( 'Edit Food & Drink', 'inventor' ),
            'new_item'              => __( 'New Food & Drink', 'inventor' ),
            'all_items'             => __( 'Food & Drinks', 'inventor' ),
            'view_item'             => __( 'View Food & Drink', 'inventor' ),
            'search_items'          => __( 'Search Food & Drink', 'inventor' ),
            'not_found'             => __( 'No Food & Drinks found', 'inventor' ),
            'not_found_in_trash'    => __( 'No Food & Drinks Found in Trash', 'inventor' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Food & Drinks', 'inventor' ),
            'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-lunch', 'food' )
        );

        register_post_type( 'food',
            array(
                'labels'            => $labels,
                'show_in_menu'	    => 'listings',
                'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
                'has_archive'       => true,
                'rewrite'           => array( 'slug' => _x( 'foods', 'URL slug', 'inventor' ) ),
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
        $post_type = 'food';
        Inventor_Post_Types::add_metabox( $post_type, array( 'general' ) );

        $metabox_id = INVENTOR_LISTING_PREFIX . 'food_details';

        $cmb = new_cmb2_box( array(
            'id'            => $metabox_id,
            'title'         => apply_filters( 'inventor_metabox_title', __( 'Details', 'inventor' ), $metabox_id, $post_type ),
            'description'   => apply_filters( 'inventor_metabox_description', null, $metabox_id, $post_type ),
            'object_types'  => array( $post_type ),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_in_rest'  => true,
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'food_kind';
        if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
            $field_name = __( 'Food kind', 'inventor' );

            $cmb->add_field( array(
                'id'                => $field_id,
                'type'              => 'taxonomy_select',
                'taxonomy'          => 'food_kinds',
                'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
                'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
                'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
                'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            ) );
        }

        Inventor_Post_Types::add_metabox( $post_type, array( 'Inventor_Post_Type_Food::menu' ) );
        Inventor_Post_Types::add_metabox( $post_type, array( 'gallery', 'banner', 'video', 'price', 'flags', 'location', 'opening_hours', 'contact', 'social', 'listing_category' ) );
    }

    /**
     * Metabox for serving menu
     *
     * @access public
     * @param $post_type
     * @return array
     */
    public static function metabox_menu( $post_type ) {
        $metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_menu';
        $field_id = INVENTOR_LISTING_PREFIX . 'food_menu_group';

        $cmb = new_cmb2_box( array(
            'id'            => $metabox_id,
            'title'         => apply_filters( 'inventor_metabox_title', __( 'Meals and drinks menu', 'inventor' ), $metabox_id, $post_type ),
            'description'   => apply_filters( 'inventor_metabox_description', null, $metabox_id, $post_type ),
            'object_types'  => array( $post_type ),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_in_rest'  => true,
        ) );

        $group = $cmb->add_field( array(
            'id'          => $field_id,
            'type'        => 'group',
            'options'     => array(
                'group_title'   => __( 'Item', 'inventor' ),
                'add_button'    => __( 'Add Another', 'inventor' ),
                'remove_button' => __( 'Remove', 'inventor' ),
            ),
            'default'     => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_title',
            'name'              => __( 'Title', 'inventor' ),
            'type'              => 'text',
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_description',
            'name'              => __( 'Description', 'inventor' ),
            'type'              => 'text',
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_price',
            'name'              => __( 'Price', 'inventor' ),
            'type'              => 'text_money',
            'sanitization_cb'	=> false,
            'before_field'      => Inventor_Price::default_currency_symbol(),
            'description'       => sprintf( __( 'In %s.', 'inventor' ), Inventor_Price::default_currency_code() ),
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'food_menu_section';
        $field_name = __( 'Section', 'inventor' );
        $field_type = 'select';

        $cmb->add_group_field( $group, array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'options_cb' 	    => array( 'Inventor_Utilities', 'get_term_options' ),
            'show_option_none'  => true,
            'get_terms_args' 	=> array(
                'taxonomy'   => 'meals_and_drinks_sections',
                'hide_empty' => false,
            ),
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_serving',
            'name'              => __( 'Serving day', 'inventor' ),
            'type'              => 'text_date_timestamp',
            'description'       => __( 'Leave blank if it is not daily menu', 'inventor' )
        ) );

        $cmb->add_group_field( $group, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_speciality',
            'name'              => __( 'Speciality', 'inventor' ),
            'type'              => 'checkbox',
        ) );

        $cmb->add_group_field($group, array(
            'name'              => __( 'Photo', 'inventor' ),
            'id'                => INVENTOR_LISTING_PREFIX  . 'food_menu_photo',
            'type'              => 'file',
        ) );
    }

    /**
     * Gets menu groups
     *
     * @access public
     * @param null $post_id
     * @return array
     */
    public static function get_menu_groups( $post_id = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $groups = array( 'menu' => array(), 'daily_menu' => array() );
        $meals = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . 'food_menu_group', true );

        if ( is_array( $meals ) && count( $meals[0] ) > 1 ) {
            foreach ( $meals as $meal ) {
                if ( ! empty( $meal['listing_food_menu_section'] ) ) {
                    $section = get_term( $meal['listing_food_menu_section'], 'meals_and_drinks_sections' );
                    $meal['listing_food_menu_section_name'] = $section->name;
                }

                if ( empty( $meal[ INVENTOR_LISTING_PREFIX . 'food_menu_serving' ] ) ) {
                    $groups['menu'][] = $meal;
                } else {
                    $groups['daily_menu'][] = $meal;
                }
            }
        }

        usort( $groups['daily_menu'], function( $a, $b ) {
            if ( empty( $a['listing_food_menu_section'] ) && empty( $b['listing_food_menu_section'] ) ) {
                return 0;
            }

            if ( empty( $a['listing_food_menu_section'] ) ) {
                return -1;
            }

            if ( empty( $b['listing_food_menu_section'] ) ) {
                return 1;
            }

            return strnatcmp( $a['listing_food_menu_section_name'], $b['listing_food_menu_section_name'] );
        } );

        return count( $groups['daily_menu'] ) > 0 || count( $groups['menu'] ) > 0 ? $groups : array();
    }
}

Inventor_Post_Type_Food::init();