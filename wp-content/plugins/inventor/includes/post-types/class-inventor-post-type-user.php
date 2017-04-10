<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Post_Type_User
 *
 * @class Inventor_Post_Type_User
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Post_Type_User {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'process_profile_form' ), 9999 );
		add_action( 'init', array( __CLASS__, 'process_change_password_form' ), 9999 );
		add_action( 'init', array( __CLASS__, 'process_login_form' ), 9999 );
		add_action( 'login_form_lostpassword', array( __CLASS__, 'process_reset_password_form' ) );
		add_action( 'init', array( __CLASS__, 'process_register_form' ), 9999 );
		add_action( 'init', array( __CLASS__, 'set_roles_permissions' ), 9999 );
		add_action( 'pre_get_posts', array( __CLASS__, 'media_files' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'author_cpt_filter' ) );
		add_action( 'user_register', array( __CLASS__, 'set_profile_data' ), 10, 1 );

		add_filter( 'lostpassword_url', array( __CLASS__, 'custom_lost_password_page' ), 10, 2 );
		add_filter( 'cmb2_init', array( __CLASS__, 'fields' ) );
		add_filter( 'wp_count_attachments', array( __CLASS__, 'recount_attachments' ) );
		add_filter( 'show_admin_bar', array( __CLASS__, 'show_admin_bar_for_admins_only' ) );
		add_filter( 'cmb2_sanitize_text', array( __CLASS__, 'sanitize_text' ), 10, 5 );
		add_filter( 'cmb2_sanitize_text_medium', array( __CLASS__, 'sanitize_text' ), 10, 5 );
	}

	/**
	 * Get user full name
	 *
	 * @access public
	 * @param int $user_id
	 * @return string
	 */
	public static function get_full_name( $user_id ) {
//		$first_name = get_the_author_meta( 'first_name', $user_id );
//        $last_name = get_the_author_meta( 'last_name', $user_id );
		$first_name = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'general_first_name', true );
		$last_name = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'general_last_name', true );

		$full_name = "";

        if ( ! empty( $first_name ) ) {
        	$full_name = $first_name;
        }

		if ( ! empty( $last_name ) ) {
			$full_name = "$full_name {$last_name}";
		}

		$full_name = trim( $full_name );

		if ( ! empty( $full_name ) ) {
			return $full_name;
		}
		
        return get_the_author_meta( 'display_name', $user_id );
	}

	/**
	 * Get user image or avatar URL
	 *
	 * @access public
	 * @param int $user_id
	 * @param int $size
	 * @return string
	 */
	public static function get_user_image( $user_id, $size = 300 ) {
		$image = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'general_image', true );

		if( ! empty( $image ) ) {
			return $image;
		}

		$avatar_data = get_avatar_data( $user_id, array( 'size' => $size, 'width' => $size, 'height' => $size ) );

		if( ! empty( $avatar_data['url'] ) ) {
			return $avatar_data['url'];
		}

		return null;
	}


	/**
	 * Get users. By default listing authors (users which have published at least one listing)
	 *
	 * @access public
	 * @param $type
	 * @param $count
	 * @param $order
	 * @param $ids
	 * @return array
	 */
	public static function get_users( $type = 'author', $count = -1, $order = 'registered', $ids = array() ) {
		global $wpdb;
		$params = array();

		if( $count != -1 ) {
			$params['number'] = $count;
		}

		if ( 'author' == $type ) {
			$min_posts = 1;
			$listing_types = Inventor_Post_Types::get_listing_post_types();
			$listing_types = array_map( function( $value ) { return "'" . $value . "'"; }, $listing_types );
			$listing_types_string_array = join( ',', $listing_types );
			$author_ids = $wpdb->get_col("SELECT `post_author` FROM (SELECT `post_author`, COUNT(*) AS `count` FROM {$wpdb->posts} WHERE `post_status`='publish' AND `post_type` IN ({$listing_types_string_array}) GROUP BY `post_author`) AS `stats` WHERE `count` >= {$min_posts} ORDER BY `count` DESC;");
			$params['include'] = $author_ids;
		}

		if ( in_array( $order, array( 'registered', 'post_count' ) ) ) {
			$params['orderby'] = $order;
			$params['order'] = 'DESC';
		}

		if ( count( $ids ) > 0 ) {
			$params['include'] = $ids;
			$params['order'] = 'ASC';
		}

		return get_users( $params );
	}

	/**
	 * Defines custom fields
	 *
	 * @access public
	 * @return void
	 */
	public static function fields() {
		$metabox_id = INVENTOR_USER_PREFIX . 'profile';

		$cmb = new_cmb2_box( array(
			'id'            => $metabox_id,
			'title'      	=> apply_filters( 'inventor_metabox_title', __( 'Profile', 'inventor' ), $metabox_id, 'user' ),
			'object_types'  => array( 'user' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
		) );

		// General
		$field_name = __( 'General', 'inventor' );
		$field_id = INVENTOR_USER_PREFIX . 'general_title';
		$cmb->add_field( array(
			'id'        => $field_id,
			'name'      => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, 'user' ),
			'type'      => 'title',
		) );

		$field_id = INVENTOR_USER_PREFIX . 'general_image';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id' => $field_id,
				'name' => __( 'Image', 'inventor' ),
				'type' => 'file',
			) );
		}

		$field_id = INVENTOR_USER_PREFIX . 'general_first_name';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id'        => $field_id,
				'name'      => __( 'First name', 'inventor' ),
				'type'      => 'text_medium',
				'sanitization_cb'   => array( 'Inventor_Utilities', 'remove_special_characters' ),
				'escape_cb'         => array( 'Inventor_Utilities', 'remove_special_characters' )
			) );
		}

		$field_id = INVENTOR_USER_PREFIX . 'general_last_name';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id'        => $field_id,
				'name'      => __( 'Last name', 'inventor' ),
				'type'      => 'text_medium',
				'sanitization_cb'   => array( 'Inventor_Utilities', 'remove_special_characters' ),
				'escape_cb'         => array( 'Inventor_Utilities', 'remove_special_characters' )
			) );
		}

		$field_id = INVENTOR_USER_PREFIX . 'general_email';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id'        => $field_id,
				'name'      => __( 'E-mail', 'inventor' ),
				'type'      => 'text_unique_user_email',
				'attributes'	=> array(
					'class'		=> 'cmb2-text-medium'
				)
			) );
		}

		$field_id = INVENTOR_USER_PREFIX  . 'bio_user';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field(array(
				'id' => $field_id,
				'name' => __('Bio', 'inventor'),
				'type' => 'textarea',
			));
		}

		$field_id = INVENTOR_USER_PREFIX . 'general_website';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id' => $field_id,
				'name' => __( 'Website', 'inventor' ),
				'type' => 'text_url',
			) );
		}

		$field_id = INVENTOR_USER_PREFIX . 'general_phone';
		$field_type = 'text_medium';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id' 		=> $field_id,
				'name' 		=> __( 'Phone', 'inventor' ),
				'type' 		=> apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, 'user' ),
				'default'   => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, 'user' ),
			) );
		}

		// Address
		$address_enabled = false;

		$address_fields_ids = array(
			INVENTOR_USER_PREFIX . 'address_street_and_number',
			INVENTOR_USER_PREFIX . 'address_postal_code',
			INVENTOR_USER_PREFIX . 'address_city',
			INVENTOR_USER_PREFIX . 'address_country',
			INVENTOR_USER_PREFIX . 'address_county',
		);

		foreach( $address_fields_ids as $address_field_id ) {
			if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $address_field_id, 'user' ) ) {
				$address_enabled = true;
				break;
			}
		}

		$field_id = INVENTOR_USER_PREFIX . 'address_title';
		if ( apply_filters( 'inventor_metabox_field_enabled', $address_enabled, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id'        => $field_id,
				'name'      => __( 'Address', 'inventor' ),
				'type'      => 'title',
			) );
		}

		$field_id = INVENTOR_USER_PREFIX . 'address_street_and_number';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id' => $field_id,
				'name' => __( 'Street and number', 'inventor' ),
				'type' => 'text_medium',
			) );
		}

		$field_id = INVENTOR_USER_PREFIX . 'address_postal_code';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id' => $field_id,
				'name' => __( 'Postal code', 'inventor' ),
				'type' => 'text_medium',
			) );
		}

		$field_id = INVENTOR_USER_PREFIX . 'address_city';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id' => $field_id,
				'name' => __( 'City', 'inventor' ),
				'type' => 'text_medium',
			) );
		}

		$field_id = INVENTOR_USER_PREFIX . 'address_country';
		$field_name = __( 'Country', 'inventor');

		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$dropdown_enabled = get_theme_mod( 'inventor_users_country_dropdown_enabled', false );

			$field_type = 'text_medium';

			$field_args = array(
				'id'                => $field_id,
				'type'              => apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, 'user' ),
				'name'              => apply_filters( 'inventor_metabox_field_name', $field_name, $metabox_id, $field_id, 'user' ),
				'description'       => apply_filters( 'inventor_metabox_field_description', null, $metabox_id, $field_id, 'user' ),
				'default'           => apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_id, 'user' ),
				'attributes' 	    => apply_filters( 'inventor_metabox_field_attributes', array(), $metabox_id, $field_id, 'user' ),
			);

			if ( $dropdown_enabled ) {
				$field_type = 'select';
				$field_args['type'] = apply_filters( 'inventor_metabox_field_type', $field_type, $metabox_id, $field_id, 'user' );
				$field_args['options'] = Inventor_Utilities::get_countries();
				$field_args['show_option_none'] = true;
			}

			$cmb->add_field( $field_args );
		}

		$field_id = INVENTOR_USER_PREFIX . 'address_county';
		if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
			$cmb->add_field( array(
				'id' 	=> $field_id,
				'name' 	=> __( 'State / County', 'inventor' ),
				'type'	=> 'text_medium',
			) );
		}

		// Social Connections
		$social_networks = apply_filters( 'inventor_metabox_social_networks', array(), 'user' );

		if ( count( $social_networks ) > 0 ) {
			$cmb->add_field( array(
				'id'    => INVENTOR_USER_PREFIX . 'social_title',
				'name'	=> __( 'Social Connections', 'inventor' ),
				'type'  => 'title',
			) );

			foreach( $social_networks as $key => $title ) {
				$field_id = INVENTOR_USER_PREFIX . 'social_' . $key;

				if ( apply_filters( 'inventor_metabox_field_enabled', true, $metabox_id, $field_id, 'user' ) ) {
					$cmb->add_field( array(
						'id' 	=> $field_id,
						'name' 	=> $title,
						'type' 	=> 'text_medium',
					) );
				}
			}
		}
	}

	/**
	 * Sets initial user profile data
	 *
	 * @access public
	 * @param $user_id
	 * @return void
	 */
	public static function set_profile_data( $user_id ) {
		$user_info = get_userdata( $user_id );
		$first_name = $user_info->first_name;
		$last_name = $user_info->last_name;
		$email = $user_info->user_email;

		update_user_meta( $user_id, INVENTOR_USER_PREFIX . 'general_first_name', $first_name );
		update_user_meta( $user_id, INVENTOR_USER_PREFIX . 'general_last_name', $last_name );
		update_user_meta( $user_id, INVENTOR_USER_PREFIX . 'general_email', $email );
	}

	/**
	 * Sanitizes text field and updates default WP user model
	 *
	 * @access public
	 * @return string
	 */
	public static function sanitize_text( $override_value, $value, $object_id, $field_args, $sanitizer_object ) {
		$object_type = $sanitizer_object->field->object_type;
		$field_id = $sanitizer_object->field->args['id'];

		if( $object_type != 'user' ) {
			return $value;
		}

		if ( $field_id == INVENTOR_USER_PREFIX . 'general_first_name' ) {
			wp_update_user( array( 'ID' => $object_id, 'first_name' => $value ) );
		}

		if ( $field_id == INVENTOR_USER_PREFIX . 'general_last_name' ) {
			wp_update_user( array( 'ID' => $object_id, 'last_name' => $value ) );
		}

		return $value;
	}

	/**
	 * Process change profile form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_profile_form() {
		if ( ! empty( $_POST['submit-profile'] ) ) {
			$cmb = cmb2_get_metabox( INVENTOR_USER_PREFIX . 'profile', get_current_user_id() );
			$cmb->save_fields( get_current_user_id(), 'user', $_POST );

			Inventor_Utilities::show_message( 'success', __( 'Profile has been successfully updated.', 'inventor' ) );
			wp_redirect( $_SERVER['HTTP_REFERER'] );

			exit();
		}
	}

	/**
	 * Process change password form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_change_password_form() {
		if ( ! isset( $_POST['change_password_form'] ) ) {
			return;
		}
        $old_password = $_POST['old_password'];
		$new_password = $_POST['new_password'];
		$retype_password = $_POST['retype_password'];

		if ( empty( $old_password ) || empty( $new_password ) || empty( $retype_password ) ) {
			Inventor_Utilities::show_message( 'warning', __( 'All fields are required.', 'inventor' ) );
			return;
		}

		if ( $new_password != $retype_password ) {
			Inventor_Utilities::show_message( 'warning', __( 'New and retyped password are not same.', 'inventor' ) );
		}

		$user = wp_get_current_user();

		if ( ! wp_check_password( $old_password, $user->data->user_pass, $user->ID ) ) {
			Inventor_Utilities::show_message( 'warning', __( 'Your old password is not correct.', 'inventor' ) );
			return;
		}

		wp_set_password( $new_password, $user->ID );
		Inventor_Utilities::show_message( 'success', __( 'Your password has been successfully changed.', 'inventor' ) );
	}

	/**
	 * Process login form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_login_form() {
		if ( ! isset( $_POST['login_form'] ) ) {
			return;
		}

		if ( empty( $_POST['login'] ) || empty( $_POST['password'] ) ) {
			Inventor_Utilities::show_message( 'warning', __( 'Login and password are required.', 'inventor' ) );
			return;
		}

		$user_login = $_POST['login'];

		$user = wp_signon( array(
			'user_login'        => $user_login,
			'user_password'     => $_POST['password'],
		) );

		if ( is_wp_error( $user ) ) {
			Inventor_Utilities::show_message( 'danger', $user->get_error_message() );
			return;
		}

		Inventor_Utilities::show_message( 'success', __( 'You have been successfully logged in.', 'inventor' ) );

		// set wordpress data
		if ( $user ) {
			wp_set_current_user( $user->ID, $user_login );
			wp_set_auth_cookie( $user->ID );
			do_action( 'wp_login', $user_login );
		}

		// login page
		$login_required_page = get_theme_mod( 'inventor_general_login_required_page' );
		$login_required_page_url = $login_required_page ? get_permalink( $login_required_page ) : home_url();

		// after login page
		$after_login_page = get_theme_mod( 'inventor_general_after_login_page' );
		$after_login_page_url = $after_login_page ? get_permalink( $after_login_page ) : home_url();

		// get current url
		$protocol = is_ssl() ? 'https://' : 'http://';
		$current_url = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

		// if user logs in at login page, redirect him to after login page. Otherwise, redirect him back to previous URL.
		$after_login_url = $current_url == $login_required_page_url ? $after_login_page_url : $current_url;

		wp_redirect( $after_login_url );
		exit();
	}

	/**
	 * Custom lost password page
	 *
	 * @access public
	 * @param $lostpassword_url
	 * @param $redirect
	 * @return string
	 */
	public static function custom_lost_password_page( $lostpassword_url, $redirect ) {
		$reset_password_page = get_theme_mod( 'inventor_general_reset_password_page', null );

		if ( ! empty( $reset_password_page ) ) {
			return get_permalink( $reset_password_page );
		}

		return $lostpassword_url;
	}

	/**
	 * Process reset form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_reset_password_form() {
		if ( ! isset( $_POST['reset_form'] ) ) {
			return;
		}

		$result = retrieve_password();

		if ( is_wp_error( $result ) ) {
			Inventor_Utilities::show_message( 'danger', __( 'Unable to send an e-mail.', 'inventor' ) );
		} else {
			Inventor_Utilities::show_message( 'success', __( 'Please check inbox for more information.', 'inventor' ) );
		}

		wp_redirect( $_SERVER['HTTP_REFERER'] );
		exit();
	}

	/**
	 * Process register form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_register_form() {
		if ( ! isset( $_POST['register_form'] ) || ! get_option( 'users_can_register' ) ) {
			return;
		}

		if ( class_exists( 'Inventor_Recaptcha' ) && Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) {
			if ( array_key_exists( 'g-recaptcha-response', $_POST ) ) {
				$is_recaptcha_valid = Inventor_Recaptcha_Logic::is_recaptcha_valid( $_POST['g-recaptcha-response'] );

				if ( ! $is_recaptcha_valid ) {
					Inventor_Utilities::show_message( 'danger', __( 'reCAPTCHA is not valid.', 'inventor' ) );
					return;
				}
			}
		}

		if ( empty( $_POST['username'] ) || empty( $_POST['email'] ) ) {
			Inventor_Utilities::show_message( 'danger', __( 'Username and e-mail are required.', 'inventor' ) );
			return;
		}

		$user_id = username_exists( $_POST['username'] );
		if ( ! empty( $user_id ) ) {
			Inventor_Utilities::show_message( 'danger', __( 'Username already exists.', 'inventor' ) );
			return;
		}

		$user_id = email_exists( $_POST['email'] );
		if ( ! empty( $user_id ) ) {
			Inventor_Utilities::show_message( 'danger', __( 'Email already exists.', 'inventor' ) );
			return;
		}

		if ( $_POST['password'] != $_POST['password_retype'] ) {
			Inventor_Utilities::show_message( 'danger', __( 'Passwords must be same.', 'inventor' ) );
			return;
		}

		$terms_id = get_theme_mod( 'inventor_general_terms_and_conditions_page', false );

		if ( $terms_id && empty( $_POST['agree_terms'] ) ) {
			Inventor_Utilities::show_message( 'danger', __( 'You must agree terms &amp; conditions.', 'inventor' ) );
			return;
		}

		if ( $_POST['password'] != $_POST['password_retype'] ) {
			Inventor_Utilities::show_message( 'danger', __( 'Passwords must be same.', 'inventor' ) );
			return;
		}

		$user_login = $_POST['username'];
		$user_id = wp_create_user( $user_login, $_POST['password'], $_POST['email'] );

		if ( is_wp_error( $user_id ) ) {
			Inventor_Utilities::show_message( 'danger', $user_id->get_error_message() );
			return;
		}

		// 'admin' / 'both'
		$notify_about_new_user = apply_filters( 'inventor_notify_about_new_user', 'both' );
		wp_new_user_notification( $user_id, null, $notify_about_new_user );

		Inventor_Utilities::show_message( 'success', __( 'You have been successfully registered.', 'inventor' ) );
		$user = get_user_by( 'login', $user_login );
		$log_in_after_registration = get_theme_mod( 'inventor_log_in_after_registration', false );

		// automatic user log in
		if ( $user && $log_in_after_registration ) {
			wp_set_current_user( $user->ID, $user_login );
			wp_set_auth_cookie( $user->ID );
			do_action( 'wp_login', $user_login );
		}

		// registration page
		$registration_page = get_theme_mod( 'inventor_general_registration_page' );
		$registration_page_url = $registration_page ? get_permalink( $registration_page ) : home_url();

		// after register page
		$after_register_page = get_theme_mod( 'inventor_general_after_register_page' );
		$after_register_page_url = $after_register_page ? get_permalink( $after_register_page ) : home_url();

		// if user registers at registration page, redirect him to after register page. Otherwise, redirect him back to previous URL.
		$protocol = is_ssl() ? 'https://' : 'http://';
		$current_url = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

		$after_register_url = $current_url == $registration_page_url ? $after_register_page_url : $current_url;

		// if current url is payment page, try to fetch payment data from request
		$payment_page = get_theme_mod( 'inventor_general_payment_page' );
		$payment_page_url = $payment_page ? get_permalink( $payment_page ) : home_url();

		if ( $current_url == $payment_page_url && ! empty( $_POST['payment_type'] ) && ! empty( $_POST['object_id'] ) ) {
			return;
		}

		wp_redirect( $after_register_url );
		exit();
	}

	/**
	 * In media library display only current user's files
	 *
	 * @access public
	 * @param array $wp_query
	 * @return void
	 */
	public static function media_files( $wp_query ) {
		global $current_user;

		if ( ! current_user_can( 'manage_options' ) && ( is_admin() && $wp_query->query['post_type'] === 'attachment' ) ) {
			$wp_query->set( 'author', $current_user->ID );
		}
	}

	/**
	 * Allows pagination in author detail page
	 *
	 * @access public
	 * @param array $wp_query
	 * @return void
	 */
	public static function author_cpt_filter( $query ) {
		if ( ! is_admin() && $query->is_main_query() ) {
			if ( $query->is_author() ) {
				$query->set('post_type', Inventor_Post_Types::get_listing_post_types() );
			}
		}
	}

	/**
	 * Count of items in media library
	 *
	 * @access public
	 * @param $counts_in
	 * @return int
	 */
	public static function recount_attachments( $counts_in ) {
		global $wpdb;
		global $current_user;

		$and = wp_post_mime_type_where( '' );
		$count = $wpdb->get_results( "SELECT post_mime_type, COUNT( * ) AS num_posts FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status != 'trash' AND post_author = {$current_user->ID} $and GROUP BY post_mime_type", ARRAY_A );

		$counts = array();
		foreach ( (array) $count as $row ) {
			$counts[ $row['post_mime_type'] ] = $row['num_posts'];
		}

		$counts['trash'] = $wpdb->get_var( "SELECT COUNT( * ) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_author = {$current_user->ID} AND post_status = 'trash' $and" );
		return $counts;
	}

	/**
	 * Set necessary role permissions
	 * https://codex.wordpress.org/Roles_and_Capabilities
	 *
	 * @access public
	 * @return void
	 */
	public static function set_roles_permissions() {
		// subscriber
		$subscriber = get_role( 'subscriber' );

		if ( $subscriber ) {
			$subscriber->add_cap( 'upload_files' );
			$subscriber->add_cap( 'delete_posts' );
			$subscriber->add_cap( 'edit_post' );
		}

		// contributor
		$contributor = get_role( 'contributor' );

		if ( $contributor ) {
			$contributor->add_cap( 'upload_files' );
			$contributor->add_cap( 'edit_post' );
		}
	}

	/**
	 * Disable admin bar for everyone except admins
	 *
	 * @access public
	 * @param string $content
	 * @return string
	 */
	public static function show_admin_bar_for_admins_only( $content ) {
		return current_user_can( 'administrator' ) ? $content : false;
	}
}

Inventor_Post_Type_User::init();
