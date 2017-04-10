<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Query
 *
 * @class Inventor_Query
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Query {
	/**
	 * Gets user listings query
	 *
	 * @access public
	 * @param int $user_id
	 * @param string $post_status
	 * @param string $post_type
	 * @param bool $count_only
	 * @return mixed
	 */
	public static function get_listings_by_user( $user_id = null, $post_status = 'any', $post_type = null, $count_only = false ) {
		$user_id = $user_id == null ? get_current_user_id() : $user_id;
		$post_type = $post_type == null ? Inventor_Post_Types::get_listing_post_types() : $post_type;

		$query = new WP_Query( array(
			'author'            => $user_id,
			'post_type'         => $post_type,
			'posts_per_page'    => -1,
			'post_status'       => $post_status,
		) );

		return $count_only ? $query->post_count : $query;
	}

	/**
	 * Returns listings query by post type
	 *
	 * @access public
	 * @param string $post_type
	 * @return WP_Query
	 */
	public static function get_listings_by_post_type( $post_type ) {
		if ( ! in_array( $post_type, Inventor_Post_Types::get_listing_post_types() ) ) {
			return null;
		}

		return new WP_Query( array(
			'post_type'         => array( $post_type ),
			'posts_per_page'    => -1,
			'post_status'       => 'any',
		) );
	}

	/**
	 * Returns all listings
	 *
	 * @access public
	 * @return WP_Query
	 */
	public static function get_all_listings() {
		return self::get_listings();
	}

	/**
	 * Returns listings
	 *
	 * @access public
	 * @param $count
	 * @param $filter_params
	 * @param $post_types
	 * @param $post_status
	 * @return WP_Query
	 */
	public static function get_listings( $count = -1, $filter_params = null, $post_types = null, $post_status = 'any' ) {
		$post_types = empty( $post_types ) ? Inventor_Post_Types::get_listing_post_types() : $post_types;

		$query = new WP_Query( array(
			'post_type'         => $post_types,
			'posts_per_page'    => $count,
			'post_status'       => $post_status,
		) );

		if ( $filter_params != null ) {
			return Inventor_Filter::filter_query( $query, $filter_params );
		}

		return $query;
	}

	/**
	 * Gets listing location name
	 *
	 * @access public
	 * @param null   $post_id
	 * @param string $separator
	 * @param bool $hierarchical
	 * @return bool|string
	 */
	public static function get_listing_location_name( $post_id = null, $separator = ' / ', $hierarchical = true ) {
		return self::get_taxonomy_tree_value( 'locations', $post_id, $separator, $hierarchical );
	}

	/**
	 * Gets listing category name
	 *
	 * @access public
	 * @param null $post_id
	 * @param string $separator
	 * @param bool $hierarchical
	 * @return bool
	 */
	public static function get_listing_category_name( $post_id = null, $separator = ' / ', $hierarchical = false ) {
		$category_name = self::get_taxonomy_tree_value( 'listing_categories', $post_id, $separator, $hierarchical, true );
		$category_name = apply_filters( 'inventor_listing_category_name', $category_name, $post_id, $separator, $hierarchical );
		return $category_name;
	}

	/**
	 * Returns taxonomy tree value
	 *
	 * @access public
	 * @param $taxonomy
	 * @param null $post_id
	 * @param string $separator
	 * @param bool $hierarchical
	 * @param bool $oldest_parent
	 * @return bool
	 */
	public static function get_taxonomy_tree_value( $taxonomy, $post_id = null, $separator = ' / ', $hierarchical = true, $oldest_parent = false ) {
		if ( empty ( $post_id ) ) {
			$post_id = get_the_ID();
		}

		if ( ! empty( $taxonomy_tree[ $post_id ] ) ) {
			return $taxonomy_tree[ $post_id ];
		}

		$terms = wp_get_post_terms( $post_id, $taxonomy, array(
			'orderby'   => 'parent',
			'order'     => 'ASC',
		) );

		if ( is_array( $terms ) && count( $terms ) > 0 ) {
			$output = '';

			if ( true === $hierarchical ) {
				foreach ( $terms as $key => $term ) {
					$output .= '<a href="' . get_term_link( $term, $taxonomy ). '">' . $term->name . '</a>';

					if ( array_key_exists( $key + 1, $terms ) ) {
						$output .= '<span class="separator">' . $separator . '</span> ';
					}
				}
			} else {
				if ( $oldest_parent ) {
					$output = '<a href="' . get_term_link( end( $terms ), $taxonomy ). '">' . end( $terms )->name . '</a>';

					$result_term = null;
					if ( is_array( $terms ) && count( $terms ) > 0 ) {
						$depth = -1;
						foreach ( $terms as $term ) {
							$current_depth = count( get_ancestors( $term->term_id, $taxonomy ) );
							if ( $current_depth > $depth ) {
								$result_term = $term;
								$depth = $current_depth;
							}
						}

						if ( $result_term ) {
							$output = '<a href="' . get_term_link( $result_term ) . '">' . $result_term->name . '</a>';
						}
					}
				} else {
					$output = '<a href="' . get_term_link( end( $terms ), $taxonomy ). '">' . end( $terms )->name . '</a>';
				}
			}

			$taxonomy_tree[ $post_id ] = $output;
			return $output;
		}

		return false;
	}

	/**
	 * Checks if there is another post in query
	 *
	 * @access public
	 * @return bool
	 */
	public static function loop_has_next() {
		global $wp_query;

		if ( $wp_query->current_post + 1 < $wp_query->post_count ) {
			return true;
		}

		return false;
	}
}