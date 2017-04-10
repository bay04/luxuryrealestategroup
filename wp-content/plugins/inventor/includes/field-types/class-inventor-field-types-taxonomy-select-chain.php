<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Field_Types_Taxonomy_Select_Chain
 *
 * @access public
 * @package Inventor/Classes/Field_Types
 * @return void
 */
class Inventor_Field_Types_Taxonomy_Select_Chain {
    /**
     * Initialize the plugin by hooking into CMB2
     */
    public function __construct() {
        $this->constants();
        add_filter( 'cmb2_render_taxonomy_select_chain', array( $this, 'render' ), 10, 5 );
        add_filter( 'cmb2_sanitize_taxonomy_select_chain', array( $this, 'sanitize' ), 10, 5 );
        add_action( 'wp_ajax_nopriv_inventor_field_taxonomy_select_chain_options', array( $this, 'ajax_options' ) );
        add_action( 'wp_ajax_inventor_field_taxonomy_select_chain_options', array( $this, 'ajax_options' ) );
    }

    /**
     * Defines constants
     *
     * @access public
     * @return void
     */
    public function constants() {
        define( 'INVENTOR_FIELD_TYPE_TAXONOMY_SELECT_CHAIN_DEPTH', 3 );
    }

    /**
     * Render field
     *
     * @access public
     * @param $field
     * @param $field_escaped_value
     * @param $field_object_id
     * @param $field_object_type
     * @param $field_type_object
     * @return string
     */
    public function render( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
        $real_field_type_object = class_exists( 'CMB2_Type_Taxonomy_Select' ) ? new CMB2_Type_Taxonomy_Select( $field_type_object ) : $field_type_object;

        $ajax_url = admin_url( 'admin-ajax.php' );
        $field_id = $field->args['id'];
        $taxonomy = $field_type_object->field->args( 'taxonomy' );

        $names       = $real_field_type_object->get_object_terms();
        $saved_terms = is_wp_error( $names ) || empty( $names )
            ? $field_type_object->field->get_default()
            : wp_list_pluck( $names, 'slug' );

        $terms_query_args = array(
            'hide_empty'    => false,
            'parent'        => 0,
        );

        $post_type = empty( $field->args['post_type'] ) ? null : $field->args['post_type'];

        if ( ! empty( $post_type ) ) {
            // TODO: check if field is listing_category or probably move to another file
            $terms_query_args['meta_query'] = array(
                'relation' => 'OR',
                array(
                    'key' => INVENTOR_LISTING_CATEGORY_PREFIX . 'listing_types',
                    'compare' => 'NOT EXISTS',
                ),
                array(
                    'key'       => INVENTOR_LISTING_CATEGORY_PREFIX . 'listing_types',
                    'value'     => serialize( strval( $post_type ) ),
                    'compare'   => 'LIKE'
                )
            );
        }

        $terms       = get_terms( $taxonomy, $terms_query_args );

        $name        = $field_type_object->_name();
        $options     = '<option value="">-</option>';

        if ( ! $terms ) {
            $options .= sprintf( '<li><label>%s</label></li>', esc_html($field_type_object->_text( 'no_terms_text', __( 'No terms', 'inventor' ) ) ) );
        } else {
            foreach ( $terms as $term ) {

                $args = array(
                    'value' => $term->slug,
                    'label' => $term->name,
                    'name' => $name,
                );

                if ( is_array( $saved_terms ) && in_array( $term->slug, $saved_terms ) ) {
                    $args['checked'] = 'checked';
                }

                $options .= $real_field_type_object->select_option( $args );
            }
        }

        echo $field_type_object->select( array(
            'name'    => $field_id . '[]',
            'class'   => 'cmb2_select cmb2-taxonomy-select-chain-parent',
            'options' => $options,
        ) );

        $depth_size = apply_filters( 'inventor_field_type_taxonomy_select_chain_depth', INVENTOR_FIELD_TYPE_TAXONOMY_SELECT_CHAIN_DEPTH );

        try {
            $attributes = $field_type_object->field->args['attributes'];
            $depth_size = empty( $attributes['chain_depth'] ) ? $depth_size : esc_attr( $attributes['chain_depth'] );
        } catch (Exception $e) {
        }

        for ( $depth = 0; $depth < ( $depth_size - 1 ); $depth++ ) {
            $child_id = $field_id . '-' . ($depth + 1);
            $parent_id = $depth == 0 ? $field_id : $field_id . '-' . $depth;

            echo $field_type_object->select( array(
                'name'                => $field_id . '[]',
                'id'                  => $child_id,
                'class'               => 'cmb2_select cmb2-taxonomy-select-chain-child',
                'data-ajax-url'       => $ajax_url,
                'data-ajax-action'    => 'inventor_field_taxonomy_select_chain_options',
                'data-parent'         => $parent_id,
                'data-taxonomy'       => $taxonomy,
                'data-selected'       => is_array( $saved_terms ) ? join( ',', $saved_terms ) : ''
            ) );
        }
    }

    /**
     * Save proper values
     *
     * @access public
     * @param $override_value
     * @param $value
     * @param $object_id
     * @param $field_args
     * @return void
     */
    public function sanitize( $override_value, $value, $object_id, $field_args ) {
        $taxonomy = $field_args['taxonomy'];
        wp_set_object_terms( $object_id, $value, $taxonomy );
    }

    /**
     * Get children terms via ajax
     *
     * @access public
     * @return string
     */
    public function ajax_options() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        $data = array(
            "" => "--",
        );

        $selected_terms = array();

        if( ! empty( $_GET['selected'] ) ) {
            $selected_terms = explode( ',', $_GET['selected'] );
        }

        $taxonomy = $_GET['taxonomy'];
        $parent_term_slugs = $_GET[ $_GET['value_param'] ];
        $parent_term_slug = count( $parent_term_slugs ) > 0 ? $parent_term_slugs[0] : null;
        $parent_term = get_term_by( 'slug', $parent_term_slug, $taxonomy );

        if( ! empty( $parent_term_slug ) ) {
            $terms = get_terms( $taxonomy, array(
                'hide_empty'    => false,
                'parent'        => $parent_term->term_id,
            ) );

            if ( ! empty( $terms ) && is_array( $terms ) ) {
                foreach( $terms as $term ) {
                    $data[ $term->slug ] = $term->name;

                    if ( in_array( $term->slug, $selected_terms ) ) {
                        $data['selected'] = $term->slug;
                    }
                }
            }
        }

        $data = json_encode( $data );
        echo $data;
        exit();
    }
}

new Inventor_Field_Types_Taxonomy_Select_Chain();

