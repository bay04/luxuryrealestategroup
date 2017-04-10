<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Notifications_Logic
 *
 * @class Inventor_Notifications_Logic
 * @package Inventor_Notifications/Classes
 * @author Pragmatic Mates
 */
class Inventor_Notifications_Logic {
    /**
     * Initialize Notifications functionality
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'hook_post_statuses' ), 13 );

        # set notification emails
        add_action( 'future_to_publish', array( __CLASS__, 'process_notification' ), 10, 1 );

        # catch package change
        add_action( 'inventor_user_package_was_set', array( __CLASS__, 'create_package_expiration_notifications' ), 10, 1 );

        # add mail actions for mail templates
        add_filter( 'inventor_mail_actions_choices', array( __CLASS__, 'mail_actions_choices' ) );

        # catch payment
        add_action( 'inventor_payment_processed', array( __CLASS__, 'catch_payment' ), 10, 9 );
    }

    /**
     * Adds mail actions for package and submission system
     *
     * @access public
     * @param array $choices
     * @return array
     */
    public static function mail_actions_choices( $choices ) {
        # packages
        $choices[ INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE ] = __( 'Package will expire', 'inventor-notifications' );
        $choices[ INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED ] = __( 'Package expired', 'inventor-notifications' );
        $choices[ INVENTOR_MAIL_ACTION_PACKAGE_PURCHASED_ADMIN ] = __( 'Package purchased - for admin', 'inventor-notifications' );

        # submissions
        $choices[ INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN ] = __( 'Submission waiting for review - for admin', 'inventor-notifications' );
        $choices[ INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER ] = __( 'Submission waiting for review - for user', 'inventor-notifications' );
        $choices[ INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN ] = __( 'Submission published - for admin', 'inventor-notifications' );
        $choices[ INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER ] = __( 'Submission published - for user', 'inventor-notifications' );
        return $choices;
    }

    /**
     * Returns types for notification post type
     *
     * @access public
     * @return array
     */
    public static function get_notification_types() {
        return self::mail_actions_choices( array() );
    }

    /**
     * Gets Notifications config.
     * This config is used for custom actions triggering
     *
     * @access public
     * @return array|bool
     */
    public static function get_config() {
        $package_will_expire_enabled = get_theme_mod( 'inventor_notifications_package_will_expire', false );
        $package_expiration_warning_threshold = get_theme_mod( 'inventor_notifications_package_expiration_warning_threshold', false );
        $package_expired_enabled = get_theme_mod( 'inventor_notifications_package_expired', false );
        $package_purchased_admin_enabled = get_theme_mod( 'inventor_notifications_package_purchased_admin', false );
        $submission_pending_admin_enabled = get_theme_mod( 'inventor_notifications_submission_pending_admin', false );
        $submission_pending_user_enabled = get_theme_mod( 'inventor_notifications_submission_pending_user', false );
        $submission_published_admin_enabled = get_theme_mod( 'inventor_notifications_submission_published_admin', false );
        $submission_published_user_enabled = get_theme_mod( 'inventor_notifications_submission_published_user', false );

        $notifications_config = array(
            "package_will_expire_enabled"           => $package_will_expire_enabled,
            "package_expiration_warning_threshold"  => $package_expiration_warning_threshold,
            "package_expired_enabled"               => $package_expired_enabled,
            "package_purchased_admin_enabled"       => $package_purchased_admin_enabled,
            "submission_pending_admin_enabled"      => $submission_pending_admin_enabled,
            "submission_pending_user_enabled"       => $submission_pending_user_enabled,
            "submission_published_admin_enabled"    => $submission_published_admin_enabled,
            "submission_published_user_enabled"     => $submission_published_user_enabled,
        );

        return $notifications_config;
    }

    /**
     * Catches post status changes
     * This config is used for custom actions triggering
     *
     * @access public
     * @return array|bool
     */
    public static function hook_post_statuses() {
        # new submission was published (with or without admin review need)
        add_action( 'transition_post_status', array( __CLASS__, 'create_submission_published_notifications' ), 10, 3 );

        foreach( Inventor_Post_Types::get_listing_post_types() as $listing_type ) {
            # new submission was created but needs to be reviewed
            add_action( sprintf( 'pending_%s', $listing_type ), array( __CLASS__, 'create_submission_pending_notifications' ), 10, 1 );
        }
    }

