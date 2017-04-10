<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Social
 *
 * @class Inventor_Social
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Social {
    /**
     * Initialize social
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'wp_head', array( __CLASS__, 'open_graph_meta' ), 1 );
    }

    /**
     * The Open Graph protocol meta
     * http://ogp.me/
     *
     * @access public
     * @return string
     */
    public static function open_graph_meta() {
        if ( is_singular() ) {
            echo '<meta property="og:title" content="' . get_the_title() . '" />';
            $thumbnail_id = get_post_thumbnail_id();
            if ( ! empty( $thumbnail_id ) ) {
                $image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
                echo '<meta property="og:image" content="' . esc_attr( $image[0] ) . '" />';
            }
        }
    }
}

Inventor_Social::init();