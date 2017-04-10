<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Mail_Templates_Logic
 *
 * @class Inventor_Mail_Templates_Logic
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Mail_Templates_Logic {
    /**
     * Initialize filtering
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_filter( 'inventor_mail_subject', array( __CLASS__, 'mail_template_subject' ), 10, 3 );
        add_filter( 'inventor_mail_body', array( __CLASS__, 'mail_template_body' ), 10, 3 );
    }

    /**
     * Returns mail template by action
     *
     * @access public
     * @param string $action
     * @return object
     */
    public static function get_mail_template_by_action( $action ) {
        $query = new WP_Query( array(
            'post_type'         => 'mail_template',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'meta_key'          => INVENTOR_MAIL_TEMPLATE_PREFIX . 'action',
            'meta_value'        => $action
        ) );

        if ( count( $query->posts ) > 0 ) {
            return $query->posts[0];
        }

        return null;
    }

    /**
     * Modifies mail template subject
     *
     * @access public
     * @return array
     */
    public static function mail_template_subject( $subject, $action, $args ) {
        $mail_template = self::get_mail_template_by_action( $action );

        if ( ! empty( $mail_template ) ) {
            $title = get_the_title( $mail_template );
            return self::pass_variables( $title, $args );
        }

        return $subject;
    }

    /**
     * Modifies mail template body
     *
     * @access public
     * @return array
     */
    public static function mail_template_body( $body, $action, $args ) {
        $mail_template = self::get_mail_template_by_action( $action );

        if ( ! empty( $mail_template ) ) {
            $content = $mail_template->post_content;
            $content = apply_filters( 'the_content', $content );
            $content = str_replace( ']]>', ']]&gt;', $content );
            return self::pass_variables( $content, $args );
        }

        return $body;
    }

    /**
     * Replaces occurrences of all found variables
     *
     * @access public
     * @param $string string
     * @param $args array
     * @return array
     */
    public static function pass_variables( $string, $args ) {
        $variable_names = array();
        $variable_values = array();

        foreach ( $args as $key => $value ) {
            $variable_names[] = sprintf( '{%s}', $key );
            $variable_values[] = $value;
        }

        return str_replace( $variable_names, $variable_values, $string );
    }
}

Inventor_Mail_Templates_Logic::init();