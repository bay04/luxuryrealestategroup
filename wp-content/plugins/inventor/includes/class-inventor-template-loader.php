<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Template_Loader
 *
 * @class Inventor_Template_Loader
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Template_Loader {
	/**
	 * Initialize template loader
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'template_include', array( __CLASS__, 'templates' ) );
	}

	/**
	 * Default templates
	 *
	 * @access public
	 * @param $template
	 * @return string
	 * @throws Exception
	 */
	public static function templates( $template ) {
		$post_type = get_post_type();
		$custom_post_types = Inventor_Post_Types::get_listing_post_types( true );

		if ( is_author() ) {
			return self::locate( 'author' );
		}

		if ( is_post_type_archive( $custom_post_types ) ) {
			if ( is_post_type_archive( 'listing' ) ) {
				return self::locate( 'archive-listing' );
			}

			try {
				return self::locate( 'archive-' . $post_type );
			} catch ( Exception $e ) {
				try {
					return self::locate( 'archive-listing' );
				} catch ( Exception $e ) {
					// Default template
				}
			}
		}

		if ( is_tax( Inventor_Taxonomies::get_listing_taxonomies() ) ) {
			$taxonomy = get_query_var( 'taxonomy' );

			try {
				return self::locate( 'taxonomy-' . $taxonomy );
			} catch ( Exception $e ) {
				try {
					return self::locate( 'taxonomy-listing' );
				} catch ( Exception $e ) {
					// Default template
				}
			}
		}

		if ( is_single() && in_array( $post_type, Inventor_Post_Types::get_listing_post_types() ) ) {
			try {
				return self::locate( 'single-' . $post_type );
			} catch ( Exception $e ) {
				try {					
					return self::locate( 'single-listing' );
				} catch (Exception $e) {
					// Default template
				}
			}
		}

		return $template;
	}

	/**
	 * Gets template path
	 *
	 * @access public
	 * @param $name
	 * @param $plugin_dir
	 * @return string
	 * @throws Exception
	 */
	public static function locate( $name, $plugin_dir = INVENTOR_DIR ) {
		$template = '';

		// Current theme base dir
		if ( ! empty( $name ) ) {
			$template = locate_template( "{$name}.php" );
		}

		// Child theme
		if ( ! $template && ! empty( $name ) && file_exists( get_stylesheet_directory() . "/templates/{$name}.php" ) ) {
			$template = get_stylesheet_directory() . "/templates/{$name}.php";
		}

		// Original theme
		if ( ! $template && ! empty( $name ) && file_exists( get_template_directory() . "/templates/{$name}.php" ) ) {
			$template = get_template_directory() . "/templates/{$name}.php";
		}

		// Plugin
		if ( ! $template && ! empty( $name ) && file_exists( $plugin_dir . "/templates/{$name}.php" ) ) {
			$template = $plugin_dir . "/templates/{$name}.php";
		}

		// Nothing found
		if ( empty( $template ) ) {
			throw new Exception( "Template /templates/{$name}.php in plugin dir {$plugin_dir} not found." );
		}

		return $template;
	}

	/**
	 * Loads template content
	 *
	 * @param string $name
	 * @param array  $args
	 * @param string $plugin_dir
	 * @return string
	 * @throws Exception
	 */
	public static function load( $name, $args = array(), $plugin_dir = INVENTOR_DIR ) {
        if ( is_array( $args ) && count( $args ) > 0 ) {
			extract( $args, EXTR_SKIP );
		}

		$path = self::locate( $name, $plugin_dir );
		ob_start();
		include $path;
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}
}

Inventor_Template_Loader::init();
