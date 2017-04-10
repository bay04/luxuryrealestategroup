<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Utilities
 *
 * @class Inventor_Utilities
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Utilities {
	/**
	 * Initialize utilities
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'init', array( __CLASS__, 'check_gateway_in_payment_process' ), 1 );
		add_filter( 'inventor_listing_title', array( __CLASS__, 'listing_title' ), 10, 2 );
		add_filter( 'inventor_poi_icons', array( __CLASS__, 'poi_icons' ), 1 );
	}

	/**
	 * Loads localization files
	 *
	 * @access public
	 * @return void
	 */
	public static function load_plugin_textdomain( $domain, $file ) {
		# http://geertdedeckere.be/article/loading-wordpress-language-files-the-right-way

		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		$mofile = $domain . '-' . $locale . '.mo';
		$mofile = WP_LANG_DIR . '/plugins/' . $mofile;

		load_textdomain( $domain, $mofile );

		load_plugin_textdomain( $domain, false, plugin_basename( dirname( $file ) ) . '/languages' );
	}

	/**
	 * Saves alert message which will be shown to user
	 *
	 * @access public
	 * @param string $status
	 * @param string $message
	 * @return void
	 */
	public static function show_message( $status, $message ) {
		if ( 'SESSION' == apply_filters( 'inventor_visitor_data_storage', INVENTOR_DEFAULT_VISITOR_DATA_STORAGE ) ) {
			$_SESSION['messages'][] = array( $status, $message );
		} else {
			// save message to request if user is not redirected to new page
			$_REQUEST['messages'][] = array( $status, $message );

			// COOKIE messages only works if user is redirected to new page
			if ( isset( $_COOKIE['messages'] ) ) {
				$messages = $_COOKIE['messages'];
				$messages = json_decode( $messages, true );
			} else {
				$messages = array();
			}

			$messages[] = array( $status, $message );
			$messages = json_encode( $messages );

			setcookie( 'messages', $messages, 0, $path = '/' );
		}
	}

	/**
	 * Returns alert messages which will be shown to user
	 *
	 * @access public
	 * @return array
	 */
	public static function get_messages() {
		if ( isset( $_REQUEST['messages'] ) ) {
			$messages = $_REQUEST['messages'];
		} else {
			if ( isset( $_COOKIE['messages'] ) ) {
				$messages = json_decode(stripcslashes($_COOKIE['messages']), true);
			}
		}

		if ( isset( $messages ) ) {
			return Inventor_Utilities::array_unique_multidimensional( $messages );
		}

		return null;
	}

	/**
	 * Alters listing title. Appends verified branding logo.
	 *
	 * @access public
	 * @param string $title
	 * @param int $post_id
	 * @return string
	 */
	public static function listing_title( $title, $post_id ) {
//		$rendered_logo = self::render_logo( $post_id );
		$logo = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX  . 'logo', true );

		if ( ! empty( $logo ) ) {
			$rendered_logo = '<img src="'. $logo .'" class="listing-title-logo" alt="' . get_the_title( $post_id ) . '">';
			$title = $rendered_logo. ' ' . $title;
		}

		return $title;
	}

	/**
	 * Checks if user allowed to remove post
	 *
	 * @access public
	 * @param $user_id int
	 * @param $item_id int
	 * @return bool
	 */
	public static function is_allowed_to_remove( $user_id, $item_id ) {
		$item = get_post( $item_id );
		if ( ! empty( $item->post_author ) ) {
			if ( $item->post_author == $user_id ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Generates hash
	 *
	 * @access public
	 * @return string
	 */
	public static function generate_hash() {
		return sha1(md5(time()));
	}

	/**
	 * Gets link for login
	 *
	 * @access public
	 * @return bool|string
	 */
	public static function get_link_for_login() {
		$login_required_page = get_theme_mod( 'inventor_general_login_required_page', null );
		if ( ! empty( $login_required_page ) ) {
			return get_permalink( $login_required_page );
		}
		return false;
	}

	/**
	 * Makes multi dimensional array
	 *
	 * @access public
	 * @param $input array
	 * @return array
	 */
	public static function array_unique_multidimensional( $input ) {
		$serialized = array_map( 'serialize', $input );
		$unique = array_unique( $serialized );
		return array_intersect_key( $input, $unique );
	}

	/**
	 * Gets all pages list
	 *
	 * @access public
	 * @return array
	 */
	public static function get_pages() {
		$pages = array();
		$pages[] = __( 'Not set', 'inventor' );

		foreach ( get_pages() as $page ) {
			$pages[ $page->ID ] = $page->post_title;
		}

		return $pages;
	}

	/**
	 * Sanitize a string from textarea
	 *
	 * check for invalid UTF-8,
	 * Convert single < characters to entity,
	 * strip all tags,
	 * strip octets.
	 *
	 * @param string $str
	 * @return string
	 */
	public static function sanitize_textarea( $str ) {
		$filtered = wp_check_invalid_utf8( $str );

		if ( strpos($filtered, '<') !== false ) {
			$filtered = wp_pre_kses_less_than( $filtered );
			// This will strip extra whitespace for us.
			$filtered = wp_strip_all_tags( $filtered, true );
		}

		$found = false;
		while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
			$filtered = str_replace($match[0], '', $filtered);
			$found = true;
		}

		if ( $found ) {
			// Strip out the whitespace that may now exist after removing the octets.
			$filtered = trim( preg_replace('/ +/', ' ', $filtered) );
		}

		/**
		 * Filter a sanitized textarea string.
		 *
		 * @param string $filtered The sanitized string.
		 * @param string $str      The string prior to being sanitized.
		 */
		return apply_filters( 'sanitize_textarea', $filtered, $str );
	}

	/**
	 * Sanitize unescaped value
	 *
	 * @param string $value
	 * @return string
	 */
	public static function sanitize_unescaped( $value ) {
		return $value;
	}

	/**
	 * Removes all special characters from string
	 *
	 * @param string $value
	 * @return string
	 */
	public static function remove_special_characters( $value ) {
		$invalid_chars = "\"'§!±@#$%^&*()_+}{[]|:;'=/.,<>?`~";
		return str_replace( str_split ( $invalid_chars ), '', $value );
	}

	/**
	 * Get UUID
	 *
	 * @access public
	 * @return string
	 */
	public static function get_uuid() {
		$chars = md5( uniqid( rand() ) );
		$uuid  = substr( $chars, 0, 8 ) . '-';
		$uuid .= substr( $chars, 8, 4 ) . '-';
		$uuid .= substr( $chars, 12, 4 ) . '-';
		$uuid .= substr( $chars, 16, 4 ) . '-';
		$uuid .= substr( $chars, 20, 12 );
		return $uuid;
	}

	/**
	 * Short UUID
	 *
	 * @access public
	 * @param string $prefix
	 * @return string
	 */
 	public static function get_short_uuid( $prefix = '') {
	    $uuid = self::get_uuid();
	    $parts = explode( '-', $uuid );
	    return $prefix . $parts[0];
	}

	/**
	 * Renders select option by given term
	 *
	 * @access public
	 * @param $term
	 * @param $depth
	 * @param $selected
	 * @return string
	 */
	public static function get_term_select_option( $term, $depth, $selected ) {
		$args = array(
			'value' => $term->slug,
			'label' => str_repeat( "&raquo;&nbsp;", $depth - 1 ) . ' ' . $term->name,
		);

		$is_selected = is_array( $selected ) && in_array( $term->slug, $selected ) || $term->slug == $selected;

		if ( $is_selected ) {
			$args['checked'] = 'checked';
		}

		return sprintf( "\t" . '<option value="%s" %s>%s</option>', $args['value'], selected( isset( $args['checked'] ) && $args['checked'], true, false ), $args['label'] ) . "\n";
	}

	/**
	 * Build children hierarchy
	 *
	 * @access public
	 * @param $taxonomy
	 * @param $selected
	 * @param $parent_term
	 * @param $depth
	 * @param $hide_empty
	 * @param $post_type
	 * @return null|string
	 */
	public static function build_hierarchical_taxonomy_select_options( $taxonomy, $selected = null, $parent_term = null, $depth = 1, $hide_empty = false, $post_type = null ) {
		$output = null;

		$terms_query_args = array(
			'hide_empty'    => $hide_empty,
			'parent'        => $parent_term ? $parent_term->term_id : 0,
		);

		if ( ! empty( $post_type ) ) {
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

		$terms = get_terms( $taxonomy, $terms_query_args );

		if ( count( $terms ) == 0 && $parent_term && $parent_term->parent != 0 && $depth == 1 ) {

			// single queried object
			$output .= self::get_term_select_option( $parent_term, $depth, $selected );

		} elseif ( ! empty( $terms ) && is_array( $terms ) ) {

			// regular recursive select options
			$output = '';

			foreach( $terms as $term ) {
				$output .= self::get_term_select_option( $term, $depth, $selected );

				$children = self::build_hierarchical_taxonomy_select_options( $taxonomy, $selected, $term, $depth + 1 );

				if ( ! empty( $children ) ) {
					$output .= $children;
				}
			}
		}

		return $output;
	}

	/**
	 * Checks if gateway was chose in payment form
	 *
	 * @access public
	 * @return void
	 */
	public static function check_gateway_in_payment_process() {
		if ( ! isset( $_POST['process-payment'] ) ) {
			return;
		}

		if ( empty( $_POST['payment_gateway'] ) ) {
			Inventor_Utilities::show_message( 'danger', __( 'Choose payment gateway please.', 'inventor' ) );
		}
	}

	/**
	 * Returns logins of all site administrators
	 *
	 * @access public
	 * @return array
	 */
	public static function get_site_admins() {
		$logins = array();
		$administrators = get_users( 'role=administrator' );

		foreach ( $administrators as $user ) {
			$logins[] = $user->user_login;
		}

		return $logins;
	}

	/**
	 * Returns url which user should be redirected after payment
	 *
	 * @access public
	 * @param $payment_type
	 * @param $object_id
	 * @return array
	 */
	public static function get_after_payment_url( $payment_type, $object_id ) {
		// check if object is of listing type and if so, gets its permalink instead of site url
		if ( in_array( $payment_type, array( 'featured_listing', 'publish_listing' ) ) ) {
			// redirect to my listings page (if exists)
			$submission_list_page = get_theme_mod( 'inventor_submission_list_page', false );
			if ( ! empty( $submission_list_page ) ) {
				$url = get_permalink( $submission_list_page );
			}
		}

		// object detail page
		if ( ! isset( $url ) && isset ( $object_id ) ) {
			$object_post_type = get_post_type( $object_id );
			if ( in_array( $object_post_type, Inventor_Post_Types::get_listing_post_types() ) ) {
				$url = get_permalink( $object_id );
			}
		}

		if ( ! isset( $url ) ) {
			// after payment page
			$after_payment_page = get_theme_mod( 'inventor_general_after_payment_page' );
			$url = $after_payment_page ? get_permalink( $after_payment_page ) : home_url();
		}

		return $url;
	}

	/**
	 * Loads default POI icons
	 *
	 * @access public
	 * @param array $icons
	 * @return array
	 */
	public static function poi_icons( $icons ) {
		return array(
			'inventor-poi-airport' => '<i class="inventor-poi inventor-poi-airport"></i>',
			'inventor-poi-apartment' => '<i class="inventor-poi inventor-poi-apartment"></i>',
			'inventor-poi-atm' => '<i class="inventor-poi inventor-poi-atm"></i>',
			'inventor-poi-bank' => '<i class="inventor-poi inventor-poi-bank"></i>',
			'inventor-poi-bookcase' => '<i class="inventor-poi inventor-poi-bookcase"></i>',
			'inventor-poi-bus' => '<i class="inventor-poi inventor-poi-bus"></i>',
			'inventor-poi-camera' => '<i class="inventor-poi inventor-poi-camera"></i>',
			'inventor-poi-camping' => '<i class="inventor-poi inventor-poi-camping"></i>',
			'inventor-poi-car-service' => '<i class="inventor-poi inventor-poi-car-service"></i>',
			'inventor-poi-car' => '<i class="inventor-poi inventor-poi-car"></i>',
			'inventor-poi-cart' => '<i class="inventor-poi inventor-poi-cart"></i>',
			'inventor-poi-casino' => '<i class="inventor-poi inventor-poi-casino"></i>',
			'inventor-poi-castle' => '<i class="inventor-poi inventor-poi-castle"></i>',
			'inventor-poi-cemetery' => '<i class="inventor-poi inventor-poi-cemetery"></i>',
			'inventor-poi-church' => '<i class="inventor-poi inventor-poi-church"></i>',
			'inventor-poi-cinema' => '<i class="inventor-poi inventor-poi-cinema"></i>',
			'inventor-poi-clock' => '<i class="inventor-poi inventor-poi-clock"></i>',
			'inventor-poi-cocktail' => '<i class="inventor-poi inventor-poi-cocktail"></i>',
			'inventor-poi-coffee' => '<i class="inventor-poi inventor-poi-coffee"></i>',
			'inventor-poi-cog-wheel' => '<i class="inventor-poi inventor-poi-cog-wheel"></i>',
			'inventor-poi-coins' => '<i class="inventor-poi inventor-poi-coins"></i>',
			'inventor-poi-compass' => '<i class="inventor-poi inventor-poi-compass"></i>',
			'inventor-poi-computer-screen' => '<i class="inventor-poi inventor-poi-computer-screen"></i>',
			'inventor-poi-condominium' => '<i class="inventor-poi inventor-poi-condominium"></i>',
			'inventor-poi-cottage' => '<i class="inventor-poi inventor-poi-cottage"></i>',
			'inventor-poi-divider' => '<i class="inventor-poi inventor-poi-divider"></i>',
			'inventor-poi-exchange' => '<i class="inventor-poi inventor-poi-exchange"></i>',
			'inventor-poi-eye' => '<i class="inventor-poi inventor-poi-eye"></i>',
			'inventor-poi-factory' => '<i class="inventor-poi inventor-poi-factory"></i>',
			'inventor-poi-family-home' => '<i class="inventor-poi inventor-poi-family-home"></i>',
			'inventor-poi-female' => '<i class="inventor-poi inventor-poi-female"></i>',
			'inventor-poi-fruit' => '<i class="inventor-poi inventor-poi-fruit"></i>',
			'inventor-poi-gamepad' => '<i class="inventor-poi inventor-poi-gamepad"></i>',
			'inventor-poi-gas' => '<i class="inventor-poi inventor-poi-gas"></i>',
			'inventor-poi-glass' => '<i class="inventor-poi inventor-poi-glass"></i>',
			'inventor-poi-glasses' => '<i class="inventor-poi inventor-poi-glasses"></i>',
			'inventor-poi-globe' => '<i class="inventor-poi inventor-poi-globe"></i>',
			'inventor-poi-guitar' => '<i class="inventor-poi inventor-poi-guitar"></i>',
			'inventor-poi-hamburger' => '<i class="inventor-poi inventor-poi-hamburger"></i>',
			'inventor-poi-heart' => '<i class="inventor-poi inventor-poi-heart"></i>',
			'inventor-poi-hospital' => '<i class="inventor-poi inventor-poi-hospital"></i>',
			'inventor-poi-hotel' => '<i class="inventor-poi inventor-poi-hotel"></i>',
			'inventor-poi-house' => '<i class="inventor-poi inventor-poi-house"></i>',
			'inventor-poi-information' => '<i class="inventor-poi inventor-poi-information"></i>',
			'inventor-poi-key' => '<i class="inventor-poi inventor-poi-key"></i>',
			'inventor-poi-lcd' => '<i class="inventor-poi inventor-poi-lcd"></i>',
			'inventor-poi-leaf' => '<i class="inventor-poi inventor-poi-leaf"></i>',
			'inventor-poi-library' => '<i class="inventor-poi inventor-poi-library"></i>',
			'inventor-poi-lunch' => '<i class="inventor-poi inventor-poi-lunch"></i>',
			'inventor-poi-mail' => '<i class="inventor-poi inventor-poi-mail"></i>',
			'inventor-poi-male' => '<i class="inventor-poi inventor-poi-male"></i>',
			'inventor-poi-map' => '<i class="inventor-poi inventor-poi-map"></i>',
			'inventor-poi-mic' => '<i class="inventor-poi inventor-poi-mic"></i>',
			'inventor-poi-mountain' => '<i class="inventor-poi inventor-poi-mountain"></i>',
			'inventor-poi-music' => '<i class="inventor-poi inventor-poi-music"></i>',
			'inventor-poi-palms' => '<i class="inventor-poi inventor-poi-palms"></i>',
			'inventor-poi-parking' => '<i class="inventor-poi inventor-poi-parking"></i>',
			'inventor-poi-pastry' => '<i class="inventor-poi inventor-poi-pastry"></i>',
			'inventor-poi-pencil' => '<i class="inventor-poi inventor-poi-pencil"></i>',
			'inventor-poi-pharmacy' => '<i class="inventor-poi inventor-poi-pharmacy"></i>',
			'inventor-poi-phone' => '<i class="inventor-poi inventor-poi-phone"></i>',
			'inventor-poi-picture' => '<i class="inventor-poi inventor-poi-picture"></i>',
			'inventor-poi-pin' => '<i class="inventor-poi inventor-poi-pin"></i>',
			'inventor-poi-play' => '<i class="inventor-poi inventor-poi-play"></i>',
			'inventor-poi-plug' => '<i class="inventor-poi inventor-poi-plug"></i>',
			'inventor-poi-printer' => '<i class="inventor-poi inventor-poi-printer"></i>',
			'inventor-poi-pub' => '<i class="inventor-poi inventor-poi-pub"></i>',
			'inventor-poi-pushchair' => '<i class="inventor-poi inventor-poi-pushchair"></i>',
			'inventor-poi-radio' => '<i class="inventor-poi inventor-poi-radio"></i>',
			'inventor-poi-scissors' => '<i class="inventor-poi inventor-poi-scissors"></i>',
			'inventor-poi-shield' => '<i class="inventor-poi inventor-poi-shield"></i>',
			'inventor-poi-ship' => '<i class="inventor-poi inventor-poi-ship"></i>',
			'inventor-poi-shirt' => '<i class="inventor-poi inventor-poi-shirt"></i>',
			'inventor-poi-single-house' => '<i class="inventor-poi inventor-poi-single-house"></i>',
			'inventor-poi-snowflake' => '<i class="inventor-poi inventor-poi-snowflake"></i>',
			'inventor-poi-speaker' => '<i class="inventor-poi inventor-poi-speaker"></i>',
			'inventor-poi-star' => '<i class="inventor-poi inventor-poi-star"></i>',
			'inventor-poi-steak' => '<i class="inventor-poi inventor-poi-steak"></i>',
			'inventor-poi-theatre' => '<i class="inventor-poi inventor-poi-theatre"></i>',
			'inventor-poi-train' => '<i class="inventor-poi inventor-poi-train"></i>',
			'inventor-poi-trash' => '<i class="inventor-poi inventor-poi-trash"></i>',
			'inventor-poi-tree' => '<i class="inventor-poi inventor-poi-tree"></i>',
			'inventor-poi-trousers' => '<i class="inventor-poi inventor-poi-trousers"></i>',
			'inventor-poi-truck' => '<i class="inventor-poi inventor-poi-truck"></i>',
			'inventor-poi-umbrella' => '<i class="inventor-poi inventor-poi-umbrella"></i>',
			'inventor-poi-university' => '<i class="inventor-poi inventor-poi-university"></i>',
			'inventor-poi-villa' => '<i class="inventor-poi inventor-poi-villa"></i>',
			'inventor-poi-warehouse' => '<i class="inventor-poi inventor-poi-warehouse"></i>',
			'inventor-poi-warning' => '<i class="inventor-poi inventor-poi-warning"></i>',
			'inventor-poi-wi-fi' => '<i class="inventor-poi inventor-poi-wi-fi"></i>',
			'inventor-poi-winery' => '<i class="inventor-poi inventor-poi-winery"></i>',
			'inventor-poi-zoo' => '<i class="inventor-poi inventor-poi-zoo"></i>',
		);
	}

	/**
	 * Returns list of countries with their code and name
	 * @return array
	 */
	public static function get_countries() {
		return array(
			"AF" => "Afghanistan",
			"AL" => "Albania",
			"DZ" => "Algeria",
			"AS" => "American Samoa",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AQ" => "Antarctica",
			"AG" => "Antigua and Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria",
			"AZ" => "Azerbaijan",
			"BS" => "Bahamas",
			"BH" => "Bahrain",
			"BD" => "Bangladesh",
			"BB" => "Barbados",
			"BY" => "Belarus",
			"BE" => "Belgium",
			"BZ" => "Belize",
			"BJ" => "Benin",
			"BM" => "Bermuda",
			"BT" => "Bhutan",
			"BO" => "Bolivia",
			"BA" => "Bosnia and Herzegovina",
			"BW" => "Botswana",
			"BV" => "Bouvet Island",
			"BR" => "Brazil",
			"BQ" => "British Antarctic Territory",
			"IO" => "British Indian Ocean Territory",
			"VG" => "British Virgin Islands",
			"BN" => "Brunei",
			"BG" => "Bulgaria",
			"BF" => "Burkina Faso",
			"BI" => "Burundi",
			"KH" => "Cambodia",
			"CM" => "Cameroon",
			"CA" => "Canada",
			"CT" => "Canton and Enderbury Islands",
			"CV" => "Cape Verde",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic",
			"TD" => "Chad",
			"CL" => "Chile",
			"CN" => "China",
			"CX" => "Christmas Island",
			"CC" => "Cocos [Keeling] Islands",
			"CO" => "Colombia",
			"KM" => "Comoros",
			"CG" => "Congo - Brazzaville",
			"CD" => "Congo - Kinshasa",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"HR" => "Croatia",
			"CU" => "Cuba",
			"CY" => "Cyprus",
			"CZ" => "Czech Republic",
			"CI" => "Côte d’Ivoire",
			"DK" => "Denmark",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"NQ" => "Dronning Maud Land",
			"DD" => "East Germany",
			"EC" => "Ecuador",
			"EG" => "Egypt",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea",
			"ER" => "Eritrea",
			"EE" => "Estonia",
			"ET" => "Ethiopia",
			"FK" => "Falkland Islands",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland",
			"FR" => "France",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"TF" => "French Southern Territories",
			"FQ" => "French Southern and Antarctic Territories",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia",
			"DE" => "Germany",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GG" => "Guernsey",
			"GN" => "Guinea",
			"GW" => "Guinea-Bissau",
			"GY" => "Guyana",
			"HT" => "Haiti",
			"HM" => "Heard Island and McDonald Islands",
			"HN" => "Honduras",
			"HK" => "Hong Kong SAR China",
			"HU" => "Hungary",
			"IS" => "Iceland",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran",
			"IQ" => "Iraq",
			"IE" => "Ireland",
			"IM" => "Isle of Man",
			"IL" => "Israel",
			"IT" => "Italy",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JE" => "Jersey",
			"JT" => "Johnston Island",
			"JO" => "Jordan",
			"KZ" => "Kazakhstan",
			"KE" => "Kenya",
			"KI" => "Kiribati",
			"KW" => "Kuwait",
			"KG" => "Kyrgyzstan",
			"LA" => "Laos",
			"LV" => "Latvia",
			"LB" => "Lebanon",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libya",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania",
			"LU" => "Luxembourg",
			"MO" => "Macau SAR China",
			"MK" => "Macedonia",
			"MG" => "Madagascar",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives",
			"ML" => "Mali",
			"MT" => "Malta",
			"MH" => "Marshall Islands",
			"MQ" => "Martinique",
			"MR" => "Mauritania",
			"MU" => "Mauritius",
			"YT" => "Mayotte",
			"FX" => "Metropolitan France",
			"MX" => "Mexico",
			"FM" => "Micronesia",
			"MI" => "Midway Islands",
			"MD" => "Moldova",
			"MC" => "Monaco",
			"MN" => "Mongolia",
			"ME" => "Montenegro",
			"MS" => "Montserrat",
			"MA" => "Morocco",
			"MZ" => "Mozambique",
			"MM" => "Myanmar [Burma]",
			"NA" => "Namibia",
			"NR" => "Nauru",
			"NP" => "Nepal",
			"NL" => "Netherlands",
			"AN" => "Netherlands Antilles",
			"NT" => "Neutral Zone",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"NU" => "Niue",
			"NF" => "Norfolk Island",
			"KP" => "North Korea",
			"VD" => "North Vietnam",
			"MP" => "Northern Mariana Islands",
			"NO" => "Norway",
			"OM" => "Oman",
			"PC" => "Pacific Islands Trust Territory",
			"PK" => "Pakistan",
			"PW" => "Palau",
			"PS" => "Palestinian Territories",
			"PA" => "Panama",
			"PZ" => "Panama Canal Zone",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"YD" => "People's Democratic Republic of Yemen",
			"PE" => "Peru",
			"PH" => "Philippines",
			"PN" => "Pitcairn Islands",
			"PL" => "Poland",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar",
			"RO" => "Romania",
			"RU" => "Russia",
			"RW" => "Rwanda",
			"RE" => "Réunion",
			"BL" => "Saint Barthélemy",
			"SH" => "Saint Helena",
			"KN" => "Saint Kitts and Nevis",
			"LC" => "Saint Lucia",
			"MF" => "Saint Martin",
			"PM" => "Saint Pierre and Miquelon",
			"VC" => "Saint Vincent and the Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"SA" => "Saudi Arabia",
			"SN" => "Senegal",
			"RS" => "Serbia",
			"CS" => "Serbia and Montenegro",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore",
			"SK" => "Slovakia",
			"SI" => "Slovenia",
			"SB" => "Solomon Islands",
			"SO" => "Somalia",
			"ZA" => "South Africa",
			"GS" => "South Georgia and the South Sandwich Islands",
			"KR" => "South Korea",
			"ES" => "Spain",
			"LK" => "Sri Lanka",
			"SD" => "Sudan",
			"SR" => "Suriname",
			"SJ" => "Svalbard and Jan Mayen",
			"SZ" => "Swaziland",
			"SE" => "Sweden",
			"CH" => "Switzerland",
			"SY" => "Syria",
			"ST" => "São Tomé and Príncipe",
			"TW" => "Taiwan",
			"TJ" => "Tajikistan",
			"TZ" => "Tanzania",
			"TH" => "Thailand",
			"TL" => "Timor-Leste",
			"TG" => "Togo",
			"TK" => "Tokelau",
			"TO" => "Tonga",
			"TT" => "Trinidad and Tobago",
			"TN" => "Tunisia",
			"TR" => "Turkey",
			"TM" => "Turkmenistan",
			"TC" => "Turks and Caicos Islands",
			"TV" => "Tuvalu",
			"UM" => "U.S. Minor Outlying Islands",
			"PU" => "U.S. Miscellaneous Pacific Islands",
			"VI" => "U.S. Virgin Islands",
			"UG" => "Uganda",
			"UA" => "Ukraine",
			"SU" => "Union of Soviet Socialist Republics",
			"AE" => "United Arab Emirates",
			"GB" => "United Kingdom",
			"US" => "United States",
			"ZZ" => "Unknown or Invalid Region",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan",
			"VU" => "Vanuatu",
			"VA" => "Vatican City",
			"VE" => "Venezuela",
			"VN" => "Vietnam",
			"WK" => "Wake Island",
			"WF" => "Wallis and Futuna",
			"EH" => "Western Sahara",
			"YE" => "Yemen",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe",
			"AX" => "Åland Islands",
		);
	}

	/**
	 * Gets a number of terms and displays them as options
	 * @param  CMB2_Field $field
	 * @return array An array of options that matches the CMB2 options array
	 */
	public static function get_term_options( $field ) {
		$args = $field->args( 'get_terms_args' );
		$args = is_array( $args ) ? $args : array();

		$args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

		$taxonomy = $args['taxonomy'];

		$terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
			? get_terms( $args )
			: get_terms( $taxonomy, $args );

		// Initiate an empty array
		$term_options = array();
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$term_options[ $term->term_id ] = $term->name;
			}
		}

		return $term_options;
	}

	/**
	 * Returns excerpt of the given text
	 *
	 * @param string $text
	 * @param int $max_chars
	 * @return string
	 */
	public static function excerpt( $text, $max_chars ) {
		if ( strlen( $text ) > $max_chars ) {
			$text = substr( $text, 0, $max_chars );
			$text = substr( $text, 0, strrpos( $text, " " ) );
			$etc = "...";
			$text = $text . $etc;
		}

		return $text;
	}
}

Inventor_Utilities::init();