    /**
     * Gets user notifications by action
     *
     * @access public
     * @param int $user_id
     * @param array $actions
     * @param string $status
     * @return WP_Query
     */
    public static function get_notifications_by_user( $user_id, $actions = array(), $status = 'any' ) {
        $query = array(
            'author'            => $user_id,
            'post_type'         => 'notification',
            'posts_per_page'    => -1,
            'post_status'       => $status,
        );

        if ( count( $actions ) > 0 ) {
            $query['meta_key']      = INVENTOR_NOTIFICATION_PREFIX . 'action';
            $query['meta_value']    = $actions;
            $query['meta_compare']  = 'IN';
        }

        return new WP_Query( $query );
    }

    /**
     * Process scheduled notification
     *
     * @access public
     * @param $post
     * @return void
     */
    public static function process_notification( $post ) {
        if ( $post->post_type == 'notification' ) {
            $config = self::get_config();
            $action = get_post_meta( $post->ID, INVENTOR_NOTIFICATION_PREFIX . 'action', true );

            if (
                INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE == $action && ! $config['package_will_expire_enabled'] ||
                INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED == $action && ! $config['package_expired_enabled'] ||
                INVENTOR_MAIL_ACTION_PACKAGE_PURCHASED_ADMIN == $action && ! $config['package_purchased_admin_enabled'] ||
                INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN == $action && ! $config['submission_pending_admin_enabled'] ||
                INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER == $action && ! $config['submission_pending_user_enabled'] ||
                INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN == $action && ! $config['submission_published_admin_enabled'] ||
                INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER == $action && ! $config['submission_published_user_enabled']
            ) return;

            self::sent_email( $post );
        }
    }

    /**
     * Sent notification email
     *
     * @access public
     * @param $notification
     * @return void
     */
    public static function sent_email( $notification ) {
        # recipient
        $author_email = get_the_author_meta( 'user_email', $notification->post_author );
        $author_name = get_the_author_meta( 'display_name', $notification->post_author );
        $to = $author_name . '<'. $author_email .'>';

        # subject
        $subject = get_the_title( $notification->ID );

        # body
        $message = $notification->post_content;

        # admin
        $admin_email = get_bloginfo( 'admin_email' );
        $admin = get_user_by( 'email', $admin_email );
        $admin_name = $admin->user_nicename;

        # headers
        $headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $admin_name, $admin_email );

