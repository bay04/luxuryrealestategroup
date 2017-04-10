<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Fields_Logic
 *
 * @class Inventor_Fields_Logic
 * @package Inventor_Fields/Classes/Logic
 * @author Pragmatic Mates
 */
class Inventor_Fields_Logic {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_filter( 'inventor_filter_fields', array( __CLASS__, 'filter_fields' ) );
        add_filter( 'inventor_filter_field_plugin_dir', array( __CLASS__, 'filter_field_plugin_dir' ), 10, 3 );
        add_filter( 'inventor_filter_query_taxonomies', array( __CLASS__, 'filter_query_taxonomies' ), 10, 2 );
        add_filter( 'inventor_filter_query_meta', array( __CLASS__, 'filter_query_meta' ), 10, 2 );
        add_filter( 'inventor_filter_query_ids', array( __CLASS__, 'filter_query_ids' ), 10, 2 );
        add_filter( 'inventor_filter_query_ids', array( __CLASS__, 'filter_query_ids_of_multicheck_values' ), 10, 2 );

        add_filter( 'inventor_packages_metabox_permissions', array( __CLASS__, 'metabox_permissions' ) );
    }

    /**
     * Returns field by its identifier
     *
     * @access public
     * @param $field_identifier
     * @return WP_Post
     */
    public static function get_field( $field_identifier ) {
        $query = new WP_Query( array(
            'post_type'         => 'field',
            'posts_per_page'    => -1,
            'meta_key'          => INVENTOR_FIELDS_FIELD_PREFIX . 'identifier',
            'meta_value'        => $field_identifier
        ) );

        return $query->post_count == 1 ? $query->posts[0] : null;
    }

    /**
     * Returns field by its identifier
     *
     * @access public
     * @param WP_Post $field
     * @return array
     */
    public static function get_field_settings( $field ) {
        $type = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'type', true );
        $label_position = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'label_position', true );
