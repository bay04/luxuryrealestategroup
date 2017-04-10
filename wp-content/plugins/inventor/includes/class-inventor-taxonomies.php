<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Inventor_Taxonomies
 *
 * @class Inventor_Taxonomies
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Taxonomies {
	/**
	 * Initialize taxonomies
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		self::includes();
	}

	/**
	 * Includes all taxonomies
	 *
	 * @access public
	 * @return void
	 */
	public static function includes() {
		require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-colors.php';
		require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-locations.php';
		require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-listing-categories.php';

        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-car-models.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-car-body-styles.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-car-engine-types.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-car-transmissions.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-dating-groups.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-dating-interests.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-dating-statuses.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-education-levels.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-education-subjects.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-event-types.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-food-kinds.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-meals-and-drinks-sections.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-hotel-classes.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-pet-animals.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-shopping-categories.php';
        require_once INVENTOR_DIR . 'includes/taxonomies/class-inventor-taxonomy-travel-activities.php';
    }

	/**
	 * Get list of available taxonomies
	 *
	 * @access public
	 * @return array
	 */
	public static function get_listing_taxonomies() {
		$taxonomies = array();
		$all_taxonomies = get_taxonomies( array(), 'objects' );
		$post_types = Inventor_Post_Types::get_listing_post_types();

		if ( ! empty( $all_taxonomies ) && ! empty( $post_types ) ) {
			foreach ( $all_taxonomies as $taxonomy ) {
				if ( count( array_intersect( $post_types, $taxonomy->object_type ) ) > 0 ) {
					$taxonomies[] = $taxonomy->name;
				}
			}
		}
		return $taxonomies;
	}
}

Inventor_Taxonomies::init();
