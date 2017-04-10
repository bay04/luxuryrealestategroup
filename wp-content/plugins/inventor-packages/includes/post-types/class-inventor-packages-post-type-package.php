<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Packages_Post_Type_Package
 *
 * @class Inventor_Packages_Post_Type_Package
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Packages_Post_Type_Package {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );

        // package has to be registered before listing types because permission message is appended to their metabox descriptions
        add_filter( 'cmb2_init', array( __CLASS__, 'fields' ), 9 );

        add_filter( 'manage_edit-package_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_package_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Packages', 'inventor-packages' ),
            'singular_name'         => __( 'Package', 'inventor-packages' ),
            'add_new'               => __( 'Add New Package', 'inventor-packages' ),
            'add_new_item'          => __( 'Add New Package', 'inventor-packages' ),
            'edit_item'             => __( 'Edit Package', 'inventor-packages' ),
            'new_item'              => __( 'New Package', 'inventor-packages' ),
            'all_items'             => __( 'Packages', 'inventor-packages' ),
            'view_item'             => __( 'View Package', 'inventor-packages' ),
            'search_items'          => __( 'Search Package', 'inventor-packages' ),
            'not_found'             => __( 'No Packages found', 'inventor-packages' ),
            'not_found_in_trash'    => __( 'No Packages Found in Trash', 'inventor-packages' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Packages', 'inventor-packages' ),
        );

        register_post_type( 'package',
            array(
                'labels'            => $labels,
                'show_in_menu'      => class_exists( 'Inventor_Admin_Menu') ? 'inventor' : true,
                'supports'          => array( 'title' ),
                'public'            => false,
                'has_archive'       => false,
                'show_ui'           => true,
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
        $durations = Inventor_Packages_Logic::get_package_durations( true );

        $general = new_cmb2_box( array(
            'id'                        => INVENTOR_PACKAGE_PREFIX . 'general',
            'title'                     => __( 'General', 'inventor-packages' ),
            'object_types'              => array( 'package' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
        ) );

        $general->add_field( array(
            'id'                => INVENTOR_PACKAGE_PREFIX . 'price',
            'name'              => __( 'Price', 'inventor-packages' ),
            'type'              => 'text_money',
            'before_field'      => Inventor_Price::default_currency_symbol(),
            'description'       => sprintf( __( 'In %s.', 'inventor-packages' ), Inventor_Price::default_currency_code() ),
            'sanitization_cb'   => false,
            'attributes'		=> array(
                'type'				=>	'number',
                'step'				=> 	'any',
                'min'				=> 	0,
                'pattern'			=> 	'\d*(\.\d*)?',
            )
        ) );

        $general->add_field( array(
            'id'                => INVENTOR_PACKAGE_PREFIX . 'duration',
            'name'              => __( 'Duration', 'inventor-packages' ),
            'type'              => 'select',
            'options'           => $durations,
        ) );

        $general->add_field( array(
            'id'                => INVENTOR_PACKAGE_PREFIX . 'max_listings',
            'name'              => __( 'Max Listings', 'inventor-packages' ),
            'type'              => 'text_small',
            'description'       => __( "If submission type is 'packages'. Use -1 for unlimited amount of listings.", 'inventor-packages' ),
            'attributes'		=> array(
                'type'				=>	'number',
                'min'				=> 	-1,
                'pattern'			=> 	'\d*',
            )
        ) );

        $general->add_field( array(
            'id'                => INVENTOR_PACKAGE_PREFIX . 'max_categories',
            'name'              => __( 'Max Categories', 'inventor-packages' ),
            'description'       => __( 'Per listing. Keep blank for unlimited', 'inventor-packages' ),
            'type'              => 'text_small',
            'attributes'		=> array(
                'type'				=>	'number',
                'min'				=> 	-1,
                'pattern'			=> 	'\d*',
            )
        ) );

        $general->add_field( array(
            'id'                => INVENTOR_PACKAGE_PREFIX . 'private',
            'name'              => __( 'Private', 'inventor-packages' ),
            'type'              => 'checkbox',
            'description'       => __( "If checked, package won't be visible in the pricing. Suitable for VIP users or admins.", 'inventor-packages' ),
        ) );

        $permissions = new_cmb2_box( array(
            'id'                        => INVENTOR_PACKAGE_PREFIX . 'metabox_permissions',
            'title'                     => __( 'Permissions', 'inventor-packages' ),
            'object_types'              => array( 'package' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
        ) );

        $metabox_permissions = array(
            'video'         => __( 'Video', 'inventor-packages' ),
            'gallery'       => __( 'Gallery', 'inventor-packages' ),
            'reviews'       => __( 'Reviews', 'inventor-packages' ),  // TODO: move to inventor-reviews plugin
            'location'      => __( 'Location', 'inventor-packages' ),
//            'bookings'      => __( 'Bookings', 'inventor-packages' ),  // TODO: move to inventor-bookings plugin
            'opening_hours' => __( 'Opening hours', 'inventor-packages' ),
            'contact'       => __( 'Contact', 'inventor-packages' ),
        );

        $metabox_permissions = apply_filters( 'inventor_packages_metabox_permissions', $metabox_permissions );

        foreach( $metabox_permissions as $metabox => $label ) {
            $field_id = INVENTOR_PACKAGE_PREFIX . 'metabox_' . $metabox . '_allowed';

            $permissions->add_field( array(
                'id'                => $field_id,
                'name'              => $label,
                'type'              => 'checkbox',
            ) );
        }

        $restrictions = new_cmb2_box( array(
            'id'                        => INVENTOR_PACKAGE_PREFIX . 'listing_types_restrictions',
            'title'                     => __( 'Listing types restrictions', 'inventor-packages' ),
            'object_types'              => array( 'package' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
        ) );

        $restrictions->add_field( array(
            'id'                => INVENTOR_PACKAGE_PREFIX . 'listing_types_restriction',
            'name'              => __( 'Use restriction', 'inventor-packages' ),
            'type'              => 'checkbox',
        ) );

        $restrictions->add_field( array(
            'id'                => INVENTOR_PACKAGE_PREFIX . 'listing_types_allowed',
            'name'              => __( 'Listing types', 'inventor-packages' ),
            'type'              => 'multicheck',
            'select_all_button' => false,
            'options'           => Inventor_Post_Types::get_listing_post_types( false, true ),
            'default'           => array()
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
            'title' 			=> __( 'Title', 'inventor-packages' ),
            'price' 			=> __( 'Price', 'inventor-packages' ),
            'duration' 		    => __( 'Duration', 'inventor-packages' ),
            'max_listings' 		=> __( 'Max Listings', 'inventor-packages' ),
            'max_categories'    => __( 'Max Categories', 'inventor-packages' ),
            'type' 			    => __( 'Type', 'inventor-packages' ),
            'private'    		=> __( 'Private', 'inventor-packages' ),
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
            case 'price':
                $price = get_post_meta( get_the_ID(), INVENTOR_PACKAGE_PREFIX . 'price', true );

                if ( ! empty( $price ) ) {
                    $price_formatted = Inventor_Packages_Logic::get_package_formatted_price( get_the_ID() );
                    echo $price_formatted;
                } else {
                    echo '-';
                }
                break;

            case 'duration':
                $duration = get_post_meta( get_the_ID(), INVENTOR_PACKAGE_PREFIX . 'duration', true );

                if ( ! empty( $duration ) ) {
                    echo $duration;
                } else {
                    echo '-';
                }
                break;

            case 'max_listings':
                $max_listings = get_post_meta( get_the_ID(), INVENTOR_PACKAGE_PREFIX . 'max_listings', true );

                if ( ! empty( $max_listings ) ) {
                    echo $max_listings;
                } else {
                    echo '-';
                }
                break;

            case 'max_categories':
                $max_categories = get_post_meta( get_the_ID(), INVENTOR_PACKAGE_PREFIX . 'max_categories', true );

                if ( ! empty( $max_categories ) ) {
                    echo $max_categories;
                } else {
                    echo '-';
                }
                break;

            case 'private':
                $is_private = get_post_meta( get_the_ID(), INVENTOR_PACKAGE_PREFIX . 'private', true );
                echo $is_private ? __( 'Yes', 'inventor-packages' ) : __( 'No', 'inventor-packages' );
                break;

            case 'type':
                if ( Inventor_Packages_Logic::is_package_free( get_the_ID() ) ) {
                    echo __( 'free', 'inventor-packages' );
                } elseif ( Inventor_Packages_Logic::is_package_regular( get_the_ID() ) ) {
                    echo __( 'regular', 'inventor-packages' );
                } elseif ( Inventor_Packages_Logic::is_package_simple( get_the_ID() ) ) {
                    echo __( 'simple', 'inventor-packages' );
                } elseif ( Inventor_Packages_Logic::is_package_trial( get_the_ID() ) ) {
                    echo __( 'trial', 'inventor-packages' );
                }
                break;
        }
    }
}

Inventor_Packages_Post_Type_Package::init();