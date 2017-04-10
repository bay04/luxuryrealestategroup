<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Metaboxes
 *
 * @class Inventor_Metaboxes
 * @package Inventor/Classes/Metaboxes
 * @author Pragmatic Mates
 */
class Inventor_Metaboxes {
	/**
	 * Initialize metaboxes
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'inventor_metabox_social_networks', array( __CLASS__, 'social_networks' ) );
		add_filter( 'inventor_metabox_banner_types', array( __CLASS__, 'banner_types' ) );
		add_filter( 'inventor_metabox_field_enabled', array( __CLASS__, 'disable_banner_type_fields' ), 10, 4 );
		add_filter( 'inventor_social_network_url', array( __CLASS__, 'social_network_url' ), 10, 2 );
	}

	/**
	 * Returns list of metaboxes available for given post type
	 *
	 * @access public
	 * @param $post_type
	 * @return array
	 */
	public static function get_for_post_type( $post_type ) {
		$post_types = is_array( $post_type ) ? $post_type : array( $post_type );

		if ( version_compare ( phpversion(), '5.3.0', '>=' ) ) {
			return array_filter( CMB2_Boxes::get_all(), function( $meta_box ) use( $post_types ) {
				$intersection = array_intersect( $post_types, $meta_box->meta_box['object_types'] );
				return ! empty( $intersection );
			} );
		} else {
			$result = array();

			foreach ( CMB2_Boxes::get_all() as $meta_box ) {
				$intersection = array_intersect( $post_types, $meta_box->meta_box['object_types'] );
				if ( ! empty( $intersection ) ) {
					$result[] = $meta_box;
				}
			}

			return $result;
		}
	}

	/**
	 * Returns list of default social networks
	 *
	 * @access public
	 * @return array
	 */
	public static function social_networks() {
		return array(
			'facebook' 		=> 'Facebook',
			'twitter' 		=> 'Twitter',
			'google' 		=> 'Google+',
			'instagram' 	=> 'Instagram',
			'vimeo' 		=> 'Vimeo',
			'youtube' 		=> 'YouTube',
			'linkedin' 		=> 'LinkedIn',
			'dribbble' 		=> 'Dribbble',
			'skype' 		=> 'Skype',
			'foursquare' 	=> 'Foursquare',
			'behance' 		=> 'Behance',
		);
	}

	/**
	 * Hides banner type fields which are disabled
	 *
	 * @access public
	 * @param $enabled
	 * @param $metabox_id
	 * @param $field_id
	 * @param $post_type
	 * @return bool
	 */
	public static function disable_banner_type_fields( $enabled, $metabox_id, $field_id, $post_type ) {
		if ( $metabox_id != INVENTOR_LISTING_PREFIX . $post_type . '_banner' ) {
			return $enabled;
		}

		$banner_type = str_replace( INVENTOR_LISTING_PREFIX, '', $field_id );
		return self::is_banner_type_enabled( $banner_type );
	}

	/**
	 * Modifies social network URL
	 *
	 * @access public
	 * @param $value
	 * @param $key
	 * @return string
	 */
	public static function social_network_url( $value, $key ) {
		if ( $key == 'skype' ) {
			return sprintf( 'skype:%s?call', $value );
		}

		if ( $key == 'facebook' && strpos( $value, 'http' ) === false ) {
			return sprintf( 'https://facebook.com/%s', $value );
		}

		if ( $key == 'google' && strpos( $value, 'http' ) === false ) {
			return sprintf( 'https://plus.google.com/+%s', $value );
		}

		if ( $key == 'twitter' && strpos( $value, 'http' ) === false ) {
			return sprintf( 'https://twitter.com/%s', $value );
		}

		if ( $key == 'instagram' && strpos( $value, 'http' ) === false ) {
			return sprintf( 'https://instagram.com/%s', $value );
		}

		return $value;
	}

