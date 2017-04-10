<?php

/**
 * Class Inventor_Admin_Updates
 *
 * @class Inventor_Admin_Updates
 * @package Inventor/Classes/Admin
 * @author Pragmatic Mates
 */
class Inventor_Admin_Updates {
	public static $plugins = array();

	/**
	 * Initialize
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'pre_set_site_transient_update_plugins', array( __CLASS__, 'check_plugins_update'));
		add_filter( 'pre_set_site_transient_update_themes', array( __CLASS__, 'check_theme_update'));

		$is_inventor = ! empty( $_GET['action'] ) && strpos( $_GET['action'], 'inventor', 0 );

		if ( defined( 'DOING_AJAX' ) && false === $is_inventor ) {
			add_action( 'site_transient_update_plugins', array( __CLASS__, 'check_plugins_update' ) );
			add_action( 'site_transient_update_themes', array( __CLASS__, 'check_theme_update' ) );
		}

		add_action( 'wp', array( __CLASS__, 'check_purchase_code' ) );
		add_action( 'wp_ajax_inventor_verify_purchase_code', array( __CLASS__, 'verify_purchase_code' ) );
	}

	/**
	 * Makes a call to the WP License Manager API.
	 *
	 * @param $params   array   The parameters for the API call
	 * @return          array   The API response
	 */
	public static function call_api( $action, $params ) {
		$url = INVENTOR_API_ENDPOINT . $action;

		// Append parameters for GET request
		$url .= '?' . http_build_query( $params );

		// Send the request
		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$response_body = wp_remote_retrieve_body( $response );
		$result = json_decode( $response_body );

		return $result;
	}

	/**
	 * Downloads plugins data from server
	 *
	 * @access public
	 * @return array
	 */
	public static function fetch_plugins() {
		$purchase_code = get_theme_mod( 'inventor_purchase_code', null );
		$params = array();
		if ( ! empty( $purchase_code ) ) {
			$params['purchase-code'] = $purchase_code;
		}

		return self::call_api( 'plugins', $params );
	}

	/**
	 * Downloads theme data from server
	 *
	 * @access public
	 * @return array
	 */
	public static function fetch_theme() {
		$purchase_code = get_theme_mod( 'inventor_purchase_code', null );
		$params = array();
		if ( ! empty( $purchase_code ) ) {
			$params['purchase-code'] = $purchase_code;
		}

		$theme_data = wp_get_theme();
		$theme_slug = $theme_data->get_template();

		return self::call_api( 'themes/' . $theme_slug, $params );
	}

	/**
	 * Returns plugin version of local installation
	 *
	 * @param $plugin_file string   Path to main plugin file.
	 * @return string   			The plugin version of the local installation.
	 */
	public static function get_local_plugin_version( $plugin_file ) {
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
			return null;
		}

		$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_file, false );
		return $plugin_data['Version'];
	}

	/**
	 * Returns theme version of local installation
	 *
	 * @param $child_theme boolean	Return child theme version instead of parent theme (if any)
	 * @return string   			The theme version of the local installation.
	 */
	public static function get_local_theme_version( $child_theme = false ) {
		$theme_data = wp_get_theme();

		if ( $theme_data->parent() && ! $child_theme ) {
			return $theme_data->parent()->__get( 'Version' );
		}
		return $theme_data->Version;
	}

	/**
	 * Check for plugin updates
	 *
	 * @access public
	 * @param $transient
	 */
	public static function check_plugins_update( $transient ) {
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		if ( count( self::$plugins ) == 0 ) {
			$plugins = self::fetch_plugins();
			if ( empty ( $plugins ) ) {
				return $transient;
			}

			self::$plugins = $plugins;
		}

		if ( is_array( self::$plugins ) ) {
			foreach ( self::$plugins as $plugin ) {
				if ( empty( $plugin->current_version ) ) {
					continue;
				}

				$plugin_file = sprintf( '%s/%s.php', $plugin->slug, $plugin->slug );
				$local_version = self::get_local_plugin_version( $plugin_file );
				$is_new_version = version_compare( $local_version, $plugin->current_version, '<' );

				if ( $is_new_version ) {
					$transient_data = (object) self::get_transient_data( $plugin );
					$transient_data->plugin = $plugin_file;
					$transient->response[ $plugin_file ] = $transient_data;
//					$transient->response[ $plugin->slug ] = $transient_data;
				}
			}
		}

		return $transient;
	}

	/**
	 * Check for theme update
	 *
	 * @access public
	 * @param $transient
	 */
	public static function check_theme_update( $transient ) {
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$theme = self::fetch_theme();

		if ( empty ( $theme ) ) {
			return $transient;
		}

		if ( empty( $theme->current_version ) ) {
			return $transient;
		}

		$local_version = self::get_local_theme_version();
		$is_new_version = version_compare( $local_version, $theme->current_version, '<' );

		if ( $is_new_version ) {
			$transient_data = self::get_transient_data( $theme );
			$transient->response[ $theme->slug ] = $transient_data;
		}

		return $transient;
	}

	public static function get_transient_data( $api_object ) {
		$data = array(
			'id' => 0,
			'slug' => $api_object->slug,
			'new_version' => $api_object->current_version,
			'url' => $api_object->information,
			'upgrade_notice' => ''
		);

		$purchase_code = get_theme_mod( 'inventor_purchase_code', null );

		// Purchase code is valid so the package is available
		if ( ! empty( $api_object->package ) && ! empty( $purchase_code ) ) {
			$data['package'] = sprintf('%s?purchase-code=%s', $api_object->package, $purchase_code );
		}

		return $data;
	}

	public static function check_purchase_code() {
		$transient = get_site_transient( 'update_plugins' );
		$purchase_code = get_theme_mod( 'inventor_purchase_code', null );

		if ( empty( $purchase_code ) ) {
			if ( is_array( $transient->no_update ) ) {
				foreach ( $transient->no_update as $key => $value ) {
					if ( substr( $key, 0, strlen( 'inventor' ) ) === 'inventor' ) {
						if ( ! empty( $value['package'] ) ) {
							$transient->no_update[$value]['package'];
						}
					}
				}
			}
		}

		set_site_transient('update_plugins', $transient );
	}

	/**
	 * Verify purchase code
	 *
	 * @access public
	 * @return void
	 */
	public static function verify_purchase_code() {
		header( 'HTTP/1.0 200 OK' );
		header( 'Content-Type: application/json' );

		// Missing purchase code
		if ( empty( $_GET['purchase-code'] ) ) {
			echo json_encode( array(
				'valid' => false,
			) );

			exit;
		}

		// Check the purchase code on server
		$response = wp_remote_get( INVENTOR_API_VERIFY_URL . '?purchase-code=' . $_GET['purchase-code'] );

		// Server is not responding or an error occurred
		if ( $response instanceof WP_Error ) {
			echo json_encode( array(
				'valid' => false,
//				'error' => true,
			) );

			exit();
		}

		$result = json_decode( $response['body'] );

		// Purchase code is valid
		if ( '1' == $result->valid ) {
			set_theme_mod( 'inventor_purchase_code', $_GET['purchase-code'] );

			echo json_encode( array(
				'valid' => true,
			) );

			exit();
		}

		echo json_encode( array(
			'valid' => false,
		) );

		exit();
	}
}

Inventor_Admin_Updates::init();