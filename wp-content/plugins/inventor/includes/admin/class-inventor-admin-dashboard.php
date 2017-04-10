<?php

/**
 * Class Inventor_Admin_Dashboard
 *
 * @class Inventor_Admin_Dashboard
 * @package Inventor/Classes/Admin
 * @author Pragmatic Mates
 */
class Inventor_Admin_Dashboard {
    /**
     * Initialize
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'wp_dashboard_setup', array( __CLASS__, 'add_dashboard_widgets' ) );
    }

    /**
     * Function that outputs the contents of the dashboard widget
     *
     * @access public
     * return void
     */
    public static function dashboard_widget_function( $post, $callback_args ) {
        echo "Hello World, this is my first Dashboard Widget!";
    }

    /**
     * Function used in the action hook
     *
     * @access public
     * return void
     */
    public static function add_dashboard_widgets() {
        wp_add_dashboard_widget( 'inventor_dashboard_listings_counts', __( 'Listings counts', 'inventor' ), array( __CLASS__, 'widget_listings_counts' ) );
    }

    /**
     * Function to render pending listings
     *
     * @access public
     * return void
     */
    public static function widget_listings_counts() {
        global $wp_post_types;

        $listings = array();

        foreach ( $wp_post_types as $post_type ) {
            if ( 'listings' === $post_type->show_in_menu ) {
                $name = $post_type->name;
                $title = $wp_post_types[ $name ]->labels->name;

                $publish = wp_count_posts( $name )->publish;
                $draft = wp_count_posts( $name )->draft;
                $pending = wp_count_posts( $name )->pending;
                $total = $publish + $draft + $pending;

                $listings[ $name ] = array(
                    'title' => $title,
                    'publish' => $publish,
                    'pending' => $pending,
                    'draft' => $draft,
                    'total' => $total,
                );
            }
        }

        // sort by title
        uasort( $listings, function($a, $b) {
            return $a['title'] > $b['title'];
        });

        echo Inventor_Template_Loader::load( 'admin/dashboard/listings-counts', array( 'listings' => $listings ) );
    }
}

Inventor_Admin_Dashboard::init();