	/**
	 * Checks if banner type is enabled
	 *
	 * @access public
	 * @param $banner_type
	 * @return bool
	 */
	public static function is_banner_type_enabled( $banner_type ) {
		$enabled_banner_types = self::enabled_banner_types( true );
		return in_array( $banner_type, $enabled_banner_types );
	}

	/**
	 * Returns list of all defined banner types
	 *
	 * @access public
	 * @return array
	 */
	public static function banner_types() {
		$types = array(
			'banner_simple' 		=> __( 'Simple', 'inventor' ),
			'banner_featured_image' => __( 'Featured Image', 'inventor' ),
			'banner_image'          => __( 'Custom Image', 'inventor' ),
			'banner_video'          => __( 'Video', 'inventor' ),
		);

		if ( class_exists( 'Inventor_Google_Map') ) {
			if ( apply_filters( 'inventor_metabox_field_enabled', true, null, INVENTOR_LISTING_PREFIX  . 'map_location', 'listing' ) ) {
				$types['banner_map'] = __( 'Google Map', 'inventor' );
			}

			if ( apply_filters( 'inventor_metabox_field_enabled', true, null, INVENTOR_LISTING_PREFIX  . 'street_view', 'listing' ) ) {
				$types['banner_street_view'] = __( 'Google Street View', 'inventor' );
			}

			if ( apply_filters( 'inventor_metabox_field_enabled', true, null, INVENTOR_LISTING_PREFIX  . 'inside_view', 'listing' ) ) {
				$types['banner_inside_view'] = __( 'Google Inside View', 'inventor' );
			}
		}

		return $types;
	}

	/**
	 * Returns enabled banner types
	 *
	 * @access public
	 * @param bool $keys_only
	 * @return array
	 */
	public static function enabled_banner_types( $keys_only = False ) {
		$all_banner_types = apply_filters( 'inventor_metabox_banner_types', array() );
		$enabled_banner_types_keys = get_theme_mod( 'inventor_general_banner_types', array_keys( $all_banner_types ) );

		if ( $keys_only ) {
			return $enabled_banner_types_keys;
		}

		$enabled_banner_types = array_intersect_key( $all_banner_types, array_flip( $enabled_banner_types_keys ) );
		return $enabled_banner_types;
	}

	/**
	 * Returns metabox key from its id by removing listing and post type prefixes
	 *
	 * @access public
	 * @param string $metabox_id
	 * @param string $post_type
	 * @return string
	 */
	public static function get_metabox_key( $metabox_id, $post_type ) {
		$parts = explode( '_', $metabox_id );

		if ( strpos( $metabox_id, $post_type ) === strlen( $parts[0] ) + 1 ) {
			unset($parts[0]); // unset listing
			unset($parts[1]); // unset post type

			$metabox_key = implode('_', $parts); // the rest is metabox key
			return $metabox_key;
		}

		return $metabox_id;
	}

	/**
	 * Returns metabox id from its key by adding listing and post type prefixes
	 *
	 * @access public
	 * @param string $metabox_key
	 * @param string $post_type
	 * @return string
	 */
	public static function get_metabox_id( $metabox_key, $post_type ) {
		return INVENTOR_LISTING_PREFIX . $post_type . '_' . $metabox_key;
	}

