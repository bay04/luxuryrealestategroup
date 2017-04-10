<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Properties_Post_Types
 *
 * @class Inventor_Properties_Post_Types
 * @package Inventor/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Properties_Post_Types {
    /**
     * Initialize listing types
     *
     * @access public
     * @return void
     */
    public static function init() {
        self::includes();
    }

    /**
     * Loads listing types
     *
     * @access public
     * @return void
     */
    public static function includes() {
        require_once INVENTOR_PROPERTIES_DIR . 'includes/post-types/class-inventor-properties-post-type-property.php';
    }
}

Inventor_Properties_Post_Types::init();