<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Watchdogs_Logic
 *
 * @class Inventor_Watchdogs_Logic
 * @package Inventor_Watchdogs/Classes
 * @author Pragmatic Mates
 */
class Inventor_Watchdogs_Logic {
    /**
     * Initialize Watchdogs functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'wp', array( __CLASS__, 'add_watchdog' ) );
        add_action( 'wp', array( __CLASS__, 'remove_watchdog' ) );
        add_action( 'wp', array( __CLASS__, 'redirect_to_lookup' ) );
        add_action( 'inventor_after_filter_result_numbers', array( __CLASS__, 'render_watchdog_button' ) );
    }

    /**
     * Gets config
     *
     * @access public
     * @return array|bool
     */
    public static function get_config() {
        $search_queries_enabled = get_theme_mod( 'inventor_watchdogs_enable_search_queries', false );

        $config = array(
            "search_queries_enabled"      => $search_queries_enabled,
        );

        return $config;
    }

    /**
     * Returns search/filter query array built from $_GET params
     *
     * @access public
     * @param $params array
     * @return array
     */
    public static function get_search_query( $params ) {
        $search_query = array();
        $filter_fields = Inventor_Filter::get_fields();
        $filter_fields_keys = array_keys( $filter_fields );

        foreach ( $params as $key => $value ) {
            // save only filter fields values
            if ( in_array( $key, $filter_fields_keys ) && ! empty( $value ) ) {
                $search_query[$key] = $value;
            }
        }

        // append post type to search query
        if ( is_archive() ) {
            global $wp_query;
            $post_type = $wp_query->get( 'post_type' );
            $search_query['post-type'] = is_array( $post_type ) ? 'listing' : $post_type;
        }

        return $search_query;
    }

    /**
     * Cleans array of empty values
     *
     * @access public
     * @param $input array
     * @return array
     */
    public static function get_cleaned_array( $input ) {
        $cleaned_array = array();
        foreach ( $input as $key => $value ) {
            if ( ! empty( $value ) ) {
                $cleaned_array[$key] = $value;
            }
        }
        return $cleaned_array;
    }

    /**
     * Returns name of lookup key
     *
     * @access public
     * @param $key string
     * @return string
     */
    public static function get_lookup_name_by_key( $key ) {
        $filter_fields = Inventor_Filter::get_fields();
        return empty( $filter_fields[ $key ] ) ? $key : $filter_fields[ $key ] ;
    }

    /**
     * Returns display lookup value
     *
     * @access public
     * @param $key string
     * @param $value string
     * @return string
     */
    public static function get_lookup_display_value( $key, $value ) {
        if ( in_array( $key, array( 'locations', 'listing_categories' ) ) ) {
            $term = get_term( $value, $key );

            if ( $term ) {
                return $term->name;
            }
        }

        return $value;
    }

    /**
     * Saves watchdog
     *
     * @access public
     * @param $type string
     * @param $lookup array
     * @param $value int|string
     * @param $user_id int
     * @return int
     */
    public static function save_watchdog( $type, $lookup, $value, $user_id ) {
        $watchdog_id = wp_insert_post( array(
            'post_type'     => 'watchdog',
            'post_status'   => 'publish',
            'post_author'   => $user_id
        ) );

        update_post_meta( $watchdog_id, INVENTOR_WATCHDOG_PREFIX . 'type', $type );
        update_post_meta( $watchdog_id, INVENTOR_WATCHDOG_PREFIX . 'lookup', $lookup );
        update_post_meta( $watchdog_id, INVENTOR_WATCHDOG_PREFIX . 'value', $value );

        return $watchdog_id;
    }

    /**
     * Adds new watchdog
     *
     * @access public
     * @return void
     */
    public static function add_watchdog() {
        if ( ! isset( $_GET[ 'watchdog-add' ] ) ) {
            return;
        }

        unset( $_GET['watchdog-add'] );

        $redirect_url = '?' . http_build_query( $_GET );

        if ( ! is_user_logged_in() ) {
            Inventor_Utilities::show_message( 'danger', __( 'You need to log in at first.', 'inventor-watchdogs' ) );
            wp_redirect( $redirect_url );
            exit();
        }

        $result = self::save_search_query_watchdog( $_GET );

        $message_level = $result['success'] ? 'success' : 'danger';
        Inventor_Utilities::show_message( $message_level, $result['message'] );

        wp_redirect( $result['redirect_url'] );
        exit();
    }

