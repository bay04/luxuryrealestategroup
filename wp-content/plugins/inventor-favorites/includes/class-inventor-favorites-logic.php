<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Favorites_Logic
 *
 * @class Inventor_Favorites_Logic
 * @package Inventor_Favorites/Classes
 * @author Pragmatic Mates
 */
class Inventor_Favorites_Logic {
    /**
     * Initialize Favorites functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'process_collection_form' ), 9999 );
        add_action( 'template_redirect', array( __CLASS__, 'feed_catch_template' ), 0 );
        add_action( 'wp_footer', array( __CLASS__, 'render_favorite_collections' ), 0 );
        add_action( 'wp_ajax_nopriv_inventor_favorites_remove_favorite', array( __CLASS__, 'remove_favorite' ) );
        add_action( 'wp_ajax_inventor_favorites_remove_favorite', array( __CLASS__, 'remove_favorite' ) );
        add_action( 'wp_ajax_nopriv_inventor_favorites_add_favorite', array( __CLASS__, 'add_favorite' ) );
        add_action( 'wp_ajax_inventor_favorites_add_favorite', array( __CLASS__, 'add_favorite' ) );
        add_action( 'inventor_listing_detail', array( __CLASS__, 'render_total_favorite_users' ), 1, 1 );
        add_action( 'inventor_google_map_infobox', array( __CLASS__,  'render_favorite_button' ), 0, 1 );
        add_action( 'inventor_listing_actions', array( __CLASS__, 'render_favorite_button' ), 0, 1 );
        add_filter( 'query_vars', array( __CLASS__, 'add_query_vars' ) );
    }

    /**
     * Gets config
     *
     * @access public
     * @return array
     */
    public static function get_config() {
        return array(
            "favorites_page"            => get_theme_mod( 'inventor_favorites_page', false ),
            "create_collection_page"    => get_theme_mod( 'inventor_favorites_create_collection_page', false ),
        );
    }

    /**
     * Adds query vars
     *
     * @access public
     * @param $vars
     * @return array
     */
    public static function add_query_vars( $vars ) {
        $vars[] = 'favorites-feed';
        return $vars;
    }

    /**
     * Removes listing from list
     *
     * @access public
     * @return string
     */
    public static function remove_favorite() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        if( ! is_user_logged_in() ) {
            $data = array(
                'success' => false,
                'message' => __( 'You need to log in at first.', 'inventor-favorites' ),
            );
        } else if ( ! empty( $_GET['id'] ) ) {
            $user_id = get_current_user_id();

            $favorites = get_user_meta( $user_id, 'favorites', true );

            if ( ! empty( $favorites ) && is_array( $favorites ) ) {
                foreach ( $favorites as $index => $listing_id ) {
                    if ( $listing_id == $_GET['id'] ) {
                        unset( $favorites[ $index ] );
                    }
                }

                update_user_meta( $user_id, 'favorites', $favorites );

                $collections = self::get_user_collections( $user_id );

                // remove from specific collection
                if ( ! empty( $_GET['collection-id'] ) ) {
                    $collection_id = (int) $_GET['collection-id'];

                    if ( ! empty( $collections[ $collection_id ] ) ) {
                        $collection = $collections[ $collection_id ];

                        if ( in_array( $_GET['id'], $collection['listings'] ) ) {
                            foreach ( $collection['listings'] as $index => $listing_id ) {
                                if ( $listing_id == $_GET['id'] ) {
                                    unset( $collection['listings'][ $index ] );
                                }
                            }

                            $collections[ $collection_id ] = $collection;
                            update_user_meta( $user_id, 'collections', $collections );
                        }
                    }
                }

                // remove from collections
                foreach( $collections as $collection_id => $collection ) {
                    $collection = $collections[ $collection_id ];

                    if ( in_array( $_GET['id'], $collection['listings'] ) ) {
                        foreach ( $collection['listings'] as $index => $listing_id ) {
                            if ( $listing_id == $_GET['id'] ) {
                                unset( $collection['listings'][ $index ] );
                            }
                        }

                        $collections[ $collection_id ] = $collection;
                        update_user_meta( $user_id, 'collections', $collections );
                    }
                }

                $data = array(
                    'success'       => true,
                    'collections'   => $collections
                );
            } else {
                $data = array(
                    'success' => false,
                    'message' => __('No favorite listings found.', 'inventor-favorites'),
                );
            }
        } else {
            $data = array(
                'success' => false,
                'message' => __('Listing ID is missing.', 'inventor-favorites'),
            );
        }

