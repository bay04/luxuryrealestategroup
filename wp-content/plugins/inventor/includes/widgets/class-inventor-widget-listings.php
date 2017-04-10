<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Widget_Listings
 *
 * @class Inventor_Widget_Listings
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Listings extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'listings',
			__( 'Listings', 'inventor' ),
			array(
				'description' => __( 'Displays listings.', 'inventor' ),
			)
		);
	}

	/**
	 * Frontend
	 *
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		// TODO: replace functionality with the Inventor_Query::get_listings() helper

		$query = array(
			'post_type'         => Inventor_Post_Types::get_listing_post_types(),
			'posts_per_page'    => ! empty( $instance['count'] ) ? $instance['count'] : 3,
			'tax_query'         => array(
				'relation'      => 'AND',
			),
		);

		$meta = array();

		if ( ! empty( $instance['order'] ) ) {
			if ( 'rand' == $instance['order'] ) {
				$query['orderby'] = 'rand';
			}

			if ( 'ids' == $instance['order'] ) {
				$query['orderby'] = 'post__in';
			}
		}

		if ( ! empty( $instance['attribute'] ) ) {
			if ( 'featured' == $instance['attribute'] ) {
				$meta[] = array(
					'key'       => INVENTOR_LISTING_PREFIX . 'featured',
					'value'     => 'on',
					'compare'   => '=',
				);
			} elseif ( 'reduced' == $instance['attribute'] ) {
				$meta[] = array(
					'key'       => INVENTOR_LISTING_PREFIX . 'reduced',
					'value'     => 'on',
					'compare'   => '=',
				);
			}
		}

		// Listing types
		$listing_types = array();

		// Listing types: pickup
		if ( ! empty( $instance['listing_types'] ) && is_array( $instance['listing_types'] ) ) {
			$query['post_type'] = $instance['listing_types'];
		}

		// Similar type
		if ( ! empty( $instance['order'] ) && 'similar' == $instance['order'] ) {
			if ( ! empty( $instance['similar_type'] ) ) {
				$post_type = get_post_type();
				$listing_types = array_merge( $listing_types, array( $post_type ) );
			}
		}

		if ( ! empty( $listing_types ) ) {
			$query['post_type'] = $listing_types;
		}

		// Listing categories
		$listing_categories = array();

		// Listing categories: pickup
		if ( ! empty( $instance['listing_categories'] ) && is_array( $instance['listing_categories'] ) ) {
			$listing_categories = $instance['listing_categories'];
		}

		// Similar category
		if ( ! empty( $instance['order'] ) && 'similar' == $instance['order'] ) {
			if ( ! empty( $instance['similar_category'] ) ) {
				$categories = wp_get_post_terms( get_the_ID(), 'listing_categories' );
				$categories_ids = wp_list_pluck( $categories, 'term_id' );
				$listing_categories = array_merge( $listing_categories, $categories_ids );
			}
		}

		if ( ! empty( $listing_categories ) ) {
			$query['tax_query'][] = array(
				'taxonomy'  => 'listing_categories',
				'field'     => 'id',
				'terms'     => $listing_categories,
			);
		}

		// Listing location
		$location = array();

		// Location: pickup
		if ( ! empty( $instance['locations'] ) && is_array( $instance['locations'] ) ) {
			$location = $instance['locations'];
		}

		// Similar location
		if ( ! empty( $instance['order'] ) && 'similar' == $instance['order'] ) {
			if ( ! empty( $instance['similar_location'] ) ) {
				$locations = wp_get_post_terms( get_the_ID(), 'locations' );
				$locations_ids = wp_list_pluck( $locations, 'term_id' );
				$location = array_merge( $location, $locations_ids );
			}
		}

		if ( ! empty( $location ) ) {
			$query['tax_query'][] = array(
				'taxonomy'  => 'locations',
				'field'     => 'id',
				'terms'     => $location,
			);
		}

		// Similar price
		if ( ! empty( $instance['order'] ) && 'similar' == $instance['order'] ) {
			if ( ! empty( $instance['similar_price'] ) ) {
				$price = Inventor_Price::get_listing_price( get_the_ID() );

				if ( ! empty( $price ) ) {
					$price_range = array(
						'from'	=> (int)((float) $price / 1.2),
						'to'	=> $price * 1.2
					);

					// Price from
					$meta[] = array(
						'key'       =>  INVENTOR_LISTING_PREFIX . 'price',
						'value'     => $price_range['from'],
						'compare'   => '>=',
						'type'      => 'NUMERIC',
					);

					// Price to
					$meta[] = array(
						'key'       => INVENTOR_LISTING_PREFIX . 'price',
						'value'     => $price_range['to'],
						'compare'   => '<=',
						'type'      => 'NUMERIC',
					);
				}
			}
		}

		// IDs
		if ( ! empty( $instance['ids'] ) ) {
			$ids = explode( ',', $instance['ids'] );
			$query['post__in'] = $ids;
		}

		// Meta
		if ( ! empty( $meta ) ) {
			$query['meta_query'] = $meta;
		}

		// Customising query
		$query = apply_filters( 'inventor_widget_listings_query', $query, $instance );

		query_posts( $query );
		include Inventor_Template_Loader::locate( 'widgets/listings' );
		wp_reset_query();
	}

	/**
	 * Update
	 *
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Backend
	 *
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		include Inventor_Template_Loader::locate( 'widgets/listings-admin' );
		include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
		include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
	}
}