<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Post_Type_Dating
 *
 * @class Inventor_Post_Type_Dating
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_Dating {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
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
        $post_types[] = 'dating';
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
			'name'                  => __( 'Datings', 'inventor' ),
			'singular_name'         => __( 'Dating', 'inventor' ),
			'add_new'               => __( 'Add New Dating', 'inventor' ),
			'add_new_item'          => __( 'Add New Dating', 'inventor' ),
			'edit_item'             => __( 'Edit Dating', 'inventor' ),
			'new_item'              => __( 'New Dating', 'inventor' ),
			'all_items'             => __( 'Datings', 'inventor' ),
			'view_item'             => __( 'View Dating', 'inventor' ),
			'search_items'          => __( 'Search Dating', 'inventor' ),
			'not_found'             => __( 'No Datings found', 'inventor' ),
			'not_found_in_trash'    => __( 'No Datings Found in Trash', 'inventor' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Datings', 'inventor' ),
            'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-heart', 'dating' )
		);

		register_post_type( 'dating',
			array(
				'labels'            => $labels,
				'show_in_menu'	    => 'listings',
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => _x( 'datings', 'URL slug', 'inventor' ) ),
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
        Inventor_Post_Types::add_metabox( 'dating', array( 'general' ) );

        $post_type = 'dating';

        $metabox_id = INVENTOR_LISTING_PREFIX . 'dating_details';
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


        $field_id = INVENTOR_LISTING_PREFIX  . 'dating_group';
        $field_name = __( 'Dating groups', 'inventor' );
        $field_type = 'taxonomy_multicheck_hierarchy';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'dating_groups',
        ) );


        $field_id = INVENTOR_LISTING_PREFIX  . 'dating_gender';
        $field_name = __( 'Gender', 'inventor' );
        $field_type = 'radio_inline';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'options'           => array(
                'MALE'              => __( 'Male', 'inventor' ),
                'FEMALE'            => __( 'Female', 'inventor' ),
            ),
        ) );


        $field_id = INVENTOR_LISTING_PREFIX  . 'dating_age';
        $field_name = __( 'Age', 'inventor' );
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


        $field_id = INVENTOR_LISTING_PREFIX  . 'weight';
        $field_name = __( 'Weight', 'inventor' );
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


        $field_id = INVENTOR_LISTING_PREFIX  . 'dating_status';
        $field_name = __( 'Status', 'inventor' );
        $field_type = 'taxonomy_radio';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'dating_statuses',
        ) );


        $field_id = INVENTOR_LISTING_PREFIX  . 'dating_eye_color';
        $field_name = __( 'Eye color', 'inventor' );
        $field_type = 'taxonomy_radio';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'colors',
        ) );


        $field_id = INVENTOR_LISTING_PREFIX  . 'dating_interest';
        $field_name = __( 'Interests', 'inventor' );
        $field_type = 'taxonomy_multicheck_hierarchy';

        $cmb->add_field( array(
            'id'                => $field_id,
            'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
            'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
            'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
            'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
            'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
            'taxonomy'          => 'dating_interests',
        ) );


		Inventor_Post_Types::add_metabox( 'dating', array( 'gallery', 'banner', 'video', 'contact', 'social', 'flags', 'location', 'listing_category' ) );
	}
}

Inventor_Post_Type_Dating::init();