        echo json_encode( $data );
        exit();
    }

    /**
     * Adds listing into favorites
     *
     * @access public
     * @return void
     */
    public static function add_favorite() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        if( ! is_user_logged_in() ) {
            $data = array(
                'success' => false,
                'message' => __( 'You need to log in at first.', 'inventor-favorites' ),
            );
        } else if ( ! empty( $_GET['id'] ) ) {
            $favorites = get_user_meta( get_current_user_id(), 'favorites', true );
            $favorites = ! is_array( $favorites ) ? array() : $favorites;

            if ( empty( $favorites ) ) {
                $favorites = array();
            }

            $post = get_post( $_GET['id'] );
            $post_type = get_post_type( $post->ID );

            if ( ! in_array( $post_type, Inventor_Post_Types::get_listing_post_types() ) ) {
                $data = array(
                    'success' => false,
                    'message' => __( 'This is not listing ID.', 'inventor-favorites' ),
                );
            } else {
                $found = false;

                foreach ( $favorites as $listing_id ) {
                    if ( $listing_id == $_GET['id']) {
                        $found = true;
                        break;
                    }
                }

                if ( ! $found ) {
                    $favorites[] = $post->ID;
                    $user_id = get_current_user_id();

                    update_user_meta( $user_id, 'favorites', $favorites );

                    if ( ! empty( $_GET['collection-id'] ) ) {
                        $collection_id = (int) $_GET['collection-id'];
                        $collections = self::get_user_collections( $user_id );

                        if ( ! empty( $collections[ $collection_id ] ) ) {
                            $collection = $collections[ $collection_id ];

                            if ( ! in_array( $post->ID, $collection['listings'] ) ) {
                                $collection['listings'][] = $post->ID;
                                $collections[ $collection_id ] = $collection;
                                update_user_meta( $user_id, 'collections', $collections );
                            }
                        }
                    }

                    $data = array(
                        'success' => true,
                    );
                } else {
                    $data = array(
                        'success' => false,
                        'message' => __( 'Listing is already in list', 'inventor-favorites' ),
                    );
                }
            }
        } else {
            $data = array(
                'success' => false,
                'message' => __( 'Listing ID is missing.', 'inventor-favorites' ),
            );
        }

        echo json_encode( $data );
        exit();
    }

    /**
     * Gets list of listings from favorites
     *
     * @access public
     * @return void
     */
    public static function feed_catch_template() {
        if ( get_query_var( 'favorites-feed' ) ) {
            header( 'HTTP/1.0 200 OK' );
            header( 'Content-Type: application/json' );

            $data = array();
            $favorites = get_user_meta( get_current_user_id(), 'favorites', true );

            if ( ! empty( $favorites ) && is_array( $favorites ) ) {
                foreach ( $favorites as $listing_id ) {
                    $post = get_post( $listing_id );

                    $data[] = array(
                        'id'        => $post->ID,
                        'title'     => get_the_title( $post->ID ),
                        'permalink' => get_permalink( $post->ID ),
                        'src'       => wp_get_attachment_url( get_post_thumbnail_id( $post->ID) ),
                    );
                }
            }

            echo json_encode( $data );
            exit();
        }
    }

    /**
     * Checks if listing is in user favorites
     *
     * @access public
     * @param int $post_id
     * @return bool
     */
    public static function is_my_favorite( $post_id ) {
        $favorites = get_user_meta( get_current_user_id(), 'favorites', true );

        if ( ! empty( $favorites ) && is_array( $favorites ) ) {
            return in_array( $post_id, $favorites );
        }

        return false;
    }

    /**
     * Gets user favorites
     *
     * @access public
     * @param int $user_id
     * @return WP_Query
     */
    public static function get_favorites_by_user( $user_id = null) {
        if ( empty( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        $favorites = get_user_meta( $user_id, 'favorites', true );

        if( ! is_array( $favorites ) ||  count( $favorites ) == 0 ) {
            $favorites = array( '', );
        }

        return new WP_Query( array(
            'post_type'         => Inventor_Post_Types::get_listing_post_types(),
            'post__in'		    => $favorites,
            'post_status'       => 'any',
        ) );
    }

    /**
     * Gets user collections
     *
     * @access public
     * @param int $user_id
     * @return array
     */
    public static function get_user_collections( $user_id = null ) {
        if ( empty( $user_id ) ) {
            $user_id = get_current_user_id();
        }

        $collections = get_user_meta( $user_id, 'collections', true );

        // Structure
        // {'1': {'title': 'First Collection', 'listings': [123, 456] }, '2': { 'title': 'Second Collection', 'listings': [34, 56] } }

        return isset( $collections ) && is_array( $collections )  ? $collections : array();
    }

    /**
     * Sets all user favorites into query
     *
     * @access public
     * @param int $collection_id
     * @return void
     */
    public static function loop_my_favorites( $collection_id = null ) {
        $user_id = get_current_user_id();

        $paged = ( get_query_var('paged')) ? get_query_var('paged') : 1;
        $favorites = get_user_meta( $user_id, 'favorites', true );

        if( ! is_array( $favorites ) ||  count( $favorites ) == 0 ) {
            $favorites = array( '', );
        }

        if ( ! empty( $collection_id ) ) {
            $collections = self::get_user_collections( $user_id );

            if( isset( $collections[ $collection_id ] ) ) {
                $collection = $collections[ $collection_id ];
                $favorites = empty( $collection['listings'] ) ? array( '', ) : $collection['listings'];
            }
        }

        query_posts( array(
            'post_type'     => Inventor_Post_Types::get_listing_post_types(),
            'paged'         => $paged,
            'post__in'		=> $favorites,
            'post_status'   => 'publish',
        ) );
    }

    /**
     * Renders favorite toggle button
     *
     * @access public
     * @param int $listing_id
     * @param bool $hide_if_anonymous
     * @return void
     */
    public static function render_favorite_button( $listing_id, $hide_if_anonymous = false ) {
        if( ! ( ! is_user_logged_in() && $hide_if_anonymous ) ) {
            echo Inventor_Template_Loader::load( 'misc/favorites-button', array( 'listing_id' => $listing_id ), $plugin_dir = INVENTOR_FAVORITES_DIR );
        }
    }

    /**
     * Renders total favorite users info
     *
     * @access public
     * @param int $listing_id
     * @return void
     */
    public static function render_total_favorite_users( $listing_id ) {
        echo Inventor_Template_Loader::load( 'misc/favorites-total', array( 'listing_id' => $listing_id ), $plugin_dir = INVENTOR_FAVORITES_DIR );
    }

    /**
     * Gets count of users who like the post
     *
     * @access public
     * @param int $post_id
     * @return int
     */
    public static function get_post_total_users( $post_id = null ) {
        global $wpdb;

        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $sql = 'SELECT COUNT(*) as num_users FROM ' . $wpdb->usermeta . ' WHERE meta_key = "favorites" AND meta_value LIKE "%i:' . $post_id . ';%";';

        $results = $wpdb->get_results( $sql );
        if ( ! empty( $results[0] ) ) {
            return $results[0]->num_users;
        }

        return 0;
    }

    /**
     * Process collection form
     *
     * @access public
     * @return void
     */
    public static function process_collection_form() {
        if ( ! isset( $_POST['collection_form'] ) || empty( $_POST['collection_title'] ) || ! is_user_logged_in() ) {
            return;
        }

        if ( class_exists( 'Inventor_Recaptcha' ) && Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) {
            if ( array_key_exists( 'g-recaptcha-response', $_POST ) ) {
                $is_recaptcha_valid = Inventor_Recaptcha_Logic::is_recaptcha_valid( $_POST['g-recaptcha-response'] );

                if ( ! $is_recaptcha_valid ) {
                    Inventor_Utilities::show_message( 'danger', __( 'reCAPTCHA is not valid.', 'inventor-favorites' ) );
                    return;
                }
            }
        }

        $collection_name = esc_attr( $_POST['collection_title'] );

        if ( ! empty( $collection_name ) ) {
            self::save_collection( $collection_name );
            Inventor_Utilities::show_message( 'success', __( 'Collection created.', 'inventor-favorites' ) );
        } else {
            Inventor_Utilities::show_message( 'danger', __( 'Unable create collection.', 'inventor-favorites' ) );
        }
    }

    /**
     * Saves collection
     *
     * @access public
     * @param $title string
     * @return int
     */
    public static function save_collection( $title ) {
        $user_id = get_current_user_id();
        $collections = self::get_user_collections( $user_id );

        $collection_id = 1;

        if ( count( $collections ) > 0 ) {
            $collection_ids = array_map( 'intval', array_keys( $collections ) );
            sort( $collection_ids );
            $last_id = $collection_ids[ count( $collection_ids ) - 1 ];
            $collection_id = $last_id + 1;
        }

        $collections[ $collection_id ] = array(
            'title'  => $title,
            'listings'  => array()
        );

        update_user_meta( $user_id, 'collections', $collections );

        return $collection_id;
    }

    /**
     * Renders user favorite collections
     *
     * @access public
     * @return void
     */
    public static function render_favorite_collections() {
        if ( ! is_user_logged_in() ) {
            return;
        }

        $collections = self::get_user_collections();

        if ( empty( $collections ) ) {
            return;
        }

        echo Inventor_Template_Loader::load( 'collection-pickup', array( 'collections' => $collections ), $plugin_dir = INVENTOR_FAVORITES_DIR );
    }
}

Inventor_Favorites_Logic::init();