//            $label_position = empty( $label_position ) ? 'left' : $label_position;
        $value_type = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'value_type', true );
        $description = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'description', true );
        $required = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'required', true );
        $skip = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'skip', true );
        $taxonomy = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'taxonomy', true );
        $options = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'options', true );
        $options = explode( ',', $options );
        $options = array_map( 'trim', $options );  // remove empty spaces
        $options = array_combine($options, $options);
        $title = get_the_title( $field->ID );

        $field_settings = array(
            'name'          => $title,
            'type'          => $type,
            'description'   => $description,
            'options'       => $options,
            'taxonomy'      => $taxonomy,
            'skip'          => $skip,
        );

        switch( $label_position ) {
            case 'top':
                $field_settings['row_classes'] = 'label-top';
                break;
            case 'hidden':
                $field_settings['show_names'] = false;
                break;
            default:
                $field_settings['row_classes'] = 'label-left';
                break;
        }

        $attributes = array();
        $before_field = null;

        if ( ! empty( $required ) ) {
            $attributes['required'] = 'required';
            $field_settings['show_option_none'] = false;
        } elseif ( strpos( $type, 'select' ) !== false ) {
            $field_settings['show_option_none'] = true;
        }

        if ( in_array( $type, array( 'text', 'text_small', 'text_medium' ) ) ) {
            if ( $value_type == 'integer' ) {
                $attributes['type'] = 'number';
                $attributes['pattern'] = '\d*';
            }

            if ( $value_type == 'decimal' ) {
                $attributes['type'] = 'number';
                $attributes['step'] = 'any';
                $attributes['pattern'] = '\d*(\.\d*)?';
            }

            if ( $value_type == 'positive_integer' ) {
                $attributes['type'] = 'number';
                $attributes['min'] = 0;
                $attributes['pattern'] = '\d*';
            }

            if ( $value_type == 'positive_decimal' ) {
                $attributes['type'] = 'number';
                $attributes['step'] = 'any';
                $attributes['min'] = 0;
                $attributes['pattern'] = '\d*(\.\d*)?';
            }
        }

        if ( 'text_money' == $type ) {
            $attributes['type'] = 'number';
            $attributes['step'] = 'any';
            $attributes['min'] = 0;
            $attributes['pattern'] = '\d*(\.\d*)?';
            $before_field = Inventor_Price::default_currency_symbol();
            $field_settings['sanitization_cb'] = false;
        }

        if ( 'opening_hours' == $type ) {
            $field_settings['escape_cb'] = 'cmb2_escape_opening_hours_value';
        }

        $field_settings['attributes'] = $attributes;

        $field_settings['position'] = get_post_field( 'menu_order', $field->ID );
        $field_settings['before_field'] = $before_field;

        return $field_settings;
    }

    /**
     * Returns all custom fields
     *
     * @access public
     * @param $types array
     * @param $types_compare string
     * @return array
     */
    public static function get_fields( $types = array(), $types_compare = '=' ) {
        $filter_fields = array();

        $query_args = array(
            'post_type'         => 'field',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
        );

        $meta_query = array(
            'relation' => 'OR'
        );

        if ( is_array( $types ) ) {
            foreach ( $types as $type ) {
                $meta_query[] = array(
                    'key'          => INVENTOR_FIELDS_FIELD_PREFIX . 'type',
                    'value'        => $type,
                    'compare'      => $types_compare
                );
            }
        }
        if ( count( $meta_query ) > 1 ) {
            $query_args['meta_query'] = $meta_query;
        }

        $query = new WP_Query( $query_args );

        foreach ( $query->posts as $field ) {
            $identifier = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'identifier', true );
            $filter_fields[ $identifier ] = get_the_title( $field->ID );
        }

        return $filter_fields;
    }

    /**
     * Returns all custom filter fields
     *
     * @access public
     * @param $types array
     * @param $types_compare string
     * @return array
     */
    public static function get_filter_fields( $types = array(), $types_compare = '=' ) {
        $filter_fields = array();

        $meta_query = array(
            'relation' => 'AND',
            array(
                'key'          => INVENTOR_FIELDS_FIELD_PREFIX . 'filter_field',
                'value'        => 'on'
            )
        );

        $types_meta_query = array(
            'relation' => 'OR'
        );

        if ( is_array( $types ) ) {
            foreach ( $types as $type ) {
                $types_meta_query[] = array(
                    'key'          => INVENTOR_FIELDS_FIELD_PREFIX . 'type',
                    'value'        => $type,
                    'compare'      => $types_compare
                );
            }
        }

        if ( count( $types_meta_query ) > 1 ) {
            $meta_query[] = $types_meta_query;
        }

        $query = new WP_Query( array(
            'post_type'         => 'field',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'meta_query'        => $meta_query
        ) );

        foreach ( $query->posts as $field ) {
            $identifier = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'identifier', true );
            $filter_fields[ $identifier ] = get_the_title( $field->ID );
        }

        return $filter_fields;
    }

    /**
     * Returns all custom metabox permissions
     *
     * @access public
     * @return array
     */
    public static function get_metabox_permissions() {
        $metabox_permissions = array();

        $query = new WP_Query( array(
            'post_type'         => 'metabox',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'meta_key'          => INVENTOR_FIELDS_METABOX_PREFIX . 'package_permission',
            'meta_value'        => 'on',
        ) );

        foreach ( $query->posts as $metabox ) {
            $identifier = get_post_meta( $metabox->ID, INVENTOR_FIELDS_METABOX_PREFIX . 'identifier', true );
            $metabox_permissions[ $identifier ] = get_the_title( $metabox->ID );
        }

        return $metabox_permissions;
    }

    /**
     * Adds filter fields to filter
     *
     * @access public
     * @param $fields array
     * @return array
     */
    public static function filter_fields( $fields ) {
        $custom_filter_fields = self::get_filter_fields();
        return count( $custom_filter_fields ) == 0 ? $fields : array_merge( $fields, $custom_filter_fields );
    }

    /**
     * Adds custom metaboxes to the package metabox permissions
     *
     * @access public
     * @param $fields array
     * @return array
     */
    public static function metabox_permissions( $fields ) {
        $custom_metabox_permissions = self::get_metabox_permissions();
        return count( $custom_metabox_permissions ) == 0 ? $fields : array_merge( $fields, $custom_metabox_permissions );
    }

    /**
     * Sets template directory for filter fields
     *
     * @access public
     * @param $plugin_dir string
     * @param $template string
     * @param $field_id string
     * @return string
     */
    public static function filter_field_plugin_dir( $plugin_dir, $template, $field_id ) {
        $custom_filter_fields = self::get_filter_fields();
        return array_key_exists( $field_id, $custom_filter_fields ) ? INVENTOR_FIELDS_DIR : $plugin_dir;
    }

    /**
     * Filters listings by taxonomy filter fields
     *
     * @access public
     * @param $taxonomies array
     * @param $params array
     * @return array
     */
    public static function filter_query_taxonomies( $taxonomies, $params ) {
        $custom_filter_fields = self::get_filter_fields( array( 'taxonomy' ), 'LIKE' );
        $searched_fields = array_intersect( array_keys( $custom_filter_fields ), array_keys( $params ) );

        foreach ( $searched_fields as $searched_field ) {
            $value = $params[ $searched_field ];

            if ( ! empty( $value ) ) {
                $field = self::get_field( $searched_field );
                $taxonomy = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'taxonomy', true );
                $type = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'type', true );

                $operator = strpos( $type, '_multicheck' ) === false ? 'IN' : 'AND';

                $taxonomies[] = array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $value,
                    'operator'  => $operator
                );
            }
        }

        return $taxonomies;
    }

    /**
     * Filters listings by checkbox filter fields
     *
     * @access public
     * @param $meta array
     * @param $params array
     * @return array
     */
    public static function filter_query_meta( $meta, $params ) {
        $custom_filter_fields = self::get_filter_fields( array( 'checkbox' ) );
        $searched_fields = array_intersect( array_keys( $custom_filter_fields ), array_keys( $params ) );

        foreach ( $searched_fields as $searched_field ) {
            $value = $params[ $searched_field ];

            if ( ! empty( $value ) ) {
                $field_identifier = INVENTOR_LISTING_PREFIX . $searched_field;
                $meta[] = array(
                    'key'       => $field_identifier,
                    'value'     => 'on',
                );
            }
        }

        return $meta;
    }

    /**
     * Filters query by custom fields
     *
     * @access public
     * @return array
     */
    public static function filter_query_ids( $ids, $params ) {
        $custom_filter_fields = self::get_filter_fields(
            array(
                'radio', 'radio_inline', 'colorpicker',
                'text', 'text_small', 'text_medium', 'text_email', 'text_url', 'text_money', 'text_time',
                'text_date_timestamp', 'text_datetime_timestamp', 'text_datetime_timestamp_timezone',
                'textarea', 'textarea_small', 'textarea_code', 'wysiwyg',
                'select', 'select_timezone',
            ),
            '='
        );

        $searched_fields = array_intersect( array_keys( $custom_filter_fields ), array_keys( $params ) );

        $meta_query = array(
            'relation'  => 'AND'
        );

        foreach ( $searched_fields as $searched_field ) {
            $field = self::get_field( $searched_field );
            $field_identifier = INVENTOR_LISTING_PREFIX . $searched_field;

            $filter_lookup = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX  . 'filter_lookup', true );
            $value = $params[ $searched_field ];

            if( ! empty( $value ) ) {
                $meta_query[] = array(
                    'key'       => $field_identifier,
                    'value'     => $value,
                    'compare'   => $filter_lookup
                );
            }
        }

        if ( count( $meta_query ) <= 1 ) {
            return $ids;
        }

        $query = new WP_Query( array(
            'post_type'         => Inventor_Post_Types::get_listing_post_types(),
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'meta_query'        => $meta_query
        ) );

        $searched_ids = array();

        if ( $query->post_count > 0 ) {
            foreach( $query->posts as $post ) {
                $searched_ids[] = $post->ID;
            }
        };

        $ids = Inventor_Filter::build_post_ids( $ids, $searched_ids );

        return $ids;
    }

    /**
     * Filters query by custom fields
     *
     * @access public
     * @return array
     */
    public static function filter_query_ids_of_multicheck_values( $ids, $params ) {
        $custom_filter_fields = self::get_filter_fields(
            array(
                'multicheck', 'multicheck_inline'
            ),
            '='
        );

        $searched_fields = array_intersect( array_keys( $custom_filter_fields ), array_keys( $params ) );

        $meta_query = array(
            'relation'  => 'AND'
        );

        foreach ( $searched_fields as $searched_field ) {
            $field_identifier = INVENTOR_LISTING_PREFIX . $searched_field;

            $value = $params[ $searched_field ];

            if( ! empty( $value ) ) {
                $array_meta_query = array(
                    'relation'  => 'AND'
                );

                foreach( $value as $single_value ) {
                    $array_meta_query[] = array(
                        'key'       => $field_identifier,
                        'value'     => serialize( strval( $single_value ) ),
                        'compare'   => 'LIKE'
                    );
                }

                if ( count( $array_meta_query ) > 1 ) {
                    $meta_query[] = $array_meta_query;
                }
            }
        }

        if ( count( $meta_query ) <= 1 ) {
            return $ids;
        }

        $query = new WP_Query( array(
            'post_type'         => Inventor_Post_Types::get_listing_post_types(),
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'meta_query'        => $meta_query
        ) );

        $searched_ids = array();

        if ( $query->post_count > 0 ) {
            foreach( $query->posts as $post ) {
                $searched_ids[] = $post->ID;
            }
        };

        $ids = Inventor_Filter::build_post_ids( $ids, $searched_ids );

        return $ids;
    }
}

Inventor_Fields_Logic::init();