        $result = wp_mail( $to, $subject, $message, $headers );
    }

    /**
     * Get default title by action
     *
     * @access public
     * @param $action
     * @param $object
     * @param $args
     * @return string
     */
    public static function get_title_by_action( $action, $object, $args = array() ) {
        $config = self::get_config();
        $object_title = get_the_title( $object );
        $threshold = $config['package_expiration_warning_threshold'];

        $args['object'] = $object_title;

        // TODO: extend submission args with default args
        $submission_args = array(
            'listing' => $object_title,
            'listing_type' => Inventor_Post_Types::get_listing_type_name( $object->ID ),
            'listing_url' => get_permalink( $object->ID ),
            'author' => Inventor_Post_Type_User::get_full_name( $object->post_author )
        );
        $username = Inventor_Post_Type_User::get_full_name( get_current_user_id() );

        switch( $action ) {
            case INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE:
                $args['package'] = $object_title;
                $args['threshold'] = $threshold;
                $title = __( 'Your package will expire soon' , 'inventor-notifications' );
                break;
            case INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED:
                $args['package'] = $object_title;
                $title = __( 'Your package expired' , 'inventor-notifications' );
                break;
            case INVENTOR_MAIL_ACTION_PACKAGE_PURCHASED_ADMIN:
                $args['package'] = $object_title;
                $args['user'] = $username;
                $title = __( 'Package purchased' , 'inventor-notifications' );
                break;
            case INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN:
                $args = $submission_args;
                $title = __( 'New submission waiting for review' , 'inventor-notifications' );
                break;
            case INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER:
                $args = $submission_args;
                $title = __( 'Submission waiting for review' , 'inventor-notifications' );
                break;
            case INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN:
                $args = $submission_args;
                $title = __( 'New submission was published' , 'inventor-notifications' );
                break;
            case INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER:
                $args = $submission_args;
                $title = __( 'Your submission was published' , 'inventor-notifications' );
                break;
            default:
                $title = $action;
        }

        $title = apply_filters( 'inventor_mail_subject', $title, $action, $args );
        return $title;
    }

    /**
     * Get default content by action
     *
     * @access public
     * @param $action
     * @param $object
     * @param $args
     * @return string
     */
    public static function get_content_by_action( $action, $object, $args = array() ) {
        $config = self::get_config();
        $object_title = get_the_title( $object );
        $threshold = $config['package_expiration_warning_threshold'];

        $args['object'] = $object_title;
        $username = Inventor_Post_Type_User::get_full_name( get_current_user_id() );

        // TODO: extend submission args with default args
        $submission_args = array(
            'listing' => $object_title,
            'listing_type' => Inventor_Post_Types::get_listing_type_name( $object->ID ),
            'listing_url' => get_permalink( $object->ID ),
            'author' => Inventor_Post_Type_User::get_full_name( $object->post_author )
        );

        if ( class_exists( 'Inventor_Packages' ) ) {
            $package = Inventor_Packages_Logic::get_package_for_user( $object->post_author );
            $submission_args[ 'package' ] = $package ? get_the_title( $package ) : '';
        }

        switch( $action ) {
            case INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE:
                $args['package'] = $object_title;
                $args['threshold'] = $threshold;
                $content = sprintf( __( 'Your package %s will expire in %d days.', 'inventor-notifications' ), $object_title, $threshold );
                break;
            case INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED:
                $args['package'] = $object_title;
                $content = sprintf( __( 'Your package %s expired.' , 'inventor-notifications' ), $object_title );
                break;
            case INVENTOR_MAIL_ACTION_PACKAGE_PURCHASED_ADMIN:
                $args['package'] = $object_title;;
                $args['user'] = $username;
                $content = sprintf( __( 'User %s purchased package %s (%s).' , 'inventor-notifications' ), $username, $object_title, $args['gateway'] );
                break;
            case INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN:
                $args = $submission_args;
                $content = sprintf( __( 'New pending submission %s is waiting for admin review.' , 'inventor-notifications' ), $object_title );
                break;
            case INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER:
                $args = $submission_args;
                $content = sprintf( __( 'Your submission %s is waiting for admin review. Until then, it will be not published.' , 'inventor-notifications' ), $object_title );
                break;
            case INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN:
                $args = $submission_args;
                $content = sprintf( __( 'New submission %s was published.' , 'inventor-notifications' ), $object_title );
                break;
            case INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER:
                $args = $submission_args;
                $content = sprintf( __( 'Your submission %s was published.' , 'inventor-notifications' ), $object_title );
                break;
            default:
                $content = $action;
        }

        $content = apply_filters( 'inventor_mail_body', $content, $action, $args );

        return $content;
    }

    /**
     * Create notification
     *
     * @access public
     * @param $action
     * @param $object
     * @param $user_id
     * @param $schedule_date
     * @param $args
     * @return void
     */
    public static function create_notification( $action, $object, $user_id, $schedule_date = null, $args = array() ) {
        if ( $schedule_date == null ) {
            $schedule_date = strtotime( 'now' ) + 60;
        }

        $notification_id = wp_insert_post( array(
            'post_type'     => 'notification',
            'post_title'    => self::get_title_by_action( $action, $object, $args ),
            'post_content'  => self::get_content_by_action( $action, $object, $args ),
            'post_status'   => 'future',
            'post_author'   => $user_id,
            'post_date'     => date( 'Y-m-d H:i:s', $schedule_date ),
            'post_date_gmt' => date( 'Y-m-d H:i:s', $schedule_date )
        ) );

        update_post_meta( $notification_id, INVENTOR_NOTIFICATION_PREFIX . 'action', $action );
    }

    /**
     * Create admin and user notifications for published submission
     *
     * @access public
     * @param $new_status
     * @param $old_status
     * @param $post
     * @return void
     */
    public static function create_submission_published_notifications( $new_status, $old_status, $post ) {
        $post_type = get_post_type( $post );
        $listing_post_types = Inventor_Post_Types::get_listing_post_types();
        $config = self::get_config();

        if ( ! in_array( $post_type, $listing_post_types ) ) {
            return;
        }

        if ( $new_status != 'publish' || ! in_array( $old_status, array( 'new', 'auto-draft', 'draft', 'pending', 'future' ) ) ) {
            return;
        }

        // admin does not have to be informed about published submission he reviewed himself
        if ( $config['submission_published_admin_enabled'] && ! get_theme_mod( 'inventor_submission_review_before', false ) ) {

            // notify admins
            $admins = Inventor_Utilities::get_site_admins();

            foreach ( $admins as $admin ) {
                $user = get_user_by( 'login', $admin );
                $user_id = $user->ID;

                self::create_notification( INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_ADMIN, $post, $user_id );
            }
        }

        // notify post author
        if ( $config['submission_published_user_enabled'] ) {
            $user_id = $post->post_author;

            self::create_notification( INVENTOR_MAIL_ACTION_SUBMISSION_PUBLISHED_USER, $post, $user_id );
        }
    }

    /**
     * Create admin and user notifications for pending submission
     *
     * @access public
     * @param $post_id
     * @return void
     */
    public static function create_submission_pending_notifications( $post_id ) {
        $config = self::get_config();
        $post = get_post( $post_id );

        // notify user
        if ( $config['submission_pending_user_enabled'] ) {
            $user_id = $post->post_author;

            self::create_notification( INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_USER, $post, $user_id );
        }

        // notify admins
        if ( $config['submission_pending_admin_enabled'] ) {
            $admins = Inventor_Utilities::get_site_admins();

            foreach($admins as $admin) {
                $user = get_user_by( 'login', $admin );
                $user_id = $user->ID;
                self::create_notification( INVENTOR_MAIL_ACTION_SUBMISSION_PENDING_ADMIN, $post, $user_id );
            }
        }
    }

    /**
     * Create notifications for package expiration
     *
     * @access public
     * @param $user_id
     * @return void
     */
    public static function create_package_expiration_notifications( $user_id ) {
        $existing_notifications = self::get_notifications_by_user( 1, array( INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE, INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED ) );

        foreach( $existing_notifications->posts as $notification ) {
            wp_trash_post( $notification->ID );
        }

        if ( class_exists( 'Inventor_Packages_Logic' ) ) {
            $package = Inventor_Packages_Logic::get_package_for_user( $user_id );
            $valid_until = Inventor_Packages_Logic::get_package_valid_date_for_user( $user_id, false );
            $config = self::get_config();

            if ( ! $valid_until ) {
                return;
            }

            if ( $config['package_expired_enabled'] ) {
                self::create_notification( INVENTOR_MAIL_ACTION_PACKAGE_EXPIRED, $package, $user_id, $valid_until );
            }

            if ( $config['package_will_expire_enabled'] ) {
                $threshold = $config['package_expiration_warning_threshold'];
                $schedule_date = $valid_until - $threshold * 60 * 60 * 24;
                self::create_notification( INVENTOR_MAIL_ACTION_PACKAGE_WILL_EXPIRE, $package, $user_id, $schedule_date );
            }
        }
    }

    /**
     * Catches payment and creates admin notifications for purchased package
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
        if ( ! $success || $payment_type != 'package' ) {
            return;
        }

        $config = self::get_config();

        if ( ! $config['package_purchased_admin_enabled'] ) {
            return;
        }

        $package = get_post( $object_id );
        $payment_gateways = apply_filters( 'inventor_payment_gateways', array() );
        $gateway_title = array_key_exists( $gateway, $payment_gateways ) ? $payment_gateways[ $gateway ]['title'] : $gateway;

        $extra_args = array(
            'gateway' => $gateway_title
        );

        // notify admins
        $admins = Inventor_Utilities::get_site_admins();

        foreach ( $admins as $admin ) {
            $user = get_user_by( 'login', $admin );
            $user_id = $user->ID;

            self::create_notification( INVENTOR_MAIL_ACTION_PACKAGE_PURCHASED_ADMIN, $package, $user_id, null, $extra_args );
        }
    }
}

Inventor_Notifications_Logic::init();
