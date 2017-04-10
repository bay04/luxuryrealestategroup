<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Submission_Logic
 *
 * @class Inventor_Submission
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Submission_Logic {
    /**
     * Initialize submission
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'template_redirect', array( __CLASS__, 'single_listing_type_redirect' ), 0 );
        add_action( 'init', array( __CLASS__, 'process_remove_form' ), 9999 );
        add_action( 'cmb2_init', array( __CLASS__, 'merge_metaboxes_into_single_step' ), 99 );
        add_action( 'cmb2_init', array( __CLASS__, 'process_submission' ), 9999 );
        add_action( 'transition_post_status', array( __CLASS__, 'update_general_metabox_fields' ), 10, 3 );
        add_action( 'inventor_payment_form_before', array( __CLASS__, 'payment_form_before' ), 10, 3 );
        add_action( 'inventor_payment_processed', array( __CLASS__, 'catch_payment' ), 10, 9 );

        add_filter( 'the_posts', array( __CLASS__, 'show_pending_listings_visible_to_author' ), 10, 2 );
        add_filter( 'the_title', array( __CLASS__, 'append_listing_title_to_edit_page_title' ) );
        add_filter( 'inventor_metabox_field_default', array( __CLASS__, 'metabox_default_field_value' ), 10, 4 );
        add_filter( 'inventor_payment_types', array( __CLASS__, 'add_payment_types' ) );
        add_filter( 'inventor_prepare_payment', array( __CLASS__, 'prepare_payment' ), 10, 3 );
        add_filter( 'inventor_payment_form_price_value', array( __CLASS__, 'payment_price_value' ), 10, 3 );
    }

    /**
     * Gets list of listings from favorites
     *
     * @access public
     * @return void
     */
    public static function single_listing_type_redirect() {
        if ( isset( $_GET['type'] ) ) {
            return;
        }

        // submission create page
        $submission_create_page = get_theme_mod( 'inventor_submission_create_page' );

        if( ! $submission_create_page ) {
            return;
        }

        $submission_create_page_url = $submission_create_page ? get_permalink( $submission_create_page ) : null;

        // get current URL
        $protocol = is_ssl() ? 'https://' : 'http://';
        $current_url = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

        if( $current_url == $submission_create_page_url ) {
            $post_types = Inventor_Post_Types::get_listing_post_types();
            if ( count( $post_types ) == 1 ) {
                $post_type = $post_types[0];
                $redirect_url = $submission_create_page_url . '?type=' . $post_type;
                wp_redirect( $redirect_url );
                exit;
            }
        }
    }

    /**
     * Checks if user is allowed to add submission
     *
     * @access public
     * @param $user_id
     * @return bool
     */
    public static function is_allowed_to_add_submission( $user_id ) {
        return apply_filters( 'inventor_submission_can_user_create', true, $user_id );
    }

    /**
     * Merges listing metaboxes into single submission step
     *
     * @access public
     * @return void
     */
    public static function merge_metaboxes_into_single_step() {
        if ( is_admin() ) {
            return;
        }

        $single_step_enabled = get_theme_mod( 'inventor_submission_single_step', false );

        if ( ! $single_step_enabled ) {
            return;
        }

        $listing_types = Inventor_Post_Types::get_listing_post_types( false, true );

        foreach( $listing_types as $post_type => $label ) {
            $metaboxes = Inventor_Metaboxes::get_for_post_type( $post_type );

            if ( empty( $metaboxes ) ) {
                continue;
            }

            $metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_single_step';

            $single_step = new_cmb2_box( array(
                'id'            => $metabox_id,
                'title'			=> apply_filters( 'inventor_metabox_title', $label, $metabox_id, $post_type ),
                'description'   => apply_filters( 'inventor_metabox_description', '', $metabox_id, $post_type ),
                'object_types'  => array( $post_type ),
                'context'       => 'normal',
                'priority'      => 'high',
                'skip'          => true,
            ) );

            foreach( $metaboxes as $metabox_id => $metabox ) {
                $fields = $metabox->meta_box['fields'];

                if ( empty( $fields ) ) {
                    continue;
                }

                $metabox_key = Inventor_Metaboxes::get_metabox_key( $metabox->meta_box['id'], $post_type );
                $metabox_title_id = INVENTOR_LISTING_PREFIX . 'metabox_' . $metabox_key . '_title';

                $single_step->add_field( array(
                    'id'            => $metabox_title_id,
                    'name'	        => $metabox->meta_box['title'],
                    'description'	=> empty( $metabox->meta_box['description'] ) ? null : $metabox->meta_box['description'],
                    'type'          => 'title',
                    'tag'           => 'h3'
                ) );

                foreach( $fields as $field ) {
                    $single_step->add_field( $field );
                }
            }
        }
    }

    /**
     * Makes pending listings visible to listing author
     *
     * @access public
     * @param $posts
     * @param $wp_query
     * @return array
     */
    public static function show_pending_listings_visible_to_author( $posts, $wp_query ) {
        if ( ! is_user_logged_in() || empty( $wp_query->query['p'] ) || empty( $wp_query->query['post_type'] ) ) {
            return $posts;
        }

        $post_id = $wp_query->query['p'];
        $post = get_post( $post_id );

        if ( $post && $post->post_author == get_current_user_id() ) {
            return array( $post );
        }

        return $posts;
    }

    /**
     * Appends listing title to the edit page title
     *
     * @access public
     * @return string
     */
    public static function append_listing_title_to_edit_page_title( $page_title ) {
        $submission_edit_page_id = get_theme_mod( 'inventor_submission_edit_page', false );

        if ( isset( $_GET['id'] ) && ! empty( $submission_edit_page_id ) && is_page( $submission_edit_page_id ) ) {
            $submission_edit_page = get_post( $submission_edit_page_id );

            if ( $submission_edit_page->post_title != $page_title ) {
                return $page_title;
            };

            $listing_id = esc_attr( $_GET['id'] );
            $listing = get_post( $listing_id );
            return $page_title . ' ' . $listing->post_title;
        }

        return $page_title;
    }

    /**
     * Get list of all steps needed to create new submission
     *
     * @access public
     * @param $post_type
     * @return array
     */
    public static function get_submission_steps( $post_type ) {
        if ( $post_type == null ) {
            return array();
        }

        $steps = array();

        $single_step_enabled = get_theme_mod( 'inventor_submission_single_step', false );

        if ( $single_step_enabled ) {
            $metabox_key = 'single_step';
            $metabox_id = INVENTOR_LISTING_PREFIX . $post_type . '_' . $metabox_key;

            $single_step = CMB2_Boxes::get( $metabox_id );
            $description = empty( $single_step->meta_box['description'] ) ? null : $single_step->meta_box['description'];
            $description = apply_filters( 'inventor_metabox_description', $description, $metabox_id, $post_type );

            $steps['single_step'] = array(
                'metabox_id'  => $metabox_id,
                'title'       => $single_step->meta_box['title'],
                'description' => $description,
            );

        } else {
            $meta_boxes = Inventor_Metaboxes::get_for_post_type( $post_type );

            if ( ! empty( $meta_boxes ) ) {
                foreach ( $meta_boxes as $meta_box ) {
                    $metabox_id = $meta_box->cmb_id;
                    $metabox_key = Inventor_Metaboxes::get_metabox_key( $meta_box->cmb_id, $post_type );

                    if ( $metabox_key == 'banner' && count( Inventor_Metaboxes::enabled_banner_types() ) == 0 ) {
                        continue;
                    }

                    $description = empty( $meta_box->meta_box['description'] ) ? null : $meta_box->meta_box['description'];

                    $steps[ $metabox_key ] = array(
                        'metabox_id'  => $metabox_id,
                        'title'       => $meta_box->meta_box['title'],
                        'description' => $description,
                    );
                }
            }
        }

        return apply_filters( 'inventor_submission_steps', $steps, $post_type );
    }

    /**
     * Get next submission step
     *
     * @access public
     * @param $post_type
     * @param $current_step
     * @return string|bool
     */
    public static function get_next_step( $post_type, $current_step ) {
        $steps = self::get_submission_steps( $post_type );

        $ids = array_keys( $steps );
        $current_index = array_search( $current_step, $ids );
        $next_index = $current_index + 1;

        if ( array_key_exists( $next_index, $ids ) ) {
            return $ids[ $next_index ];
        }

        return false;
    }

    /**
     * Returns current submission step (metabox key)
     *
     * @access public
     * @return string
     */
    public static function get_current_step() {
        if( ! empty( $_GET['step'] ) ) {
            return $_GET['step'];
        }

        $single_step_enabled = get_theme_mod( 'inventor_submission_single_step', false );

        if ( $single_step_enabled ) {
            return "single_step";
        }

        $type = self::get_current_type();
        $steps = self::get_submission_steps( $type );
        $steps_keys = array_keys( $steps );
        return count( $steps_keys ) > 0 ? $steps_keys[0] : null;
    }

    /**
     * Returns current listing type (post type)
     *
     * @access public
     * @return string
     */
    public static function get_current_type() {
        return empty( $_GET['type'] ) ? null : $_GET['type'];
    }

    /**
     * Process submission form
     *
     * @access public
     * @return void
     */
    public static function process_submission() {
        $type = self::get_current_type();
        $valid_type = ! empty( $type ) && in_array( $type, Inventor_Post_Types::get_listing_post_types() );

        if ( $valid_type ) {
            $step = self::get_current_step();
        }

        if ( empty( $step ) ) {
            return;
        }

        // saves data from current step to visitor storage
        self::process_submission_step( $step, $type, $_POST );

        // save action
        if ( $valid_type && ! empty( $_POST['action'] ) && $_POST['action'] == 'save' ) {
            $post_id = self::process_submission_save( $type );

            $url = home_url();

            if ( ! empty( $_GET['id'] ) && ! empty( $step ) && ! empty( $type ) ) {
                $submission_edit_page = get_theme_mod( 'inventor_submission_edit_page', false );
                if ( ! empty( $submission_edit_page ) ) {
                    $url = get_permalink( $submission_edit_page );
                    $url = $url . '?' . http_build_query( array(
                        'id'    => $_GET['id'],
                        'type'  => $type,
                        'step'  => $step,
                    ) );
                }
            } else {
                // redirect to my listings page (if exists)
                // if page does not exist, redirect to post detail
                $submission_list_page = get_theme_mod( 'inventor_submission_list_page', false );
                $page_id = empty( $submission_list_page ) ? $post_id : $submission_list_page;
                $url = get_permalink( $page_id );
            }

            wp_redirect( $url );
            exit();
        }

        // next step
        if ( ! empty( $_POST ) && ! empty( $_POST['submit-submission'] ) ) {
            $next_step = self::get_next_step( $type, $step );

            // parameters for GET request
            $params = array(
                'type' => $type
            );

            if ( ! empty( $_GET['id'] ) ) {
                $params['id'] = $_GET['id'];
            }

            if ( ! empty( $step ) ) {
                $params['step'] = $step;
            }

            if ( $next_step !== false ) {
                $params['step'] = $next_step;
            }

            // Append parameters for GET request
            $url = '?' . http_build_query( $params );

            wp_redirect( $url );
            exit();
        }
    }

    /**
     * Saves all submission steps
     *
     * @access public
     * @param $post_type
     * @return int
     */
    public static function process_submission_save( $post_type ) {
        $post_id = ! empty( $_GET['id'] ) ? $_GET['id'] : false;
        $step = self::get_current_step();
        $single_step = get_theme_mod( 'inventor_submission_single_step', false );
        $review_before = get_theme_mod( 'inventor_submission_review_before', false );
        $submission_type = get_theme_mod( 'inventor_submission_type', false );

        $general_metabox_key = $single_step ? 'single_step' : 'general';

        $old_status = $post_id === false ? 'draft' : get_post_status( $post_id );
        $post_status = $submission_type == 'pay-per-post' ? $old_status : 'publish';  // default post status

        if ( $review_before && get_post_status( $post_id ) != 'publish' && $submission_type != 'pay-per-post' ) {
            $post_status = 'pending';
        }

        // If we are updating the post, get the old one. We need old post to set proper
        // post_date value because just modified post will be at the top in archive pages.
        if ( ! empty( $post_id ) ) {
            $old_post  = get_post( $post_id );
            $post_date = $old_post->post_date;
            $comment_status = $old_post->comment_status;
        } else {
            $post_date = '';
            $comment_status = '';
        }

        $submission_data = self::get_submission_data();

        $title = self::get_submission_field_value( INVENTOR_LISTING_PREFIX . $post_type . '_' . $general_metabox_key, INVENTOR_LISTING_PREFIX  . 'title' );
        $description = self::get_submission_field_value( INVENTOR_LISTING_PREFIX . $post_type . '_' . $general_metabox_key, INVENTOR_LISTING_PREFIX  . 'description' );

        $data = array(
            'post_title'        => sanitize_text_field( $title ),
            'post_author'       => get_current_user_id(),
            'post_status'       => $post_status,
            'post_type'         => $post_type,
            'post_date'         => $post_date,
            'post_content'      => wp_kses( $description, wp_kses_allowed_html( 'post' ) ),
            'comment_status'    => $comment_status
        );

        if ( ! empty( $post_id ) ) {
            $new_post = false;
            $data['ID'] = $post_id;
        } else {
            $new_post = true;
        }

        $post_id = wp_insert_post( $data, true );

        if ( ! empty( $post_id ) ) {
            $_POST['object_id'] = $post_id;
            $post_id = $_POST['object_id'];

            if ( ! empty( $submission_data ) ) {

                // iterate each step and save metabox field values
                foreach ( $submission_data as $metabox_id => $value ) {
                    $cmb = cmb2_get_metabox( $metabox_id, $post_id );

                    // TODO: check if $cmb is not empty
                    $cmb->save_fields( $post_id, $cmb->object_type(), $value );
                }

                // Create featured image
                $featured_image_id = self::get_submission_field_value( INVENTOR_LISTING_PREFIX . $post_type . '_' . $general_metabox_key, INVENTOR_LISTING_PREFIX  . 'featured_image_id' );

                if ( ! empty( $featured_image_id ) ) {
                    set_post_thumbnail( $post_id, $featured_image_id );
                } else {
                    update_post_meta( $post_id, INVENTOR_LISTING_PREFIX  . 'featured_image_id', null );
                    delete_post_thumbnail( $post_id );
                }

                Inventor_Visitor::unset_data( 'submission' );
            }

            if ( $new_post ) {
                // action
                do_action( 'inventor_submission_listing_created', $post_id, $post_type );

                // message
                Inventor_Utilities::show_message( 'success', __( 'New submission has been successfully created.', 'inventor-submission' ) );
            } else {
                // action
                do_action( 'inventor_submission_listing_updated', $post_id, $post_type, $step );

                // message
                Inventor_Utilities::show_message( 'success', __( 'Submission has been successfully updated.', 'inventor-submission' ) );
            }
        }

        return $post_id;
    }

    /**
     * Get submission step data from POST payload
     *
     * @access public
     * @param array $payload
     * @return mixed
     */
    public static function get_payload_data( $payload ) {
        $data = array();

        foreach( $payload as $key => $value ) {
            $parts = explode( '_', $key );

            $submission_prefixes = array();

            if( defined( 'INVENTOR_LISTING_PREFIX' ) ) {
                $submission_prefixes[] = INVENTOR_LISTING_PREFIX;
            }

            if( defined( 'INVENTOR_BOOKINGS_PREFIX' ) ) {
                $submission_prefixes[] = INVENTOR_BOOKINGS_PREFIX;
            }

            if( defined( 'INVENTOR_SHOP_PREFIX' ) ) {
                $submission_prefixes[] = INVENTOR_SHOP_PREFIX;
            }

            if ( in_array( $parts[0] . '_', $submission_prefixes ) ) {
                if ( ! empty( $value ) ) {
                    $data[ $key ] = $value;
                }
            }
        }

        return $data;
    }

    /**
     * Process submission step and save data into session
     *
     * @access public
     * @param $metabox_key
     * @param $post_type
     * @param $payload
     * @return mixed
     */
    public static function process_submission_step( $metabox_key, $post_type, $payload ) {
        $metabox_id = Inventor_Metaboxes::get_metabox_id( $metabox_key, $post_type );

        $step_payload = array();
        $data = self::get_payload_data( $payload );

        if ( is_array( $data ) && count( $data ) > 0 ) {
            $submission_data = Inventor_Visitor::get_data('submission');
            $submission_data[ $metabox_id ] = $data;
            Inventor_Visitor::save_data( 'submission', $submission_data );
            $step_payload[ $metabox_id ] = $data;
        }

        return $step_payload;
    }

    /**
     * Extend submission data with current payload
     *
     * @access public
     * @return null|string
     */
    public static function get_submission_data() {
        $submission_data = Inventor_Visitor::get_data('submission');

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            if ( 'COOKIE' == apply_filters( 'inventor_visitor_data_destination', INVENTOR_DEFAULT_VISITOR_DATA_STORAGE ) ) {
                // cookies workaround
                $current_step = self::get_current_step();
                $current_type = self::get_current_type();

                $current_metabox_id = Inventor_Metaboxes::get_metabox_id( $current_step, $current_type );

                $payload = self::get_payload_data( $_POST );

                if ( ! is_array( $payload ) || count( $payload ) == 0 ) {
                    // can't be empty array(), because CMB2 will skip it and empty values won't be saved
                    $payload = array( null );
                }

                $submission_data[ $current_metabox_id ] = $payload;
            }
        }

        return $submission_data;
    }

    /**
     * Get default field value for front end submission forms.
     * Default value is set if value was not stored before.
     *
     * @param $meta_box_id
     * @param $field_id
     * @return null|string
     */
    public static function get_submission_field_value( $meta_box_id, $field_id ) {
        if ( is_admin() ) {
            return null;
        }

        $submission_data = self::get_submission_data();

        if ( ! empty( $submission_data ) && ! empty( $submission_data[ $meta_box_id ] ) && ! empty( $submission_data[ $meta_box_id ][ $field_id ] ) ) {
            return $submission_data[ $meta_box_id ][ $field_id ];
        } elseif ( ! empty( $_GET['id'] ) ) {
            $post_id = esc_attr( $_GET['id'] );
            $post = get_post( $post_id );

            if ( $post ) {
                switch ( $field_id ) {
                    case INVENTOR_LISTING_PREFIX . 'title':
                        return get_the_title( $_GET['id'] );
                    case INVENTOR_LISTING_PREFIX . 'description':
                        return $post->post_content;
                    case INVENTOR_LISTING_PREFIX . 'featured_image':
                        return wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
                }

                return get_post_meta( $post_id, $field_id, true );
            }
        }

        return null;
    }

    /**
     * General metabox uses native WordPress fields.
     * It is necessary to update CMB2 fields every time listing is updated in WP admin.
     *
     * @access public
     * @param $new_status
     * @param $old_status
     * @param $post
     * @return void
     */
    public static function update_general_metabox_fields( $new_status, $old_status, $post ) {
        if ( ! is_admin() ) {
            return;
        }

        $post_type = get_post_type( $post );
        $listing_post_types = Inventor_Post_Types::get_listing_post_types();

        if ( ! in_array( $post_type, $listing_post_types ) ) {
            return;
        }

        update_post_meta( $post->ID, INVENTOR_LISTING_PREFIX . 'title', get_the_title( $post->ID ) );
        update_post_meta( $post->ID, INVENTOR_LISTING_PREFIX . 'description', $post->post_content );
        update_post_meta( $post->ID, INVENTOR_LISTING_PREFIX . 'featured_image', wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) );
    }

    /**
     * Process remove listing form
     *
     * @access public
     * @return void
     */
    public static function process_remove_form() {
        if ( ! isset( $_POST['remove_listing_form'] ) || empty( $_POST['listing_id'] ) ) {
            return;
        }

        if ( wp_delete_post( $_POST['listing_id'] ) ) {
            Inventor_Utilities::show_message( 'success', __( 'Item has been successfully removed.', 'inventor-submission' ) );
        } else {
            Inventor_Utilities::show_message( 'danger', __( 'An error occurred when removing an item.', 'inventor-submission' ) );
        }
    }

    /**
     * Returns default value for metabox field
     *
     * @access public
     * @param mixed $value
     * @param string $metabox_id
     * @param string $field_id
     * @param string $post_type
     * @return mixed
     */
    public static function metabox_default_field_value( $value, $metabox_id, $field_id, $post_type=null ) {
        return is_admin() ? $value : self::get_submission_field_value( $metabox_id, $field_id );
    }

    /**
     * Adds new payment types
     *
     * @access public
     * @param array $payment_types
     * @return array
     */
    public static function add_payment_types( $payment_types ) {
        $payment_types[] = 'featured_listing';
        $payment_types[] = 'publish_listing';
        return $payment_types;
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
        if ( ! in_array( $payment_type, array( 'featured_listing', 'publish_listing' ) ) ) {
            return $payment_data;
        }

        $post = get_post( $object_id );
        $payment_data['price'] = self::payment_price_value( null, $payment_type, $object_id );

        if ( $payment_type == 'featured_listing' ) {
            $payment_data['action_title'] = __( 'Featured listing', 'inventor-submission' );
            $payment_data['description'] = sprintf( __( 'Make listing %s featured', 'inventor-submission' ), $post->post_title );
        }

        if ( $payment_type == 'publish_listing' ) {
            $payment_data['action_title'] = __( 'Publish listing', 'inventor-submission' );
            $payment_data['description'] = sprintf( __( 'Publish %s', 'inventor-submission' ), $post->post_title );
        }

        return $payment_data;
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
        if ( 'featured_listing' == $payment_type ) {
            $price = get_theme_mod( 'inventor_submission_featured_price', null );
        } elseif ( 'publish_listing' == $payment_type ) {
            $price = get_theme_mod( 'inventor_submission_publish_price', null );
        }

        return $price;
    }

    /**
     * Renders data before payment form
     *
     * @access public
     * @param string $payment_type
     * @param int $object_id
     * @param string $payment_gateway
     * @return void
     */
    public static function payment_form_before( $payment_type, $object_id, $payment_gateway ) {
        if ( ! in_array( $payment_type, array( 'publish_listing', 'featured_listing' ) ) ) {
            return;
        }

        $attrs = array(
            'payment_type'      => $payment_type,
            'object_id'         => $object_id,
            'payment_gateway'   => $payment_gateway,
        );

        echo Inventor_Template_Loader::load( 'submission/payment-form-before', $attrs, INVENTOR_SUBMISSION_DIR );
    }

    /**
     * Handles payment and decrements listing quantity
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
        if ( ! $success || $gateway == 'wire-transfer' ) {
            return;
        }

        if ( $payment_type == 'featured_listing' ) {
            // update featured flag
            $featured_key = INVENTOR_LISTING_PREFIX . 'featured';
            update_post_meta( $object_id, $featured_key, 'on' );

            Inventor_Utilities::show_message( 'success', __( 'Listing successfully featured.', 'inventor-submission' ) );

        } elseif ( $payment_type == 'publish_listing' ) {
            // publish listing
            $review_before = get_theme_mod( 'inventor_submission_review_before', false );

            if ( $review_before ) {
                // pending post
                wp_update_post( array(
                    'ID'            =>  $object_id,
                    'post_status'   =>  'pending'
                ) );
                Inventor_Utilities::show_message( 'success', __( 'Listing will be published after review.', 'inventor-submission' ) );
            } else {
                // publish post
                wp_publish_post( $object_id );
                Inventor_Utilities::show_message( 'success', __( 'Listing has been published.', 'invnetor-submission' ) );
            }
        }
    }
}

Inventor_Submission_Logic::init();
