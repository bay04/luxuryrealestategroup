<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Fields_Migrations
 *
 * @class Inventor_Fields_Migrations
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Fields_Migrations {
    const TOTAL_MIGRATIONS = 1;

    /**
     * Initialize scripts
     *
     * @access public
     * @return void
     */
    public static function init() {
        self::constants();

        add_action( 'cmb2_init', array( __CLASS__, 'migrate_all' ), 99 );
    }

    /**
     * Defines constants
     *
     * @access public
     * @return void
     */
    public static function constants() {
        define( 'INVENTOR_FIELDS_MIGRATION_KEY', 'migration_' . Inventor_Fields::DOMAIN );
    }

    /**
     * Gets migration version
     *
     * @access public
     * @param $key string
     * @return int
     */
    public static function get_version( $key ) {
        return get_option( $key, 0 );
    }

    /**
     * Sets migration version
     *
     * @access public
     * @param $key string
     * @param $version int
     * @return void
     */
    public static function set_version( $key, $version ) {
        update_option( $key, $version );
    }

    /**
     * Migrate all migrations
     *
     * @access public
     * @return void
     */
    public static function migrate_all() {
        while ( get_option( INVENTOR_FIELDS_MIGRATION_KEY ) < self::TOTAL_MIGRATIONS ) {
            $next_version = get_option( INVENTOR_FIELDS_MIGRATION_KEY ) + 1;
            self::migrate( $next_version );
        }
    }

    /**
     * Migrate single migration
     *
     * @access public
     * @param $version
     * @return void
     */
    public static function migrate( $version ) {
        global $wpdb;

        if ( $version == 1 ) {
            $fields = Inventor_Fields_Logic::get_fields();

            foreach ( $fields as $identifier => $title ) {
                $field = Inventor_Fields_Logic::get_field( $identifier );

                $possible_keys = Inventor_Fields_Post_Type_Field::get_possible_ids( $field->ID );

                foreach ( $possible_keys as $old_key ) {
                    $new_key = INVENTOR_LISTING_PREFIX . $identifier;
                    $sql = 'UPDATE ' . $wpdb->prefix . 'postmeta SET `meta_key` = "' . $new_key. '" WHERE `meta_key` = "' . $old_key. '"';
                    $wpdb->query( $sql );
                }
            }
        }

        self::set_version( INVENTOR_FIELDS_MIGRATION_KEY, $version );
    }
}

Inventor_Fields_Migrations::init();