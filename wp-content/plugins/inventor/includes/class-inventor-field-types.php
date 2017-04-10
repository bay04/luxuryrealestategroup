<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Field_Types
 *
 * @class Inventor_Field_Types
 * @package Inventor/Classes/Field_Types
 * @author Pragmatic Mates
 */
class Inventor_Field_Types {
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
     * Loads field types
     *
     * @access public
     * @return void
     */
    public static function includes() {
        require_once INVENTOR_DIR . 'includes/field-types/class-inventor-field-types-unique-user-email.php';
        require_once INVENTOR_DIR . 'includes/field-types/class-inventor-field-types-opening-hours.php';
        require_once INVENTOR_DIR . 'includes/field-types/class-inventor-field-types-phone.php';
        require_once INVENTOR_DIR . 'includes/field-types/class-inventor-field-types-taxonomy-multicheck-hierarchy.php';
        require_once INVENTOR_DIR . 'includes/field-types/class-inventor-field-types-taxonomy-select-hierarchy.php';
        require_once INVENTOR_DIR . 'includes/field-types/class-inventor-field-types-taxonomy-select-chain.php';
    }
}

Inventor_Field_Types::init();
