<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Fields_Post_Type_Field
 *
 * @class Inventor_Fields_Post_Type_Field
 * @package Inventor_Fields/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Fields_Post_Type_Field {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'pre_get_posts', array( __CLASS__, 'reorder_by_menu_order' ), 1 );
        add_filter( 'manage_edit-field_columns', array( __CLASS__, 'custom_columns' ) );

        # has to be executed later than Inventor_Fields_Post_Type_Metabox::add_metaboxes_to_post_types()
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ), 14 );
        add_action( 'cmb2_init', array( __CLASS__, 'add_fields_to_metaboxes' ), 15 );
    }

    /**
     * Reorder fields in WP admin table by menu order
     *
     * @access public
     * @return void
     */
    public static function reorder_by_menu_order( $query ) {
        if ( ! is_admin() && ! $query->is_main_query() ) {
            return;
        }

        $post_type = empty ( $query->query['post_type']) ? null : $query->query['post_type'];
        if ( $post_type == 'field' ) {
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
            'name'                  => __( 'Fields', 'inventor-fields' ),
            'singular_name'         => __( 'Field', 'inventor-fields' ),
            'add_new'               => __( 'Add New Field', 'inventor-fields' ),
            'add_new_item'          => __( 'Add New Field', 'inventor-fields' ),
            'edit_item'             => __( 'Edit Field', 'inventor-fields' ),
            'new_item'              => __( 'New Field', 'inventor-fields' ),
            'all_items'             => __( 'Fields', 'inventor-fields' ),
            'view_item'             => __( 'View Field', 'inventor-fields' ),
            'search_items'          => __( 'Search Field', 'inventor-fields' ),
            'not_found'             => __( 'No Fields found', 'inventor-fields' ),
            'not_found_in_trash'    => __( 'No Fields found in Trash', 'inventor-fields' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Fields', 'inventor-fields' ),
        );

        register_post_type( 'field',
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
     * Defines custom fields
     *
     * @access public
     */
    public static function fields() {
        // Settings
        $settings = new_cmb2_box( array(
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'settings',
            'title'         => __( 'Settings', 'inventor-fields' ),
            'object_types'  => array( 'field' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        // Identifier
        $settings->add_field( array(
            'name'          => __( 'Identifier', 'inventor-fields' ),
            'description'   => __( 'Unique identifier (Slug with lowercase characters).', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'identifier',
            'type'          => 'text',
            'after_field'   => sprintf( __( 'Final ID will be <b>%s$identifier</b>', 'inventor-fields' ), INVENTOR_LISTING_PREFIX ),
            'column'        => true,
            'attributes'    => array(
                'required'      => 'required',
                'pattern'       => '^[a-z0-9]+(?:[-_][a-z0-9]+)*(!)?$',
                'maxlength'     => 40
            )
        ) );

        // Required
        $settings->add_field( array(
            'name'          => __( 'Required', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'required',
            'type'          => 'checkbox',
        ) );

        // Skip
        $settings->add_field( array(
            'name'          => __( 'Skip', 'inventor-fields' ),
            'description'   => __( 'From attributes section on listing detail', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'skip',
            'type'          => 'checkbox',
        ) );

        // Description
        $settings->add_field( array(
            'name'          => __( 'Description', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'description',
            'type'          => 'text',
        ) );

        // Label position
        $settings->add_field( array(
            'name'          => __( 'Label position', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'label_position',
            'type'          => 'select',
            'default'       => 'left',
            'options'       => array(
                'top'           => __( 'Top', 'inventor-fields' ),
                'left'          => __( 'Left', 'inventor-fields' ),
                'hidden'        => __( 'Hidden', 'inventor-fields' ),
            ),
        ) );

        $inventor_field_types = apply_filters( 'inventor_metabox_field_types', array(
            'text'                              => __( 'Text', 'inventor-fields' ),
            'text_small'                        => __( 'Small text', 'inventor-fields' ),
            'text_medium'                       => __( 'Medium text', 'inventor-fields' ),
            'text_email'                        => __( 'Email address', 'inventor-fields' ),
            'text_url'                          => __( 'URL', 'inventor-fields' ),
            'text_money'                        => __( 'Money', 'inventor-fields' ),
            'textarea'                          => __( 'Textarea', 'inventor-fields' ),
            'textarea_small'                    => __( 'Smaller textarea', 'inventor-fields' ),
            'textarea_code'                     => __( 'Code textarea', 'inventor-fields' ),
            'wysiwyg'                           => __( 'TinyMCE wysiwyg editor', 'inventor-fields' ),
            'text_time'                         => __( 'Time picker', 'inventor-fields' ),
            'select_timezone'                   => __( 'Timezone', 'inventor-fields' ),
            'text_date_timestamp'               => __( 'Date', 'inventor-fields' ),
            'text_datetime_timestamp'           => __( 'Date and time', 'inventor-fields' ),
            'text_datetime_timestamp_timezone'  => __( 'Date, time and timezone', 'inventor-fields' ),
//                'hidden'                            => __( 'Hidden input type', 'inventor-fields' ),
            'colorpicker'                       => __( 'Colorpicker', 'inventor-fields' ),
            'checkbox'                          => __( 'Checkbox', 'inventor-fields' ),
            'multicheck'                        => __( 'Multicheck', 'inventor-fields' ),
            'multicheck_inline'                 => __( 'Multicheck inline', 'inventor-fields' ),
            'radio'                             => __( 'Radio', 'inventor-fields' ),
            'radio_inline'                      => __( 'Radio inline', 'inventor-fields' ),
            'select'                            => __( 'Select', 'inventor-fields' ),
            'file'                              => __( 'File uploader', 'inventor-fields' ),
            'file_list'                         => __( 'Files uploader', 'inventor-fields' ),
            'oembed'                            => __( 'Embed media', 'inventor-fields' ),
            'taxonomy_radio'                    => __( 'Taxonomy radio', 'inventor-fields' ),
            'taxonomy_radio_inline'             => __( 'Taxonomy radio inline', 'inventor-fields' ),
            'taxonomy_select_hierarchy'         => __( 'Taxonomy select', 'inventor-fields' ),
            'taxonomy_multicheck_hierarchy'     => __( 'Taxonomy multicheck', 'inventor-fields' ),
            'taxonomy_multicheck_inline'        => __( 'Taxonomy multicheck inline', 'inventor-fields' ),
            'title'                             => __( 'Title (A large title useful for breaking up sections of fields in metabox).', 'inventor-fields' ),
        ) );

        // Type
        $settings->add_field( array(
            'name'          => __( 'Type', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX . 'type',
            'type'          => 'select',
            'options'       => $inventor_field_types,
            'column'        => true,
        ) );

        // Value Type
        $settings->add_field( array(
            'name'          => __( 'Value Type', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'value_type',
            'type'          => 'select',
            'options'       => array(
                'characters'        => __( 'Characters', 'inventor-fields' ),
                'integer'           => __( 'Integer', 'inventor-fields' ),
                'positive_integer'  => __( 'Positive integer', 'inventor-fields' ),
                'decimal'           => __( 'Decimal', 'inventor-fields' ),
                'positive_decimal'  => __( 'Positive decimal', 'inventor-fields' ),
            ),
        ) );

        // Options
        $settings->add_field( array(
            'name'          => __( 'Options', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'options',
            'type'          => 'textarea',
            'description'   => __( 'Comma separated options if type support choices', 'inventor-fields' ),
        ) );

        // Taxonomy
        $taxonomies = array();

        foreach ( get_taxonomies( array(), 'objects' ) as $taxonomy ) {
            if ( $taxonomy->show_in_menu === 'lexicon' ) {
                $taxonomies[$taxonomy->name] = $taxonomy->labels->name;
            }
        }

        // Sort alphabetically
        ksort( $taxonomies );

        $settings->add_field( array(
            'name'          => __( 'Taxonomy', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'taxonomy',
            'type'          => 'select',
            'description'   => __( 'Choose lexicon', 'inventor-fields' ),
            'options'       => $taxonomies
        ) );

        // Filter field
        $settings->add_field( array(
            'name'          => __( 'Filter field', 'inventor-fields' ),
            'description'   => __( 'Check if you want to enable this field in listing filter', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'filter_field',
            'type'          => 'checkbox',
        ) );

        // Filter field lookup
        $settings->add_field( array(
            'name'          => __( 'Filter lookup', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'filter_lookup',
            'description'   => __( 'Specifies how to compare searched value with listing attribute', 'inventor-fields' ),
            'type'          => 'select',
            'options'       => array(
                '='             => __( 'equals', 'inventor-fields' ),
                '!='            => __( 'differs', 'inventor-fields' ),
                '<'             => __( 'lower', 'inventor-fields' ),
                '<='            => __( 'lower or equal', 'inventor-fields' ),
                '>'             => __( 'greater', 'inventor-fields' ),
                '>='            => __( 'greater or equal', 'inventor-fields' ),
                'LIKE'          => __( 'contains', 'inventor-fields' ),
                'NOT LIKE'      => __( 'does not contain', 'inventor-fields' ),
            ),
            'sanitization_cb'   => array( 'Inventor_Utilities', 'sanitize_unescaped' ),
            'escape_cb'         => array( 'Inventor_Utilities', 'sanitize_unescaped' )
        ) );

        // Target
        $settings->add_field( array(
            'name'          => __( 'Target', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'target',
            'type'          => 'radio_inline',
            'default'       => 'listing',
            'options'       => array(
                'listing'       => __( 'Listing', 'inventor-fields' ),
                'user'          => __( 'User', 'inventor-fields' ),
            ),
        ) );

        // Metaboxes
        $meta_boxes = CMB2_Boxes::get_all();
        $boxes = array();

        $post_types = Inventor_Post_Types::get_listing_post_types();

        foreach ( $meta_boxes as $meta_box ) {
            $types = $meta_box->meta_box['object_types'];

            if ( is_array( $types ) && ( ! empty( $types[0] ) && in_array( $types[0], $post_types ) ) || in_array( 'user', $types ) ) {
                if ( $types == array( 'user' ) ) {
                    $target = __( 'User', 'inventor-fields' );
                } else {
                    $post_type = get_post_type_object( $types[0] );
                    $target = $post_type->labels->singular_name;
                }
                $boxes[ $meta_box->meta_box['id'] ] = sprintf('<strong>%s</strong>: %s' , $target, $meta_box->meta_box['title'] );
            }
        }

        ksort($boxes);

        $settings->add_field( array(
            'name'          => __( 'Metabox', 'inventor-fields' ),
            'id'            => INVENTOR_FIELDS_FIELD_PREFIX  . 'metabox',
            'type'          => 'multicheck',
            'options'       => $boxes,
            'column'        => true,
        ) );
    }

    /**
     * Adds defined fields into metaboxes
     *
     * @access public
     */
    public static function add_fields_to_metaboxes() {
        $query = new WP_Query( array(
            'post_type'         => 'field',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'orderby'           => 'menu_order',
            'order'             => 'ASC',
        ) );

        foreach ( $query->posts as $field ) {
            $metaboxes = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'metabox', true );

            if ( ! is_array( $metaboxes ) ) {
                continue;
            }

            $field_settings = Inventor_Fields_Logic::get_field_settings( $field );

            $identifier = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'identifier', true );
            $target = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'target', true );

            foreach ( $metaboxes as $metabox_id ) {
                $metabox = CMB2_Boxes::get( $metabox_id );

                if ( empty( $metabox ) ) {
                    continue;
                }

                $object_types = $metabox->meta_box['object_types'];
                $listing_type = count( $object_types ) == 1 ? $object_types[0] : '';

                if ( substr ( $identifier, -1 ) == '!' ) {
                    $field_id = str_replace( '!', '', $identifier );
                } else {
                    $field_prefix = $target == 'user' ? INVENTOR_USER_PREFIX : INVENTOR_LISTING_PREFIX;
                    $field_id = $field_prefix . $identifier;
                    $field_id = apply_filters( 'inventor_metabox_field_id', $field_id, $metabox_id, $listing_type );
                }

                $field_settings['id'] = $field_id;
                $field_settings['name'] = apply_filters( 'inventor_metabox_field_name', $field_settings['name'], $metabox_id, $field_id, $listing_type );
                $field_settings['description'] = apply_filters( 'inventor_metabox_field_description', $field_settings['description'], $metabox_id, $field_id, $listing_type );
                $field_settings['default'] = apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $listing_type );
                $field_settings['attributes'] = apply_filters( 'inventor_metabox_field_attributes', $field_settings['attributes'], $metabox_id, $field_id, $listing_type );
                $field_settings['options'] = apply_filters( 'inventor_metabox_field_options', $field_settings['options'], $metabox_id, $field_id, $listing_type );
                $field_settings['before_row'] = apply_filters( 'inventor_metabox_field_before_row', '', $metabox_id, $field_id, $listing_type );
                $field_settings['before'] = apply_filters( 'inventor_metabox_field_before', '', $metabox_id, $field_id, $listing_type );
                $field_settings['before_field'] = apply_filters( 'inventor_metabox_field_before_field', $field_settings['before_field'], $metabox_id, $field_id, $listing_type );
                $field_settings['after_field'] = apply_filters( 'inventor_metabox_field_after_field', '', $metabox_id, $field_id, $listing_type );
                $field_settings['after'] = apply_filters( 'inventor_metabox_field_after', '', $metabox_id, $field_id, $listing_type );
                $field_settings['after_row'] = apply_filters( 'inventor_metabox_field_after_row', '', $metabox_id, $field_id, $listing_type );
                $field_settings['position'] = apply_filters( 'inventor_metabox_field_position', $field_settings['position'], $metabox_id, $field_id, $listing_type );

                $reserved_ids = array(
                    INVENTOR_LISTING_PREFIX . 'title',           // TODO: check if post type supports title
                    INVENTOR_LISTING_PREFIX . 'description',	 // TODO: check if post type supports description
                    INVENTOR_LISTING_PREFIX . 'featured_image',  // TODO: check if post type supports featured_image
                );

                if ( ! is_admin() || ! in_array( $field_id, $reserved_ids ) ) {
                    if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $listing_type ) ) {
                        $metabox->add_field( $field_settings, $field_settings['position'] );
                    }
                }
            }
        }
    }

    /**
     * Returns possible field IDS (for each listing type)
     *
     * @access public
     * @param $field_id int
     * @return array
     */
    public static function get_possible_ids( $field_id ) {
        $ids = array();

        $identifier = get_post_meta( $field_id, INVENTOR_FIELDS_FIELD_PREFIX  . 'identifier', true );
        $metaboxes = get_post_meta( $field_id, INVENTOR_FIELDS_FIELD_PREFIX  . 'metabox', true );

        if ( ! is_array( $metaboxes ) ) {
            return $ids;
        }

        foreach ( $metaboxes as $metabox_id ) {
            $metabox = CMB2_Boxes::get( $metabox_id );

            if ( empty( $metabox ) ) {
                continue;
            }

            $object_types = $metabox->meta_box['object_types'];
            $listing_type = count( $object_types ) == 1 ? $object_types[0] : '';

            if ( substr ( $identifier, -1) == '!') {
                $field_id = str_replace( '!', '', $identifier );
            } else {
                $listing_type_prefix = empty( $listing_type ) ? '' : $listing_type . '_';

                $field_id = INVENTOR_LISTING_PREFIX . $listing_type_prefix . $identifier;
                $field_id = apply_filters( 'inventor_metabox_field_id', $field_id, $metabox_id, $listing_type );
            }

            $ids[] = $field_id;
        }

        return $ids;
    }
}

Inventor_Fields_Post_Type_Field::init();