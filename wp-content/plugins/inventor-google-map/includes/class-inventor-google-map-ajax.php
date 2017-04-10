<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Google_Map_Ajax
 *
 * @class Inventor_Google_Map_Ajax
 * @package Inventor_Google_Map_Ajax
 * @author Pragmatic Mates
 */
class Inventor_Google_Map_Ajax {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_ajax_nopriv_inventor_filter_listings', array( __CLASS__, 'filter' ) );
		add_action( 'wp_ajax_inventor_filter_listings', array( __CLASS__, 'filter' ) );
		add_action( 'save_post', array( __CLASS__, 'invalidate_cache' ) );
	}

	/**
	 * Remove all cached AJAX responses
	 */
	public static function invalidate_cache() {
		global $wpdb;
		$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'inventor_google_map_ajax_%'" );
	}

	/**
	 * Filter all listings through AJAX
	 *
	 * @access public
	 * @return string
	 */
	public static function filter() {
		header( 'HTTP/1.0 200 OK' );
		header( 'Content-Type: application/json' );

		$uri = md5( $_SERVER['REQUEST_URI'] );
		$cache = get_option( "inventor_google_map_ajax_{$uri}", 0 );

		// filter parameters
		$filter_params = $_GET;
		$filter_params['context'] = 'map';

		$use_cache = apply_filters( 'inventor_google_map_use_cache', true, $filter_params );

		if ( $cache && $use_cache ) {
			echo $cache;
			exit();
		}

		// markers
		$markers = array();

		// post type
		$post_types = Inventor_Post_Types::get_listing_post_types();

		if ( ! empty( $_GET['post-type'] ) ) {
			$post_types = $_GET['post-type'];
		}

		// term
		if ( ! empty( $_GET['term'] ) && ! empty( $_GET['term-taxonomy'] ) && empty( $filter_params[ $_GET['term-taxonomy'] ] ) ) {
			$filter_params[ $_GET['term-taxonomy'] ] = $_GET['term'];
		}

		// order
		if ( ! empty( $_GET['orderby'] ) ) {
			if ( $_GET['orderby'] == 'rand' ) {
				$filter_params['sort-by'] = 'rand';
			}
		}

		// count
		$count = -1;
		if ( ! empty( $_GET['max-pins'] ) ) {
			$filter_params['count'] = $_GET['max-pins'];
			$count = $_GET['max-pins'];
		}

		$query = Inventor_Query::get_listings( $count, $filter_params, $post_types, 'publish' );

		$query->posts = $query->get_posts();

		if ( $query->have_posts() ) {

			while ( $query->have_posts() ) {
				$query->the_post();

				$latitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_latitude', true );
				$longitude = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_longitude', true );

				$content = str_replace( array( "\r\n", "\n", "\t" ), '', Inventor_Template_Loader::load( 'google-map/infowindow', array(), INVENTOR_GOOGLE_MAP_DIR ) );
				$marker_content = str_replace( array( "\r\n", "\n", "\t" ), '', Inventor_Template_Loader::load( 'google-map/marker', array(), INVENTOR_GOOGLE_MAP_DIR ) );

				// Array of values passed into markers[] array in jquery-google-map.js library
				$markers[] = array(
					'latitude'          => $latitude,
					'longitude'         => $longitude,
					'content'           => $content,
					'marker_content'    => $marker_content,
				);
			}
		}

		$markers = json_encode( $markers );
		update_option( "inventor_google_map_ajax_{$uri}", $markers );
		echo $markers;
		exit();
	}
}

Inventor_Google_Map_Ajax::init();