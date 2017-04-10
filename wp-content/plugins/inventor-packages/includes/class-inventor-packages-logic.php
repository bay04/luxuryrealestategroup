<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Packages_Logic
 *
 * @class Inventor_Packages_Logic
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Packages_Logic {
    /**
     * Initialize packages functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'wp', array( __CLASS__, 'validate_listings' ) );
        add_action( 'init', array( __CLASS__, 'process_free_package_selection' ), 9999 );
        add_action( 'user_register', array( __CLASS__, 'set_default_package_for_user' ), 10, 1 );
        add_action( 'profile_update', array( __CLASS__, 'user_profile_updated' ), 10, 2 );
        add_action( 'cmb2_init', array( __CLASS__, 'user_package_field' ), 11 );
        add_action( 'cmb2_init', array( __CLASS__, 'pricing_package_field' ), 11 );
        add_action( 'inventor_payment_form_before', array( __CLASS__, 'payment_form_before' ), 10, 3 );
        add_action( 'inventor_payment_form_fields', array( __CLASS__, 'payment_form_fields' ), 10, 3 );
        add_action( 'inventor_payment_processed', array( __CLASS__, 'catch_payment' ), 10, 9 );

        add_filter( 'inventor_submission_types', array( __CLASS__, 'add_submission_type' ) );
        add_filter( 'inventor_max_listing_categories', array( __CLASS__, 'max_listing_categories' ) );
        add_filter( 'inventor_package_durations', array( __CLASS__, 'default_package_durations' ) );
        add_filter( 'inventor_payment_types', array( __CLASS__, 'add_payment_type' ) );
        add_filter( 'inventor_payment_form_price_value', array( __CLASS__, 'payment_price_value' ), 10, 3 );
        add_filter( 'inventor_prepare_payment', array( __CLASS__, 'prepare_payment' ), 10, 3 );
        add_filter( 'inventor_submission_allowed_listing_post_types', array( __CLASS__, 'disable_listing_types_on_frontend' ) );
        add_filter( 'inventor_submission_can_user_create', array( __CLASS__, 'can_user_create_submission' ), 10, 2 );
        add_filter( 'inventor_metabox_allowed', array( __CLASS__, 'listing_metabox_allowed' ), 10, 3 );
        add_filter( 'inventor_pricing_price', array( __CLASS__, 'pricing_price' ), 10, 2 );
        add_filter( 'inventor_pricing_table_items', array( __CLASS__, 'pricing_table_max_submission_items' ), 10, 2 );
        add_filter( 'inventor_pricing_table_items', array( __CLASS__, 'pricing_table_max_categories' ), 10, 2 );
        add_filter( 'inventor_pricing_table_items', array( __CLASS__, 'pricing_table_metabox_items' ), 10, 2 );

        if ( ! is_admin() ) {
            add_filter( 'inventor_metabox_field_before', array( __CLASS__, 'max_categories_before_categories_field' ), 11, 4 );
            add_filter( 'inventor_metabox_description', array( __CLASS__, 'information_about_metabox_permission' ), 10, 3 );
        }

        register_deactivation_hook( INVENTOR_PACKAGES_DIR . 'inventor-packages.php', array( __CLASS__, 'plugin_deactivated' ) );
    }

    /**
     * Adds packages submission type
     *
     * @access public
     * @param array $submission_types
     * @return array
     */
    public static function add_submission_type( $submission_types ) {
        $submission_types['packages'] = __( 'Packages', 'inventor-packages' );
        return $submission_types;
    }


    /**
     * Publish all listings if package system is not used
     *
     * @access public
     * @return void
     */
    public static function plugin_deactivated() {
        set_theme_mod( 'inventor_submission_type', 'free' );

        $query = Inventor_Query::get_all_listings( );

        $listings = $query->posts;

        if ( count( $listings ) == 0 ) {
            return;
        }

        // Publish all listings
        self::publish( $listings );
    }

    /**
     * Adds package payment type
     *
     * @access public
     * @param array $payment_types
     * @return array
     */
    public static function add_payment_type( $payment_types ) {
        $payment_types[] = 'package';
        return $payment_types;
    }


    /**
     * Gets price value for payment object
     *
     * @access public
     * @param float $price
     * @param string $payment_type
     * @param int $object_id
     * @return float
     */
    public static function payment_price_value( $price, $payment_type, $object_id ) {
        if ( 'package' == $payment_type && ! empty( $object_id ) ) {
            return self::get_package_price( $object_id );
        }

        return $price;
    }


    /**
     * Gets pricing formatted price
     *
     * @access public
     * @param  string $price
     * @param int $pricing_id
     * @return string
     */
    public static function pricing_price( $price, $pricing_id ) {
        if ( ! class_exists( 'Inventor_Pricing' ) || ! defined( 'INVENTOR_PRICING_PREFIX' ) ) {
            return $price;
        }

        $package = get_post_meta( $pricing_id, INVENTOR_PRICING_PREFIX . 'package', true );

        if ( ! empty( $package ) ) {
            $price = self::get_package_formatted_price( $package );
        } else {
            $price = Inventor_Price::format_price( $price );
        }

        $currency = Inventor_Price::current_currency();
        $currency_symbol = $currency['symbol'];
        $formatted_symbol = sprintf( '<sup>%s</sup>', $currency_symbol );

        $price = str_replace( $currency_symbol, $formatted_symbol, $price );
        $duration_formatted = self::get_package_duration( $package, true );

        if ( ! empty( $duration_formatted ) ) {
            $price = sprintf( '%s <small>/ %s</small>', $price, $duration_formatted );
        }

        return $price;
    }

    /**
     * Decides whether listing metabox is allowed for user by his package
     *
     * @access public
     * @param bool $allowed
     * @param string $metabox_key
     * @param int $user_id
     * @return bool
     */
    public static function listing_metabox_allowed( $allowed, $metabox_key, $user_id ) {
        $package_valid = self::is_package_valid_for_user( $user_id );
        $permissions_metabox_id = INVENTOR_PACKAGE_PREFIX . 'metabox_permissions';
        $permissions_metabox = CMB2_Boxes::get( $permissions_metabox_id );
        $fields = $permissions_metabox->meta_box['fields'];
        $field_id = INVENTOR_PACKAGE_PREFIX . 'metabox_' . $metabox_key . '_allowed';

        if ( array_key_exists( $field_id, $fields ) ) {
            $package = self::get_package_for_user( $user_id );
            if ( empty( $package ) ) {
                return false;
            }
            $allowed_by_package = get_post_meta( $package->ID, $field_id, true );
            return $allowed_by_package && $package_valid;
        }

        return $allowed;
    }

    /**
     * Adds package max submission items to pricing table items
     *
     * @access public
     * @param array $items
     * @param int $pricing_id
     * @return array
     */
    public static function pricing_table_max_submission_items( $items, $pricing_id ) {
        if ( ! is_array( $items ) ) {
            $items = array();
        }

        if ( ! class_exists( 'Inventor_Pricing' ) || ! defined( 'INVENTOR_PRICING_PREFIX' ) ) {
            return $items;
        }

        if ( get_theme_mod( 'inventor_submission_type', 'free' ) != 'packages' ) {
            return $items;
        }

        $package_id = get_post_meta( $pricing_id, INVENTOR_PRICING_PREFIX . 'package', true );
        $package = self::get_package( $package_id );

        if ( ! $package ) {
            return $items;
        }

        $max_listings = get_post_meta( $package->ID, INVENTOR_PACKAGE_PREFIX . 'max_listings', true );
        $max_listings_text = '-1' == $max_listings ? __( 'Unlimited', 'inventor-packages' ) : $max_listings;

        return array_merge(
            $items,
            array( '<small>' . __( 'Max Listings', 'inventor-packages' ) . '</small>' . $max_listings_text )
        );
    }

    /**
     * Adds package max listing categories to pricing table items
     *
     * @access public
     * @param array $items
     * @param int $pricing_id
     * @return array
     */
    public static function pricing_table_max_categories( $items, $pricing_id ) {
        if ( ! is_array( $items ) ) {
            $items = array();
        }

        if ( ! class_exists( 'Inventor_Pricing' ) || ! defined( 'INVENTOR_PRICING_PREFIX' ) ) {
            return $items;
        }

        $package_id = get_post_meta( $pricing_id, INVENTOR_PRICING_PREFIX . 'package', true );
        $package = self::get_package( $package_id );

        if ( ! $package ) {
            return $items;
        }

        $max_categories = get_post_meta( $package->ID, INVENTOR_PACKAGE_PREFIX . 'max_categories', true );
        $max_categories_text = is_numeric( $max_categories ) ? $max_categories : __( 'Unlimited', 'inventor-packages' );

        return array_merge(
            $items,
            array( '<small>' . __( 'Max Categories', 'inventor-packages' ) . '</small>' . $max_categories_text )
        );
    }

    /**
     * Adds package metabox permissions to pricing table items
     *
     * @access public
     * @param array $items
     * @param int $pricing_id
     * @return array
     */
    public static function pricing_table_metabox_items( $items, $pricing_id ) {
        if ( ! is_array( $items ) ) {
            $items = array();
        }

        if ( ! class_exists( 'Inventor_Pricing' ) || ! defined( 'INVENTOR_PRICING_PREFIX' ) ) {
            return $items;
        }

        $package_id = get_post_meta( $pricing_id, INVENTOR_PRICING_PREFIX . 'package', true );
        $package = self::get_package( $package_id );

        if ( ! $package ) {
            return $items;
        }

        $permissions_metabox_id = INVENTOR_PACKAGE_PREFIX . 'metabox_permissions';
        $permissions_metabox = CMB2_Boxes::get( $permissions_metabox_id );

        $fields = $permissions_metabox->meta_box['fields'];

        if ( count( $fields ) == 0 ) {
            return $items;
        }

        $allowed_metaboxes = array();
        $disallowed_metaboxes = array();

        foreach( $fields as $field_id => $field ) {
            $allowed_by_package = get_post_meta( $package->ID, $field_id, true );
            if ( $allowed_by_package ) {
                $allowed_metaboxes[] = $field['name'];
            } else {
                $disallowed_metaboxes[] = '<s>' . $field['name'] . '</s>';
            }
        }

        $items = array_merge(
            $items,
            array( '<small>' . __( 'Listing details', 'inventor-packages' ) . '</small>' )
        );

        if ( count( $allowed_metaboxes ) > 0 ) {
            $items = array_merge( $items, $allowed_metaboxes );
        }

        if ( count( $disallowed_metaboxes ) > 0 ) {
            $items = array_merge( $items, $disallowed_metaboxes );
        }

        return $items;
    }

    /**
     * Default package durations definition
     *
     * @access public
     * @param array $package_durations
     * @return array
     */
    public static function default_package_durations( $package_durations ) {
        return array_merge( array(
            array( 'key' => 'week',  'display' => __( 'week', 'inventor-packages' ),  'length' => '+1 week' ),
            array( 'key' => 'month', 'display' => __( 'month', 'inventor-packages' ), 'length' => '+1 month' ),
            array( 'key' => 'year',  'display' => __( 'year', 'inventor-packages' ),  'length' => '+1 year' ),
        ), $package_durations );
    }

    /**
     * Prepares payment data
     *
     * @access public
     * @param array $payment_data
     * @param string $payment_type
     * @param int $object_id
     * @return array
     */
    public static function prepare_payment( $payment_data, $payment_type, $object_id ) {
        if ( $payment_type == 'package' ) {
            $post = get_post( $object_id );
            $payment_data['price'] = self::get_package_price( $object_id );
            $payment_data['action_title'] = __( 'Purchase package', 'inventor-packages' );
            $payment_data['description'] = sprintf( __( 'Upgrade package to %s', 'inventor-packages' ), $post->post_title );
        }
        return $payment_data;
    }

    /**
     * Returns list of package IDs and titles
     *
     * @access public
     * @param bool $show_none
     * @param bool $show_trial
     * @param bool $show_free
     * @param bool $show_private
     * @return array
     */
    public static function get_packages_choices( $show_none = false, $show_trial = false, $show_free = true, $show_private = false ) {
        $packages = self::get_packages( $show_trial, $show_free, $show_private );

        $choices = array();

        if ( $show_none ) {
            $choices[] = __( 'Not set', 'inventor-packages' );
        }

        foreach ( $packages as $package ) {
            $choices[ $package->ID ] = $package->post_title;
        }

        return $choices;
    }

    /**
     * Returns list of packages
     *
     * @access public
     * @param bool $include_trial
     * @param bool $include_free
     * @param bool $include_private
     * @return array
     */
    public static function get_packages( $include_trial = false, $include_free = true, $include_private = false ) {
        $packages_query = new WP_Query( array(
            'post_type'         => 'package',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
        ) );

        $packages = array();

        foreach ( $packages_query->posts as $package ) {
            $duration = self::get_package_duration( $package->ID );
            $price = self::get_package_price( $package->ID );

            $is_regular = ! empty ( $price ) && $price > 0 && ! empty( $duration );
            $is_simple = ! empty ( $price ) && $price > 0 && empty( $duration );
            $is_trial = ( empty ( $price ) || $price == 0 ) && ! empty( $duration );
            $is_free = ( empty ( $price ) || $price == 0 ) && empty( $duration );
            $is_private = get_post_meta( $package->ID, INVENTOR_PACKAGE_PREFIX . 'private', true );

            if ( $is_regular || $is_simple || $is_trial && $include_trial || $is_free && $include_free ) {
                if ( ! ( $is_private && ! $include_private ) ) {
                    $packages[] = $package;
                }
            }
        }

        return $packages;
    }

    /**
     * Checks if package is free
     *
     * @access public
     * @param int $package_id
     * @return bool
     */
    public static function is_package_free( $package_id ) {
        $package = self::get_package( $package_id );

        if ( ! $package ) {
            return false;
        }

        $duration = self::get_package_duration( $package->ID );
        $price = self::get_package_price( $package->ID );

        $is_free = ( empty ( $price ) || $price == 0 ) && empty( $duration );

        return $is_free;
    }

    /**
     * Checks if package is trial
     *
     * @access public
     * @param int $package_id
     * @return bool
     */
    public static function is_package_trial( $package_id ) {
        $package = self::get_package( $package_id );

        if ( ! $package ) {
            return false;
        }

        $duration = self::get_package_duration( $package->ID );
        $price = self::get_package_price( $package->ID );

        $is_trial = ( empty ( $price ) || $price == 0 ) && ! empty( $duration );

        return $is_trial;
    }

    /**
     * Checks if package is simple (one-time fee)
     *
     * @access public
     * @param int $package_id
     * @return bool
     */
    public static function is_package_simple( $package_id ) {
        $package = self::get_package( $package_id );

        if ( ! $package ) {
            return false;
        }

        $duration = self::get_package_duration( $package->ID );
        $price = self::get_package_price( $package->ID );

        $is_simple = ! empty ( $price ) && $price > 0 && empty( $duration );

        return $is_simple;
    }

    /**
     * Checks if package is regular
     *
     * @access public
     * @param int $package_id
     * @return bool
     */
    public static function is_package_regular( $package_id ) {
        $package = self::get_package( $package_id );

        if ( ! $package ) {
            return false;
        }

        $duration = self::get_package_duration( $package->ID );
        $price = self::get_package_price( $package->ID );

        $is_regular = ! empty ( $price ) && $price > 0 && ! empty( $duration );

        return $is_regular;
    }

    /**
     * Gets all durations for packages
     *
     * @access public
     * @param bool $show_none
     * @return array
     */
    public static function get_package_durations( $show_none = false ) {
        $durations_definition = apply_filters( 'inventor_package_durations', array() );

        $durations = array();

        if ( $show_none ) {
            $durations[] = __( 'Infinite', 'inventor-packages' );
        }

        foreach( $durations_definition as $duration ) {
            $durations = array_merge( $durations, array(
                $duration['key'] => $duration['display'],
            ) );
        }

        return $durations;
    }

    /**
     * Gets package for user
     *
     * @access public
     * @param $user_id
     * @return bool|WP_Post
     */
    public static function get_package_for_user( $user_id = null ) {
        $user_id = empty( $user_id ) ? get_current_user_id() : $user_id;
        $user_package_id = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package', true );

        $user_package = empty( $user_package_id ) ? false : get_post( $user_package_id );
        $user_package = apply_filters( 'inventor_package_of_user', $user_package );

        return $user_package;
    }

    /**
     * Adds package field to user profile post type
     *
     * @access public
     * @return void
     */
    public static function user_package_field() {
        if ( is_super_admin() || ! is_admin() ) {
            // Package
            $profile_metabox = new_cmb2_box( array(
                'id'            => INVENTOR_USER_PREFIX . 'package',
                'title'         => __( 'Package', 'inventor-packages' ),
                'object_types'  => array( 'user' ),
                'context'       => 'normal',
                'priority'      => 'high',
                'show_names'    => true,
            ) );

            $profile_metabox->add_field( array(
                'id'        => INVENTOR_USER_PREFIX . 'package_title',
                'name'      => __( 'Package Information', 'inventor-packages' ),
                'type'      => 'title',
            ) );

            $profile_metabox->add_field( array(
                'id'        => INVENTOR_USER_PREFIX . 'package',
                'name'      => __( 'Package', 'inventor-packages' ),
                'type'      => 'select',
                'options'   => self::get_packages_choices( true, true, true, true ),
                'column'    => true
            ) );

            if ( ! is_super_admin() ) {
                $user_id = get_current_user_id();
            } else {
                $user_id = empty( $_GET['user_id'] ) ? get_current_user_id() : $_GET['user_id'];
            }

            $package_infinite = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package_infinite', true );
            $package_valid = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package_valid', true );

            $profile_metabox->add_field( array(
                'id'        => INVENTOR_USER_PREFIX . 'package_infinite',
                'name'      => __( 'Infinite duration', 'inventor-packages' ),
                'type'      => 'checkbox',
                'default'   => $package_infinite || $package_valid == -1,
            ) );

            $profile_metabox->add_field( array(
                'id'        => INVENTOR_USER_PREFIX . 'package_valid',
                'name'      => __( 'Validity', 'inventor-packages' ),
                'type'      => 'text_date_timestamp',
                //            'date_format' => 'd/m/Y'
            ) );
        }
    }

    /**
     * Adds message about maximum allowed categories before field
     *
     * @access public
     * @return string
     */
    public static function max_categories_before_categories_field( $value, $metabox_id, $field_id, $post_type ) {
        if ( $field_id == INVENTOR_LISTING_PREFIX  . 'listing_category' ) {
            $max_listing_categories = Inventor_Post_Types::get_max_listing_categories();

            $package = Inventor_Packages_Logic::get_package_for_user( get_current_user_id() );
            $package_name = empty( $package ) ? '' : $package->post_title;

            if ( $max_listing_categories === false ) {
                return sprintf( __( 'Your package %s allows you to set unlimited number of categories.', 'inventor-packages' ), $package_name );
            } else {
                return sprintf( _n( 'Your package %s allows you to set at most %d category.', 'Your package %s allows you to set at most %d categories.', $max_listing_categories, 'inventor-packages' ), $package_name, $max_listing_categories );
            }
        }

        return $value;
    }

    /**
     * Adds info message to the metabox description if user package does not have its permission
     *
     * @access public
     * @param string $description
     * @param string $metabox_id
     * @param string $post_type
     * @return string
     */
    public static function information_about_metabox_permission( $description, $metabox_id, $post_type ) {
        if ( is_admin() ) {
            return $description;
        }

        // check if metabox is allowed by user package
        $user_id = get_current_user_id();
        $metabox_key = Inventor_Metaboxes::get_metabox_key( $metabox_id, $post_type );
        $metabox_allowed = apply_filters( 'inventor_metabox_allowed', true, $metabox_key, $user_id );

        if ( $metabox_allowed ) {
            return $description;
        }

        // if not allowed, append info message
        $package = Inventor_Packages_Logic::get_package_for_user( $user_id );
        $package_name = empty( $package ) ? '' : $package->post_title;
        $message = sprintf( __( 'Your package "%s" does not allow you to public this information.', 'inventor-packages' ), $package_name );

        if( strpos( $description, $message ) === false ) {
            $description .= '<span class="missing-package-permission">' . $message . '</span>';
        }

        return $description;
    }

    /**
     * Adds package field to pricing table
     *
     * @access public
     * @return void
     */
    public static function pricing_package_field() {
        if ( ! class_exists( 'Inventor_Pricing' ) || ! defined( 'INVENTOR_PRICING_PREFIX' ) ) {
            return;
        }

        $pricing_metabox = CMB2_Boxes::get( INVENTOR_PRICING_PREFIX . 'general' );

        if ( ! empty( $pricing_metabox ) ) {
            $pricing_metabox->add_field( array(
                'id'            => INVENTOR_PRICING_PREFIX . 'package',
                'name'          => __( 'Package', 'inventor-packages' ),
                'type'          => 'select',
                'options'       => self::get_packages_choices( true, true ),
                'description'   => __( 'Button will be linked to the purchase page. You must create payment page (containing [inventor_payment]) which must be set up in customizer.', 'inventor-packages' ),
            ) );
        }
    }

    /**
     * Sets default package for user (if set)
     *
     * @access public
     * @param $user_id
     * @return void
     */
    public static function set_default_package_for_user( $user_id ) {
        $default_package = get_theme_mod( 'inventor_default_package', null );

        if ( ! empty( $default_package ) ) {
            self::set_package_for_user( $user_id, $default_package );
        }
    }

    /**
     * Validate user listings when user profile was updated in admin
     *
     * @access public
     * @param int $user_id
     * @param object $old_user_data
     * @return void
     */
    public static function user_profile_updated( $user_id,  $old_user_data ) {
        if ( is_admin() ) {
            self::validate_listings( false, $user_id );
        }
    }

    /**
     * Gets package valid until data for user
     *
     * @access public
     * @param $user_id
     * @param $formatted
     * @return bool|string
     */
    public static function get_package_valid_date_for_user( $user_id, $formatted = true ) {
        $valid = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package_valid', true );
        $infinite = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package_infinite', true );

        if ( $valid == -1 || $infinite ) {
            return false;
        }

        if ( ! empty( $valid ) ) {
            if ( ! $formatted ) {
                return $valid;
            } else {
                $date_format = get_option( 'date_format' );
                return date_i18n( $date_format, $valid );
            }
        }

        return false;
    }

    /**
     * Checks if user's package is valid
     *
     * @access public
     * @param $user_id
     * @return bool
     */
    public static function is_package_valid_for_user( $user_id ) {
        $infinite = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package_infinite', true );

        // infinite (for example free package)
        if ( $infinite ) {
            return true;
        }

        $valid = get_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package_valid', true );
        $today = strtotime( 'today' );

        if ( empty( $valid ) ) {
            return false;
        }

        // deprecated, backward compatibility
        if ( $valid == -1 ) {
            return true;
        }

        if ( $today > $valid ) {
            return false;
        }

        return true;
    }

    /**
     * Applies max categories per listing depending on user package
     *
     * @access public
     * @param $max_categories
     * @return int|bool
     */
    public static function max_listing_categories( $max_categories ) {
        $user_id = get_current_user_id();
        $package = self::get_package_for_user( $user_id );

        if ( $package && self::is_package_valid_for_user( $user_id ) ) {
            $max_categories = get_post_meta( $package->ID, INVENTOR_PACKAGE_PREFIX . 'max_categories', true );

            if ( ! is_numeric( $max_categories ) ) {
                $max_categories = false;
            }
        }

        return $max_categories;
    }

    /**
     * Gets remaining listings from user package
     *
     * @access public
     * @param $user_id
     * @return int|mixed|string
     */
    public static function get_remaining_listings_count_for_user( $user_id ) {
        $package = self::get_package_for_user( $user_id );

        if ( $package && self::is_package_valid_for_user( $user_id ) ) {
            $max_listings = get_post_meta( $package->ID, INVENTOR_PACKAGE_PREFIX . 'max_listings', true );

            if ( '-1' == $max_listings ) {
                return 'unlimited';
            }

            $user_listings = count( Inventor_Query::get_listings_by_user( $user_id )->posts );
            return $max_listings - $user_listings;
        }

        return 0;
    }

    /**
     * Get package by id
     *
     * @access public
     * @param $package_id int
     * @return object
     */
    public static function get_package( $package_id ) {
        $post = get_post( $package_id );

        if( ! $post || $post->post_type != 'package' || $post->post_status != 'publish' ) {
            return false;
        }

        return $post;
    }

    /**
     * Gets full package title
     *
     * @acces public
     * @param $package_id
     * @param $include_details
     * @return string
     */
    public static function get_package_title( $package_id, $include_details = false ) {
        $package = self::get_package( $package_id );

        if( ! $include_details ) {
            return $package->post_title;
        }

        $price_formatted = self::get_package_formatted_price( $package_id );
        $duration_formatted = self::get_package_duration( $package_id, true );

        $price_and_duration = sprintf( ' (%s/%s)', $price_formatted, $duration_formatted );

        # free package
        $price_and_duration = str_replace( ' (/)', '', $price_and_duration );

        # package without duration
        $price_and_duration = str_replace( '/)', ')', $price_and_duration );

        return trim( sprintf( '%s%s', $package->post_title, $price_and_duration ) );
    }

    /**
     * Gets package price
     *
     * @access public
     * @param $package_id
     * @return bool|float
     */
    public static function get_package_price( $package_id ) {
        $price = get_post_meta( $package_id, INVENTOR_PACKAGE_PREFIX . 'price', true );

        if ( ! isset( $price ) || ! is_numeric( $price ) ) {
            return false;
        }

        return $price;
    }

    /**
     * Gets package duration
     *
     * @access public
     * @param $package_id
     * @param $as_string
     * @return float|string
     */
    public static function get_package_duration( $package_id, $as_string = false ) {
        $duration = get_post_meta( $package_id, INVENTOR_PACKAGE_PREFIX . 'duration', true );

        if ( empty( $duration ) ) {
            return $as_string ? '' : false;
        }

        $durations = self::get_package_durations();

        $duration_formatted = ! empty ( $durations[ $duration ] ) ? $durations[ $duration ] : '';

        return $as_string ? $duration_formatted : $duration;
    }

    /**
     * Gets package duration length
     *
     * @access public
     * @param $package_id
     * @return int
     */
    public static function get_package_duration_length( $package_id ) {
        $duration = self::get_package_duration( $package_id );

        if ( empty( $duration ) ) {
            return null;
        }

        $durations_definition = apply_filters( 'inventor_package_durations', array() );

        foreach( $durations_definition as $definition ) {
            if ( $definition['key'] == $duration ) {
                return $definition['length'];
            }
        }

        return null;
    }

    /**
     * Gets package formatted price
     *
     * @access public
     * @param $package_id
     * @return bool|string
     */
    public static function get_package_formatted_price( $package_id ) {
        $price = self::get_package_price( $package_id );
        return Inventor_Price::format_price( $price );
    }

    /**
     * Checks if package exists
     *
     * @access public
     * @param null $package_id
     * @return bool
     */
    public static function package_exists( $package_id = null ) {
        if ( empty( $package_id ) ) {
            return false;
        }

        $package = self::get_package( $package_id );

        return $package != null;
    }

    /**
     * Sets package for user
     *
     * @access public
     * @param $user_id
     * @param $package_id
     * @return bool
     */
    public static function set_package_for_user( $user_id, $package_id ) {
        if ( empty( $user_id ) || empty( $package_id ) ) {
            return false;
        }

        if ( ! self::package_exists( $package_id ) ) {
            return false;
        }

        $duration_length = self::get_package_duration_length( $package_id );
        $package_valid = $duration_length ? strtotime( $duration_length ) : -1;

        update_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package_valid', $package_valid );
        update_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package_infinite', ! $duration_length );
        update_user_meta( $user_id, INVENTOR_USER_PREFIX . 'package', $package_id );

        do_action( 'inventor_user_package_was_set', $user_id, $package_id );

        self::validate_listings( false, $user_id );  // validate user listings

        return true;
    }

    /**
     * Checks if user is allowed to add submission
     *
     * @access public
     * @param $user_id
     * @return bool
     */
    public static function can_user_create_submission( $can, $user_id ) {
        if ( get_theme_mod( 'inventor_submission_type', 'free' ) == 'packages' ) {
            if ( self::is_package_valid_for_user( $user_id ) && ( self::get_remaining_listings_count_for_user( $user_id ) > 0 || self::get_remaining_listings_count_for_user( $user_id ) === 'unlimited' ) ) {
                return true;
            }

            return false;
        }

        return $can;
    }

    /**
     * Unpublish listings
     *
     * @access public
     * @param $listings
     * @return void
     */
    public static function unpublish( $listings ) {
        $items_to_unpublish = array();

        foreach ( $listings as $item ) {
            if ( $item->post_status != 'publish' ) {
                continue;
            }

            $items_to_unpublish[] += $item->ID;
        }

        if ( count( $items_to_unpublish ) > 0 ) {
            global $wpdb;

            $sql = 'UPDATE ' . $wpdb->prefix . 'posts SET post_status = \'draft\' WHERE ID IN (' . implode( ",", $items_to_unpublish ) . ');';

            $wpdb->get_results($sql);
        }
    }

    /**
     * Publish listings
     *
     * @access public
     * @param $listings
     * @return void
     */
    public static function publish( $listings ) {
        $review_before_publish = get_theme_mod( 'inventor_submission_review_before', false );

        $items_to_publish = array();

        foreach ( $listings as $item ) {
            if ( $item->post_status == 'publish' ) {
                continue;
            }

            if ( $review_before_publish && $item->post_status == 'draft' || ! $review_before_publish ) {
                $items_to_publish[] += $item->ID;
            }
        }

        if ( count( $items_to_publish ) > 0 ) {
            global $wpdb;

            $sql = 'UPDATE ' . $wpdb->prefix . 'posts SET post_status = \'publish\' WHERE ID IN (' . implode(",", $items_to_publish) . ');';

            $wpdb->get_results($sql);
        }
    }

    /**
     * Checks packages of all users and validates listing statuses
     *
     * @access public
     * @param bool $use_cache
     * @param int $user_id
     * @return void
     */
    public static function validate_listings( $use_cache = true, $user_id = null ) {
        if ( get_theme_mod('inventor_submission_type') != 'packages' ) {
            return;
        }

        if ( $use_cache ) {
            $last_validation = get_option( 'inventor_packages_last_validation', null );
            if ( $last_validation != null && time() - $last_validation < INVENTOR_PACKAGES_VALIDATION_THRESHOLD ) {
                return;
            }
        }

        if ( empty( $user_id ) ) {
            $users = get_users();
        } else {
            $users = array();
            $user = get_user_by( 'id', $user_id );
            if ( ! empty( $user ) ) {
                $users[] = $user;
            }
        }

        foreach ( $users as $user ) {
            $query = Inventor_Query::get_listings_by_user( $user->ID );

            $items = $query->posts;

            if ( count( $items ) == 0 ) {
                continue;
            }

            // Check if package is valid
            $is_package_valid = self::is_package_valid_for_user( $user->ID );

            if ( ! $is_package_valid ) {
                // Unpublish all listings
                self::unpublish( $items );
            } else {
                // Get remaining posts available to create
                $remaining = self::get_remaining_listings_count_for_user( $user->ID );

                if ( 'unlimited' == $remaining || $remaining >= 0 ) {
                    // Publish all listings
                    self::publish( $items );
                } else {
                    // Publish available listings
                    self::publish( array_slice( $items, abs( $remaining ) , count( $items ) - abs( $remaining ) ) );

                    // Unpublish abs(remaining) listings
                    self::unpublish( array_slice( $items, 0, abs( $remaining ) ) );
                }
            }
        }

        if ( empty( $user_id ) ) {
            // log last all users validation timestamp
            update_option( 'inventor_packages_last_validation', time() );
        }
    }

    /**
     * Process payment form
     *
     * @access public
     * @return void
     */
    public static function process_free_package_selection() {
        $action = ! empty( $_POST['action'] ) ? $_POST['action'] : '';
        $payment_type = ! empty( $_POST['payment_type'] ) ? $_POST['payment_type'] : '';
        $object_id = ! empty( $_POST['object_id'] ) ? $_POST['object_id'] : '';
        $price = ! empty( $_POST['price'] ) ? $_POST['price'] : '';
        $user_id = get_current_user_id();

        if( $action != 'set_free_package' || empty( $payment_type ) || empty( $object_id ) || empty( $user_id ) ) {
            return;
        }

        if ( $price != 0 || ! empty( $price ) || $payment_type != 'package' ) {
            return;
        }

        if ( ! self::is_package_free( $object_id ) ) {
            Inventor_Utilities::show_message( 'danger', __( 'Package is not free.', 'inventor-packages' ) );
            return;
        }

        if ( self::set_package_for_user( $user_id, $object_id ) ) {
            Inventor_Utilities::show_message( 'success', __( 'Package has been set.', 'inventor-packages' ) );
        } else {
            Inventor_Utilities::show_message( 'danger', __( 'Could not set package for user.', 'inventor-packages' ) );
        }

        wp_redirect( home_url() );
        exit();
    }

    /**
     * Handles payment and sets package for user
     *
     * @param bool $success
     * @param string $payment_type
     * @param int $object_id
     * @param float $price
     * @param string $currency_code
     * @param int $user_id
     * @return void
     */
    public static function catch_payment( $success, $gateway, $payment_type, $payment_id, $object_id, $price, $currency_code, $user_id, $billing_details ) {
        if ( $success && $payment_type == 'package' && $gateway != 'wire-transfer' ) {
            self::set_package_for_user( $user_id, $object_id );
            Inventor_Utilities::show_message( 'success', __( 'Package has been upgraded.', 'inventor-packages' ) );
        }
    }

    /**
     * Renders data before payment form
     *
     * @access public
     * @param string $payment_type
     * @param int $object_id
     * @param string $payment_gateway
     * @return string
     */
    public static function payment_form_before( $payment_type, $object_id, $payment_gateway ) {
        $attrs = array(
            'payment_type'      => $payment_type,
            'object_id'         => $object_id,
            'payment_gateway'   => $payment_gateway,
        );

        echo Inventor_Template_Loader::load( 'payment-form-before', $attrs, INVENTOR_PACKAGES_DIR );
    }

    /**
     * Renders payment form additional fields
     *
     * @access public
     * @param string $payment_type
     * @param int $object_id
     * @param string $payment_gateway
     * @return string
     */
    public static function payment_form_fields( $payment_type, $object_id, $payment_gateway ) {
        $attrs = array(
            'payment_type'      => $payment_type,
            'object_id'         => $object_id,
            'payment_gateway'   => $payment_gateway,
        );

        echo Inventor_Template_Loader::load( 'payment-form-fields', $attrs, INVENTOR_PACKAGES_DIR );
    }

    /**
     * Checks user package and its listing types restriction
     *
     * @access public
     * @param array $listing_types
     * @return array
     */
    public static function disable_listing_types_on_frontend( $listing_types ) {
        if ( ! is_user_logged_in() ) {
            return $listing_types;
        }

        $package = self::get_package_for_user();

        if ( empty( $package ) ) {
            return $listing_types;
        }

        $restriction = get_post_meta( $package->ID, INVENTOR_PACKAGE_PREFIX . 'listing_types_restriction', true );

        if ( $restriction != 'on' )
            return $listing_types;

        $listing_types_allowed = get_post_meta( $package->ID, INVENTOR_PACKAGE_PREFIX . 'listing_types_allowed', true );

        if ( ! is_array( $listing_types_allowed ) || empty( $listing_types_allowed ) ) {
            return array();
        }

        $listing_types_allowed_and_enabled = array_intersect( $listing_types, $listing_types_allowed );

        return $listing_types_allowed_and_enabled;
    }
}

Inventor_Packages_Logic::init();
