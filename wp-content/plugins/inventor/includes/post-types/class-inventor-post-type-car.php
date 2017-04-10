<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Post_Type_Car
 *
 * @class Inventor_Post_Type_Car
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Car {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
        add_filter( 'inventor_shop_allowed_listing_post_types', array( __CLASS__, 'allowed_purchasing' ) );
        add_filter( 'inventor_claims_allowed_listing_post_types', array( __CLASS__, 'allowed_claiming' ) );
    }

    /**
     * Defines if post type can be claimed
     *
     * @access public
     * @param array $post_types
     * @return array
     */
    public static function allowed_claiming( $post_types ) {
        $post_types[] = 'car';
        return $post_types;
    }

    /**
     * Defines if post type can be purchased
     *
     * @access public
     * @param array $post_types
     * @return array
     */
    public static function allowed_purchasing( $post_types ) {
        $post_types[] = 'car';
        return $post_types;
    }

	/**
	 * Custom post type definition
	 *
	 * @access public
	 * @return void
	 */
	public static function definition() {
		$labels = array(
			'name'                  => __( 'Cars', 'inventor' ),
			'singular_name'         => __( 'Car', 'inventor' ),
			'add_new'               => __( 'Add New Car', 'inventor' ),
			'add_new_item'          => __( 'Add New Car', 'inventor' ),
			'edit_item'             => __( 'Edit Car', 'inventor' ),
			'new_item'              => __( 'New Car', 'inventor' ),
			'all_items'             => __( 'Cars', 'inventor' ),
			'view_item'             => __( 'View Car', 'inventor' ),
			'search_items'          => __( 'Search Car', 'inventor' ),
			'not_found'             => __( 'No Cars found', 'inventor' ),
			'not_found_in_trash'    => __( 'No Cars Found in Trash', 'inventor' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Cars', 'inventor' ),
            'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-car', 'car' )
		);

		register_post_type( 'car',
			array(
				'labels'            => $labels,
				'show_in_menu'	    => 'listings',
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => _x( 'cars', 'URL slug', 'inventor' ) ),
				'public'            => true,
				'show_ui'           => true,
                'show_in_rest'      => true,
				'categories'        => array(),
			)
		);
	}

    /**
     * Metabox for car details
     *
     * @access public
     * @param $post_type
     * @return array
     */
    public static function metabox_car_details( $post_type ) {
        $metabox_id = INVENTOR_LISTING_PREFIX . 'car_details';
        $metabox_title = __( 'Details', 'inventor' );

        $cmb = new_cmb2_box( array(
            'id'            => $metabox_id,
            'title'			=> apply_filters( 'inventor_metabox_title', $metabox_title, $metabox_id, $post_type ),
            'description'   => apply_filters( 'inventor_metabox_description', null, $metabox_id, $post_type ),
            'object_types'  => array( $post_type ),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_in_rest'  => true,
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_engine_type';
        $field_name = __( 'Engine type', 'inventor' );
        $field_type = 'taxonomy_radio';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'car_engine_types',
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_body_style';
        $field_name = __( 'Body style', 'inventor' );
        $field_type = 'taxonomy_multicheck_hierarchy';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'car_body_styles',
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_transmission';
        $field_name = __( 'Transmission', 'inventor' );
        $field_type = 'taxonomy_radio';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'car_transmissions',
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_model';
        $field_name = __( 'Model', 'inventor' );
        $field_type = 'taxonomy_select_hierarchy';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'car_models',
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_year_manufactured';
        $field_name = __( 'Year manufactured', 'inventor' );
        $field_type = 'text';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(
                'type' => 'number',
                'pattern' => '\d*',
            ), $metabox_id, $field_id, $post_type ),
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_mileage';
        $field_name = __( 'Mileage', 'inventor' );
        $field_type = 'text';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(
                'type' => 'number',
                'pattern' => '\d*',
            ), $metabox_id, $field_id, $post_type ),
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_condition';
        $field_name = __( 'Condition', 'inventor' );
        $field_type = 'select';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'options'           => array(
                'NEW'               => __( 'new', 'inventor' ),
                'USED'              => __( 'used', 'inventor' )
            ),
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_leasing';
        $field_name = __( 'Leasing available', 'inventor' );
        $field_type = 'checkbox';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
        ) );
    }

    /**
     * Metabox for car details
     *
     * @access public
     * @param $post_type
     * @return array
     */
    public static function metabox_car_color( $post_type ) {
        $metabox_id = INVENTOR_LISTING_PREFIX . 'car_color';
        $metabox_title = __( 'Color', 'inventor' );

        $cmb = new_cmb2_box( array(
            'id'            => $metabox_id,
            'title'			=> apply_filters( 'inventor_metabox_title', $metabox_title, $metabox_id, $post_type ),
            'description'   => apply_filters( 'inventor_metabox_description', null, $metabox_id, $post_type ),
            'object_types'  => array( $post_type ),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_in_rest'  => true,
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_color_interior';
        $field_name = __( 'Interior color', 'inventor' );
        $field_type = 'taxonomy_multicheck_hierarchy';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'colors',
        ) );

        $field_id = INVENTOR_LISTING_PREFIX  . 'car_color_exterior';
        $field_name = __( 'Exterior color', 'inventor' );
        $field_type = 'taxonomy_multicheck_hierarchy';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'colors',
        ) );
    }

	/**
	 * Defines custom fields
	 *
	 * @access public
	 * @return array
	 */
	public static function fields() {
        Inventor_Post_Types::add_metabox( 'car', array( 'general' ) );
        Inventor_Post_Types::add_metabox( 'car', array( 'Inventor_Post_Type_Car::car_details' ) );
        Inventor_Post_Types::add_metabox( 'car', array( 'Inventor_Post_Type_Car::car_color' ) );
        Inventor_Post_Types::add_metabox( 'car', array( 'banner', 'gallery', 'video', 'price', 'contact', 'social', 'flags', 'location', 'listing_category' ) );
	}
}

Inventor_Post_Type_Car::init();