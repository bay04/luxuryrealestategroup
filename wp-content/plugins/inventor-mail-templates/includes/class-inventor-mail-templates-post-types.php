<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Mail_Templates_Post_Types
 *
 * @class Inventor_Mail_Templates_Post_Types
 * @package Inventor_Mail_Templates/Classes
 * @author Pragmatic Mates
 */
class Inventor_Mail_Templates_Post_Types {
    /**
     * Initialize post types
     *
     * @access public
     * @return void
     */
    public static function init() {
        self::includes();
    }

    /**
     * Loads post types
     *
     * @access public
     * @return void
     */
    public static function includes() {
        require_once INVENTOR_MAIL_TEMPLATES_DIR . 'includes/post-types/class-inventor-mail-templates-post-type-mail-template.php';
    }
}

Inventor_Mail_Templates_Post_Types::init();