	/**
	 * General fields
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_general( $post_type ) {
		if ( is_admin() ) {
			return;
		}

		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_general';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'General', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'General information about the listing. Enter its title, description and featured image.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'          => true,
			'show_in_rest'  => true,
		) );

		// Title
		$field_id = INVENTOR_LISTING_PREFIX  . 'title';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __( 'Title', 'inventor' );
			$cmb->add_field( array(
				'id'                => $field_id,
				'type'              => 'text',
				'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'attributes' 		=> apply_filters( 'inventor_metabox_field_attributes', array( 'required' => 'required' ), $metabox_id, $field_id, $post_type ),
				'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			) );
		}

		// Description
		$field_id = INVENTOR_LISTING_PREFIX  . 'description';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __( 'Description', 'inventor' );
			$cmb->add_field( array(
				'id'                => $field_id,
				'type'              => 'wysiwyg',
				'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 		=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'options'           => array(
					'textarea_rows' => 10,
					'media_buttons' => false,
				),
			) );
		}

		// Featured image
		$field_id = INVENTOR_LISTING_PREFIX  . 'featured_image';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __( 'Featured Image', 'inventor' );
			$cmb->add_field( array(
				'id'                => $field_id,
				'type'              => 'file',
				'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 		=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
			) );
		}
	}

	/**
	 * FAQ
	 *
	 * @access public
	 * @return array
	 */
	public static function metabox_faq( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_faq';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'FAQ', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'List of most frequently asked questions.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'          => true,
			'show_in_rest'  => true,
		) );

		if ( ! is_admin() ) {
			add_filter('cmb2_override_listing_faq_group_meta_value', array( __CLASS__, 'set_default_value' ) , 0, 4);
		}

		$default = apply_filters( 'inventor_metabox_field_default', null, $metabox_id, INVENTOR_LISTING_PREFIX . 'faq', $post_type );

		$field_id = INVENTOR_LISTING_PREFIX . 'faq';
		$group = $cmb->add_field( array(
			'id'          	=> $field_id,
			'type'        	=> 'group',
			'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'post_type'   	=> $post_type,
			'repeatable'  	=> true,
			'custom_value'	=> $default,
			'options'     	=> array(
				'group_title'   => __( 'FAQ', 'inventor' ),
				'add_button'    => __( 'Add Another FAQ', 'inventor' ),
				'remove_button' => __( 'Remove FAQ', 'inventor' ),
			),
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'question';
		$cmb->add_group_field( $group, array(
			'id'            => $field_id,
			'type'          => 'text',
			'name'          => __( 'Question', 'inventor' ),
			'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
			'custom_value'	=> $default
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'answer';
		$cmb->add_group_field( $group, array(
			'id'            => $field_id,
			'type'          => 'textarea',
			'name'          => __( 'Answer', 'inventor' ),
			'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type),
			'custom_value'	=> $default
		) );
	}


	/**
	 * Branding
	 *
	 * @access public
	 * @return array
	 */
	public static function metabox_branding( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_branding';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Branding', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Specific listing details like logo, slogan or its own color.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX  . 'slogan';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __( 'Slogan', 'inventor' );

			$cmb->add_field( array(
				'id'                => $field_id,
				'type'              => 'text',
				'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 		=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX  . 'brand_color';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Brand color', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'colorpicker',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters('inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters('inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX  . 'logo';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Logo', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'file',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'skip' 			=> true,
			) );
		}
	}

	/**
	 * Banner
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_banner( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_banner';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Banner', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Choose banner type which will be displayed in the listing detail page.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'          => true,
			'show_in_rest'  => true,
		) );

		// Banner Type
		$submission_banner_type = apply_filters( 'inventor_metabox_field_default', null, $metabox_id, INVENTOR_LISTING_PREFIX . 'banner', $post_type );
		$default_type = empty( $submission_banner_type ) ? get_theme_mod( 'inventor_general_default_banner_type', 'banner_featured_image' ) : $submission_banner_type;
		$field_id = INVENTOR_LISTING_PREFIX  . 'banner';

		$description = '';

		if ( self::is_banner_type_enabled( 'banner_map' ) ) {
			$description .= "<span class='banner-map'>" . __( 'To set map position go to section <strong>Location</strong>.', 'inventor' ) . "</span>";
		}

		if ( self::is_banner_type_enabled( 'banner_street_view' ) ) {
			$description .= "<span class='banner-street-view'>" . __( 'To set Street View go to section <strong>Location</strong>. Do not forget to <strong>enable</strong> Street View.', 'inventor' ) . "</span>";
		}

		if ( self::is_banner_type_enabled( 'banner_inside_view' ) ) {
			$description .= "<span class='banner-inside-view'>" . __( 'To set Inside View go to section <strong>Location</strong>. Do not forget to <strong>enable</strong> Inside View.', 'inventor' ) . "</span>";
		}

		$field_name = __( 'Banner Type', 'inventor' );
		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'radio',
			'default'           => $default_type,
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'       => apply_filters( 'inventor_metabox_field_description', $description, $metabox_id, $field_id, $post_type ),
			'options'           => Inventor_Metaboxes::enabled_banner_types(),
			'row_classes'       => 'cmb-row-banner banner-type',
			'skip'              => true,
		) );

		// Custom Image
		$field_id = INVENTOR_LISTING_PREFIX  . 'banner_image';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Custom Image', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type'			=> 'file',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', __( 'Upload an image.', 'inventor' ), $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'row_classes' 	=> 'cmb-row-banner banner-image'
			) );
		}

		// Video
		$field_id = INVENTOR_LISTING_PREFIX  . 'banner_video';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Video file', 'inventor');
			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'file',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', __( 'Upload video file in .mp4 format.', 'inventor' ), $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type),
				'row_classes' 	=> 'cmb-row-banner banner-video'
			) );

            $field_id = INVENTOR_LISTING_PREFIX . 'banner_video_embed';
            $field_name = __('Video embed', 'inventor');

            $cmb->add_field( array(
                'id' 			=> $field_id,
                'type' 			=> 'oembed',
                'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
                'description'   => apply_filters( 'inventor_metabox_field_description', __( 'Enter a YouTube or Vimeo URL.', 'inventor' ), $metabox_id, $field_id, $post_type ),
                'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
                'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
                'row_classes' 	=> 'cmb-row-banner banner-video'
            ) );
		}

		if ( self::is_banner_type_enabled( 'banner_map' ) && apply_filters( 'inventor_metabox_field_enabled', true, null, INVENTOR_LISTING_PREFIX  . 'map_location', $post_type ) ) {
			// Google Map
			$field_id = INVENTOR_LISTING_PREFIX . 'banner_map_zoom';
			$field_name = __('Zoom', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'text_small',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', 12, $metabox_id, $field_id, $post_type),
				'description'   => apply_filters( 'inventor_metabox_field_description', __('Minimum value of zoom is 0. Maximum value depends on location (12-25).', 'inventor'), $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(
					'type' 			=> 'number',
					'min' 			=> 0,
					'max' 			=> 25,
				), $metabox_id, $field_id, $post_type ),
				'row_classes' 	=> 'cmb-row-banner banner-map'
			) );

			$field_id = INVENTOR_LISTING_PREFIX . 'banner_map_type';
			$field_name = __('Map Type', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'select',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'options' 		=> array(
					'ROADMAP' 		=> __( 'Roadmap', 'inventor' ),
					'SATELLITE' 	=> __( 'Satellite', 'inventor' ),
					'HYBRID' 		=> __( 'Hybrid', 'inventor' ),
				),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', 'SATELLITE', $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'row_classes' 	=> 'cmb-row-banner banner-map'
			) );

			$field_id = INVENTOR_LISTING_PREFIX . 'banner_map_marker';
			$field_name = __('Marker', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'checkbox',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', __( 'Check to show marker.', 'inventor' ), $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', false, $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'row_classes' 	=> 'cmb-row-banner banner-map'
			) );
		}
	}

	/**
	 * Gallery meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_gallery( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_gallery';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Gallery', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Upload some photos into listing gallery.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'          => true,
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX  . 'gallery';
		$field_name = __( 'Gallery', 'inventor' );

		$cmb->add_field( array(
			'id'            => $field_id,
			'type'          => 'file_list',
			'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'       => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
		) );
	}

	/**
	 * Color meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_color( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_color';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Color', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Listing color definition.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX  . 'color';
		$field_name = __( 'Color', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'taxonomy_multicheck_hierarchy',
			'taxonomy'          => 'colors',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'        => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Video meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_video( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_video';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Video', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'If you wish, you can enter listing video URL here.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'          => true,
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'video';
		$field_name = __( 'URL', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_url',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'       => apply_filters( 'inventor_metabox_field_description', __( 'For more information about embeding videos and video links support please read this <a href="http://codex.wordpress.org/Embeds">article</a>.', 'inventor' ), $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'        => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Listing category meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_listing_category( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_listing_category';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Listing categories', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Assign listing into category. It will help users to find it.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX  . 'listing_category';
		$field_name = __( 'Listing categories', 'inventor' );
		$field_type = 'taxonomy_multicheck_hierarchy';

		$cmb->add_field( array(
			'id'                => $field_id,
			'post_type'			=> $post_type,
			'taxonomy'          => 'listing_categories',
			'select_all_button'	=> false,
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'        => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
			'before_row'        => apply_filters( 'inventor_metabox_field_before_row', null, $metabox_id, $field_id, $post_type ),
			'before'        	=> apply_filters( 'inventor_metabox_field_before', null, $metabox_id, $field_id, $post_type ),
			'before_field'      => apply_filters( 'inventor_metabox_field_before_field', null, $metabox_id, $field_id, $post_type ),
			'after_field'       => apply_filters( 'inventor_metabox_field_after_field', null, $metabox_id, $field_id, $post_type ),
			'after'        		=> apply_filters( 'inventor_metabox_field_after', null, $metabox_id, $field_id, $post_type ),
			'after_row'		    => apply_filters( 'inventor_metabox_field_after_row', null, $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Opening hours meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_opening_hours( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_opening_hours';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Opening Hours', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Let people know when it is open.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'          => true,
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'opening_hours';
		$cmb->add_field( array(
			'id'          	=> $field_id,
			'type'        	=> 'opening_hours',
			'post_type'   	=> $post_type,
			'escape_cb'		=> array( 'Inventor_Field_Types_Opening_Hours', 'escape' ),
			'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'       => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Set default data for field
	 *
	 * @access public
	 * @param $data
	 * @param $object_id
	 * @param $a
	 * @param $field
	 * @return mixed
	 */
	public static function set_default_value( $data, $object_id, $a, $field ) {
		if ( ! empty( $field->args['custom_value'] ) ) {
			return $field->args['custom_value'];
		}

		return $data;
	}

	/**
	 * Contact meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_contact( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_contact';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Contact', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Enter some details how can people reach the listing.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'			=> true,
			'show_in_rest'  => true
		) );

		$field_id = INVENTOR_LISTING_PREFIX  . 'email';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('E-mail', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'text_email',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX  . 'phone';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Phone', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'text_medium',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes'	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX  . 'website';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Website', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'text_url',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX  . 'person';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Person', 'inventor');
			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type'			=> 'text_medium',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX  . 'address';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Address', 'inventor');
			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'textarea_small',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes' 	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type )
			) );
		}
	}

	/**
	 * Social meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_social( $post_type ) {
		$social_networks = apply_filters( 'inventor_metabox_social_networks', array(), $post_type );

		if ( count( $social_networks ) == 0 ) {
			return;
		}

		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_social';

		$social = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Social', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Connections to social networks.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'			=> true,
			'show_in_rest'  => true,
		) );

		foreach( $social_networks as $key => $title ) {
			$field_id = INVENTOR_LISTING_PREFIX . $key;
			if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
				$field_name = $title;

				$social->add_field(array(
					'id' 			=> $field_id,
					'type' 			=> 'text_medium',
					'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
					'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
					'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
					'attributes'    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				) );
			}
		}
	}

	/**
	 * Price meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_price( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_price';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Price', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Define listing price here.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'skip'          => true,
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX  . 'price';
		$field_name = __( 'Price', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_money',
			'sanitization_cb'	=> false,
			'before_field'      => Inventor_Price::default_currency_symbol(),
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', sprintf( __( 'In %s.', 'inventor' ), Inventor_Price::default_currency_code() ), $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'		=> apply_filters( 'inventor_metabox_field_attributes', array(
				'type'				=> 'number',
				'step'				=> 'any',
				'min'				=> 0,
				'pattern'			=> '\d*(\.\d*)?',
			), $metabox_id, $field_id, $post_type )
		) );

		$field_id = INVENTOR_LISTING_PREFIX  . 'price_prefix';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __( 'Prefix', 'inventor' );

			$cmb->add_field( array(
				'id'            => $field_id,
				'type'          => 'text_small',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', __( 'Any text shown before price (for example "from").', 'inventor' ), $metabox_id, $field_id, $post_type ),
				'default'       => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes'    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX  . 'price_suffix';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Suffix', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'text_small',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', __('Any text shown after price (for example "per night").', 'inventor'), $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters('inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type),
				'attributes'    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX  . 'price_custom';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Custom', 'inventor');

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'text_medium',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', __('Any text instead of numeric price (for example "by agreement"). Prefix and Suffix will be ignored.', 'inventor'), $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes'    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
			) );
		}
	}

	/**
	 * Flags meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_flags( $post_type ) {
		if ( ! is_admin() ) {
			return;
		}

		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_flags';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Flags', 'inventor' ), $metabox_id ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => WP_REST_SERVER::READABLE,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'featured';
		$field_name = __( 'Featured', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'checkbox',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'reduced';
		$field_name = __( 'Reduced', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'checkbox',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Date meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_date( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_date';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Date', 'inventor' ), $metabox_id ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'date';
		$field_name = __( 'Date', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_date_timestamp',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Date meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_time( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_time';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Time', 'inventor' ), $metabox_id ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'time';
		$field_name = __( 'Time', 'inventor' );

		$cmb->add_field( array(
			'id'            => $field_id,
			'type'          => 'text_time',
			'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'       => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Date interval meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_date_interval( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_date_interval';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Date interval', 'inventor' ), $metabox_id ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'date_from';
		$field_name = __( 'Date from', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_date_timestamp',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'date_to';
		$field_name = __( 'Date to', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_date_timestamp',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Datetime interval meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_datetime_interval( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_datetime_interval';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Date and time interval', 'inventor' ), $metabox_id ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'datetime_from';
		$field_name = __( 'Date and time from', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_datetime_timestamp',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'datetime_to';
		$field_name = __( 'Date and time to', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_datetime_timestamp',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Time interval meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_time_interval( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_time_interval';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Time interval', 'inventor' ), $metabox_id ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'time_from';
		$field_name = __( 'Time from', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_time',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'time_to';
		$field_name = __( 'Time to', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_time',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Date and time interval meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_date_and_time_interval( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_date_and_time_interval';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Date and time interval', 'inventor' ), $metabox_id ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'date';
		$field_name = __( 'Date', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_date_timestamp',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'time_from';
		$field_name = __( 'Time from', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_time',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );

		$field_id = INVENTOR_LISTING_PREFIX . 'time_to';
		$field_name = __( 'Time to', 'inventor' );

		$cmb->add_field( array(
			'id'                => $field_id,
			'type'              => 'text_time',
			'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
			'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
			'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
			'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
		) );
	}

	/**
	 * Location meta box
	 *
	 * @access public
	 * @param $post_type
	 * @return void
	 */
	public static function metabox_location( $post_type ) {
		$metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_location';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'			=> apply_filters( 'inventor_metabox_title', __( 'Location', 'inventor' ), $metabox_id, $post_type ),
			'description'   => apply_filters( 'inventor_metabox_description', __( 'Set location of the listing. It will help people to find it.', 'inventor' ), $metabox_id, $post_type ),
			'object_types'  => array( $post_type ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_in_rest'  => true,
		) );

		// Location
		$field_id = INVENTOR_LISTING_PREFIX  . 'locations';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __( 'Location / Region', 'inventor' );
			$field_type = 'taxonomy_select_chain';

			$cmb->add_field( array(
				'id'            	=> $field_id,
				'taxonomy'      	=> 'locations',
				'select_all_button'	=> false,
				'name'          	=> apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'type'          	=> apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, $post_type ),
				'default'       	=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'before_row'    	=> apply_filters( 'inventor_metabox_field_before_row', null, $metabox_id, $field_id, $post_type ),
				'before'       		=> apply_filters( 'inventor_metabox_field_before', null, $metabox_id, $field_id, $post_type ),
				'before_field'  	=> apply_filters( 'inventor_metabox_field_before_field', null, $metabox_id, $field_id, $post_type ),
				'after_field'   	=> apply_filters( 'inventor_metabox_field_after_field', null, $metabox_id, $field_id, $post_type ),
				'after'        		=> apply_filters( 'inventor_metabox_field_after', null, $metabox_id, $field_id, $post_type ),
				'after_row'	 		=> apply_filters( 'inventor_metabox_field_after_row', null, $metabox_id, $field_id, $post_type ),
			) );
		}

		// Google Map
		$field_id = INVENTOR_LISTING_PREFIX . 'map_location';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			$field_name = __('Map Location', 'inventor');
			$cmb->add_field( array(
				'id' 				=> $field_id,
				'type' 				=> 'pw_map',
				'sanitization_cb' 	=> 'pw_map_sanitise',
				'split_values' 		=> true,
				'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 			=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'skip' 				=> true
			) );

			$field_id = INVENTOR_LISTING_PREFIX . 'map_location_polygon';
			if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
				// Google Map Polygon
				$field_name = __( 'Map Location Polygon', 'inventor' );

				$cmb->add_field( array(
					'id'                => $field_id,
					'type'              => 'text',
					'name'   			=> apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
					'description'   	=> apply_filters( 'inventor_metabox_field_description', __( 'Enter encoded path. It can be constructed using <a href="https://google-developers.appspot.com/maps/documentation/utilities/polylineutility_5bbd4b6fcb5fada7a7a2df3ef50d3f67.frame?hl=en" target="_blank">Interactive Polyline Encoder Utility</a>.', 'inventor' ), $metabox_id, $field_id, $post_type ),
					'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
					'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
					'skip'              => true
				) );
			}
		}

		$field_id = INVENTOR_LISTING_PREFIX . 'street_view';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			// Google Street View
			$field_name = __( 'Street View', 'inventor' );

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'checkbox',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'  	=> apply_filters( 'inventor_metabox_field_description', __( 'Check to enable Street View', 'inventor' ), $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', false, $metabox_id, $field_id, $post_type ),
				'attributes'    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'skip'			=> true,
			) );

			$field_id = INVENTOR_LISTING_PREFIX . 'street_view_location';
			$field_name = __( 'Street View Location', 'inventor' );

			$cmb->add_field( array(
				'id' 				=> $field_id,
				'type' 				=> 'street_view',
				'sanitization_cb' 	=> 'street_view_sanitise',
				'split_values'	 	=> true,
				'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 			=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'skip' 				=> true,
			) );
		}

		$field_id = INVENTOR_LISTING_PREFIX . 'inside_view';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, $post_type ) ) {
			// Inside View
			$field_name = __( 'Inside View', 'inventor' );

			$cmb->add_field( array(
				'id' 			=> $field_id,
				'type' 			=> 'checkbox',
				'name'          => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   => apply_filters( 'inventor_metabox_field_description', __( 'Check to enable Inside View', 'inventor' ), $metabox_id, $field_id, $post_type ),
				'default' 		=> apply_filters( 'inventor_metabox_field_default', false, $metabox_id, $field_id, $post_type ),
				'attributes'    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'skip' 			=> true,
			) );

			$field_id = INVENTOR_LISTING_PREFIX . 'inside_view_location';
			$field_name = __( 'Inside View Location', 'inventor' );

			$cmb->add_field( array(
				'id' 				=> $field_id,
				'type' 				=> 'street_view',
				'sanitization_cb' 	=> 'street_view_sanitise',
				'split_values' 		=> true,
				'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, $post_type ),
				'description'   	=> apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, $post_type ),
				'default' 			=> apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, $post_type ),
				'attributes'    	=> apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, $post_type ),
				'skip' 				=> true,
			) );
		}
	}
}

Inventor_Metaboxes::init();