    /**
     * Removes existing watchdog
     *
     * @access public
     * @return void
     */
    public static function remove_watchdog() {
        if ( ! isset( $_GET[ 'watchdog-remove' ] ) ) {
            return;
        }

        unset( $_GET['watchdog-remove'] );

        $redirect_url = '?' . http_build_query( $_GET );

        if( ! is_user_logged_in() ) {
            Inventor_Utilities::show_message( 'danger', __( 'You need to log in at first.', 'inventor-watchdogs' ) );
            wp_redirect( $redirect_url );
            exit();
        }

        if ( isset( $_GET[ 'id' ] ) ) {
            $watchdog = get_post( $_GET[ 'id' ] );

            if ( empty( $watchdog ) ) {
                Inventor_Utilities::show_message( 'danger', __( 'Watchdog does not exist!', 'inventor-watchdogs' ) );
            } else if( $watchdog->post_author != get_current_user_id() ) {
                Inventor_Utilities::show_message( 'danger', __( 'It is not your watchdog!', 'inventor-watchdogs' ) );
            } else {
                wp_delete_post( $_GET[ 'id' ] );
                Inventor_Utilities::show_message( 'success', __( "Watchdog deleted.", 'inventor-watchdogs' ));

                // redirect
                $my_watchdogs_page = get_theme_mod( 'inventor_watchdogs_page' );
                $my_watchdogs_page_url = $my_watchdogs_page ? get_permalink( $my_watchdogs_page ) : home_url();
                wp_redirect( $my_watchdogs_page_url );
                exit();
            }
        } else {
            $result = self::remove_search_query_watchdog( $_GET );

            $message_level = $result['success'] ? 'success' : 'danger';
            Inventor_Utilities::show_message( $message_level, $result['message'] );

            wp_redirect( $result['redirect_url'] );
            exit();
        }
    }

    /**
     * Saves search query watchdog
     *
     * @access public
     * @param $params array
     * @return array
     */
    public static function save_search_query_watchdog( $params ) {
        $type = INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY;
        $config = self::get_config();
        $redirect_url = '?' . http_build_query( $params );
        $result = array(
            'redirect_url' => $redirect_url
        );

        if ( ! $config['search_queries_enabled'] ) {
            $result['success'] = false;
            $result['message'] = __( 'Search query watchdogs are disabled.', 'inventor-watchdogs' );
            return $result;
        }

        // build search query from $params
        $lookup = self::get_search_query( $params );

        if ( ! is_array( $params ) || count( $params ) <= 0 || count( $lookup ) <= 0 ) {
            $result['success'] = false;
            $result['message'] = __( "You can't watch empty search query.", 'inventor-watchdogs' );
            return $result;
        }

        if ( self::is_my_watchdog( $type, $lookup ) ) {
            $result['success'] = false;
            $result['message'] = __( "You already watch this search query.", 'inventor-watchdogs' );
            return $result;
        }

        $value = self::get_watchdog_value( $type, $lookup );

        // save watchdog
        self::save_watchdog( $type, $lookup, $value, get_current_user_id() );

        $result['success'] = true;
        $result['message'] = __( "Watchdog saved.", 'inventor-watchdogs' );
        return $result;
    }

    /**
     * Removes search query watchdog
     *
     * @access public
     * @param $params array
     * @return array
     */
    public static function remove_search_query_watchdog( $params ) {
        $redirect_url = '?' . http_build_query( $params );
        $result = array(
            'redirect_url' => $redirect_url
        );

        $search_query = self::get_search_query( $params );

        $watchdog = self::get_watchdog( INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY, $search_query, get_current_user_id() );

        if ( empty( $watchdog ) ) {
            $result['success'] = false;
            $result['message'] = __( "You don't watch this search query.", 'inventor-watchdogs' );
            return $result;
        }

        // delete watchdog
        wp_delete_post( $watchdog->ID );

        $result['success'] = true;
        $result['message'] = __( "Watchdog deleted.", 'inventor-watchdogs' );
        return $result;
    }

    /**
     * Returns value for watchdog by its type and lookup
     *
     * @access public
     * @param $type string
     * @param $lookup array
     * @return int|string
     */
    public static function get_watchdog_value( $type, $lookup ) {
        if( $type == INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY ) {
            // count records matching this search query
            if ( $lookup['post-type'] == 'listing' ) {
                $post_type = Inventor_Post_Types::get_listing_post_types();
            } else {
                $post_type = $lookup['post-type'];
            }

            unset( $lookup['post-type'] );

            $args = array(
                'post_type'         => $post_type,
                'post_status'       => 'publish',
                'posts_per_page'    => -1,
            );

            $query = new WP_Query( $args );
            $query = Inventor_Filter::filter_query( $query, $lookup );
            return count( $query->get_posts() );
        }
        return 0;
    }

