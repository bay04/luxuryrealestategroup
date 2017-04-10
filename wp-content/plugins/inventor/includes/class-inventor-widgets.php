<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Widgets
 *
 * @class Inventor_Widgets
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widgets {
	/**
	 * Initialize widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		self::includes();
		add_action( 'widgets_init', array( __CLASS__, 'register' ) );
		add_action( 'sidebars_widgets', array( __CLASS__, 'remove_empty_sidebars_widgets' ) );
	}

	/**
	 * Include widget classes
	 *
	 * @access public
	 * @return void
	 */
	public static function includes() {
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-filter.php';
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-users.php';
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-listings.php';
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-listing-author.php';
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-listing-categories.php';
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-listing-details.php';
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-listing-inquire.php';
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-listing-types.php';
		require_once INVENTOR_DIR . 'includes/widgets/class-inventor-widget-opening-hours.php';
	}

	/**
	 * Register widgets
	 *
	 * @access public
	 * @return void
	 */
	public static function register() {
		register_widget( 'Inventor_Widget_Filter' );
		register_widget( 'Inventor_Widget_Users' );
		register_widget( 'Inventor_Widget_Listings' );
		register_widget( 'Inventor_Widget_Listing_Author' );
		register_widget( 'Inventor_Widget_Listing_Categories' );
		register_widget( 'Inventor_Widget_Listing_Details' );
		register_widget( 'Inventor_Widget_Listing_Inquire' );
		register_widget( 'Inventor_Widget_Listing_Types' );
		register_widget( 'Inventor_Widget_Opening_Hours' );
	}

	/**
	 * Checks widgets visibility
	 *
	 * @access public
	 * @param $instance
	 * @return boolean
	 */
	public static function is_widget_visible( $instance ) {
		$default =
			empty( $instance['front_page'] ) &&
			empty( $instance['pages'] ) &&
			empty( $instance['listing_detail'] ) &&
			empty( $instance['listing_archive'] ) &&
			empty( $instance['listing_taxonomies'] );

		// front page
		if ( is_front_page() && ! empty( $instance['front_page'] ) ) {
			return true;
		}

		// pages
		if ( ! empty( $instance['pages'] ) ) {
			$pages = explode( ',', $instance['pages'] );
			return is_page( $pages );
		}

		// listing post types
		$listing_post_types = Inventor_Post_Types::get_listing_post_types( $include_abstract = true );

		// listing detail
		if ( is_singular( $listing_post_types ) && ! empty( $instance['listing_detail'] ) ) {
			return true;
		}

		// listing archive page
		if ( is_post_type_archive( $listing_post_types ) && ! empty( $instance['listing_archive'] ) ) {
			return true;
		}

		// listing taxonomies archive page
		if ( is_tax( Inventor_Taxonomies::get_listing_taxonomies() ) && ! empty( $instance['listing_taxonomies'] ) ) {
			return true;
		}

		return $default;
	}

	/**
	 * Widget visibility can hide widget content, but it is still in the sidebar.
	 * We need to remove hidden widgets from the list of widgets which are going to render.
	 *
	 * @access public
	 * @param $sidebars_widgets
	 * @return array
	 */
	public static function remove_empty_sidebars_widgets( $sidebars_widgets ) {
		if( is_admin() ) {
			return $sidebars_widgets;
		}

		// loop through every widget in every sidebar (barring 'wp_inactive_widgets') checking visibility for each one
		foreach ( $sidebars_widgets as $widget_area => $widget_list ) {
			if ( $widget_area == 'wp_inactive_widgets' || empty( $widget_list ) ) continue;

			foreach ( $widget_list as $pos => $widget_id ) {
				$widget_base_id = preg_replace('/-([0-9]+)$/', '$2', $widget_id);
				$number = preg_replace('/.+?-([0-9]+)$/', '$1', $widget_id);
				$instances = get_option( 'widget_' . $widget_base_id );

				if ( array_key_exists( $number, $instances ) ) {
					$instance = $instances[$number];

					if ( ! self::is_widget_visible( $instance ) ) {
						unset ( $sidebars_widgets[ $widget_area ][ $pos ] );
					}
				}
			}
		}
		return $sidebars_widgets;
	}
}

Inventor_Widgets::init();