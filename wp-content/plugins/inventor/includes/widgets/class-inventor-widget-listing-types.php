<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Widget_Listing_Types
 *
 * @class Inventor_Widget_Listing_Types
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Listing_Types extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     */
    function __construct() {
        parent::__construct(
            'listing_types',
            __( 'Listing Types', 'inventor' ),
            array(
                'description' => __( 'Displays listing types.', 'inventor' ),
            )
        );
    }

    /**
     * Frontend
     *
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget( $args, $instance ) {
        $appearance = empty( $instance['appearance'] ) ? 'tabs' : $instance['appearance'];

        $all_listing_types = Inventor_Post_Types::get_listing_post_types( false, true );
        $types_and_labels = $all_listing_types;

        if ( ! empty( $instance['sort'] ) ) {
            $post_types = explode( ',', $instance['sort'] );
            $filtered_keys = array_filter( $post_types );
            $types_and_labels = array_replace( array_flip( $filtered_keys ), $types_and_labels );
        }

        $listing_types = array();

        foreach ( $types_and_labels as $post_type => $label ) {
            $post_type_obj = get_post_type_object( $post_type );

            if ( empty( $instance[ 'show_' . $post_type ] ) ) {
                continue;
            }

            if ( empty( $instance[ 'image_' . $post_type ] ) ) {
                $image = plugins_url( 'inventor' ) . '/assets/img/default-item.png';
            } else {
                $image = esc_attr( $instance[ 'image_' . $post_type ] );
            }

            $listing_types[ $post_type ] = array(
                'label' => esc_attr( $post_type_obj->label ),
                'image' => $image,
                'color' => $instance[ 'color_' . $post_type ],
                'icon'  => Inventor_Post_Types::get_icon( $post_type, false ),
                'url'   => get_post_type_archive_link( $post_type ),
            );

            if ( ! empty( $instance['show_count'] ) ) {
                $listing_types[ $post_type ]['count'] = Inventor_Post_Types::count_posts( $post_type );
            }
        }

        if ( 'cards' == $appearance ) {
            include Inventor_Template_Loader::locate( 'widgets/listing-types-cards' );
        }
    }

    /**
     * Update
     *
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    /**
     * Backend
     *
     * @access public
     * @param array $instance
     * @return void
     */
    function form( $instance ) {
        include Inventor_Template_Loader::locate( 'widgets/listing-types-admin' );
        include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
        include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
    }
}