    /**
     * Returns watchdog by type, lookup and user
     *
     * @access public
     * @param $type string
     * @param $lookup array
     * @param $user_id int
     * @return object
     */
    public static function get_watchdog( $type, $lookup, $user_id ) {
        if ( is_array( $lookup ) ) {
            $lookup = self::get_cleaned_array( $lookup );
        }

        $wp_query = new WP_Query( array(
            'post_type'     => 'watchdog',
            'post_status'   => 'any',
            'author'        => $user_id,
            'meta_query'        => array(
                array(
                    'key' => INVENTOR_WATCHDOG_PREFIX . 'type',
                    'value' => $type,
                ),
                array(
                    'key' => INVENTOR_WATCHDOG_PREFIX . 'lookup',
                    'value' => serialize( $lookup ),
                )
            )
        ) );

        if ( $wp_query->post_count <= 0 ) {
            return null;
        }

        return $wp_query->posts[0];
    }

    /**
     * Checks if user already has watchdog
     *
     * @access public
     * @param $type string
     * @param $lookup array
     * @return bool
     */
    public static function is_my_watchdog( $type, $lookup ) {
        if ( $type == INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY ) {
            $lookup = self::get_search_query( $lookup );
        }
        $watchdog = self::get_watchdog( $type, $lookup, get_current_user_id() );
        return ( ! empty( $watchdog ) );
    }

    /**
     * Gets user watchdogs
     *
     * @access public
     * @param int $user_id
     * @return WP_Query
     */
    public static function get_watchdogs_by_user( $user_id = null ) {
        return new WP_Query( array(
            'post_type'         => 'watchdog',
            'author'		    => $user_id,
            'post_status'       => 'any',
        ) );
    }

    /**
     * Sets all user watchdogs into query
     *
     * @access public
     * @return void
     */
    public static function loop_my_watchdogs() {
        $paged = ( get_query_var('paged')) ? get_query_var('paged') : 1;

        query_posts( array(
            'post_type'     => 'watchdog',
            'paged'         => $paged,
            'author'		=> get_current_user_id(),
            'post_status'   => 'publish',
        ) );
    }


    /**
     * Renders watchdog toggle button
     *
     * @access public
     * @return void
     */
    public static function render_watchdog_button( $type, $hide_if_anonymous = false ) {
        if ( empty( $type ) ) {
            $type = INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY;
        }

        if( ! ( ! is_user_logged_in() && $hide_if_anonymous ) ) {
            $config = self::get_config();

            if ( $type == INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY && $config['search_queries_enabled'] ) {
                echo Inventor_Template_Loader::load( 'watchdogs-button', array( 'type' => $type ), $plugin_dir = INVENTOR_WATCHDOGS_DIR );
            }
        }
    }

    /**
     * Renders watchdog lookup
     *
     * @access public
     * @return void
     */
    public static function render_watchdog_lookup( $watchdog_id ) {
        $lookup = get_post_meta( $watchdog_id, INVENTOR_WATCHDOG_PREFIX . 'lookup', true );
        echo Inventor_Template_Loader::load( 'watchdogs-lookup', array( 'lookup' => $lookup ), $plugin_dir = INVENTOR_WATCHDOGS_DIR );
    }

    /**
     * Returns URL of watchdog lookup
     *
     * @access public
     * @param $watchdog_id int
     * @return string
     */
    public static function get_watchdog_url( $watchdog_id )
    {
        $type = get_post_meta($watchdog_id, INVENTOR_WATCHDOG_PREFIX . 'type', true);
        $lookup = get_post_meta($watchdog_id, INVENTOR_WATCHDOG_PREFIX . 'lookup', true);

        if ($type == INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY) {
            $post_type = empty( $lookup['post-type'] ) ? 'listing' : $lookup['post-type'];
            unset($lookup['post-type']);
            $params = http_build_query($lookup);
            $params = str_replace( 'filter-', '', $params ); // remove deprecated filter- prefix
            $base = get_post_type_archive_link($post_type);
            $redirect_url = $base . '?' . $params;
        } else {
            // TODO: get lookup post link
            $redirect_url = get_post_permalink( $watchdog_id );;
        }
        return $redirect_url;
    }

    /**
     * Redirects to watchdog lookup
     *
     * @access public
     * @return void
     */
    public static function redirect_to_lookup() {
        if( is_singular( 'watchdog' ) && ! is_admin() ) {
            $watchdog_id = get_the_ID();
            $url = self::get_watchdog_url( $watchdog_id );
            wp_redirect( $url );
            exit();
        }
    }
}

Inventor_Watchdogs_Logic::init();