<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Class Inventor_Properties_Taxonomies
 *
 * @class Inventor_Properties_Taxonomies
 * @package Inventor/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Properties_Taxonomies {
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
        require_once INVENTOR_PROPERTIES_DIR . 'includes/taxonomies/class-inventor-properties-taxonomy-property-amenities.php';
        require_once INVENTOR_PROPERTIES_DIR . 'includes/taxonomies/class-inventor-properties-taxonomy-property-types.php';
    }
}

Inventor_Properties_Taxonomies::init();
