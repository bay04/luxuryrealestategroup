<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Shop_Logic
 *
 * @class Inventor_Shop_Logic
 * @package Inventor/Classes
 * @property $allowed_post_types
 * @author Pragmatic Mates
 */
class Inventor_Shop_Logic
{
    /**
     * Initialize property system
     *
     * @access public
     * @return void
     */
    public static function init()
    {
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );
        add_action( 'inventor_after_listing_price', array( __CLASS__, 'render_listing_buy_button' ), 10, 1 );
        add_action( 'inventor_payment_form_before', array( __CLASS__, 'payment_form_before' ), 10, 3 );
        add_action( 'inventor_payment_processed', array( __CLASS__, 'catch_payment' ), 10, 9 );

        add_filter( 'inventor_payment_types', array( __CLASS__, 'add_payment_type' ) );
        add_filter( 'inventor_prepare_payment', array( __CLASS__, 'prepare_payment' ), 10, 3 );
        add_filter( 'inventor_payment_form_price_value', array( __CLASS__, 'payment_price_value' ), 10, 3 );
    }

    /**
     * Adds package payment type
     *
     * @access public
     * @param array $payment_types
     * @return array
     */
    public static function add_payment_type( $payment_types ) {
        $payment_types[] = 'listing';
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
    public static function payment_price_value($price, $payment_type, $object_id ) {
        if ( 'listing' == $payment_type && ! empty( $object_id ) ) {
            return Inventor_Price::get_listing_price($object_id);
        }

        return $price;
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
        if ( $payment_type == 'listing' ) {
            $post = get_post( $object_id );
            $payment_data['price'] = Inventor_Price::get_listing_price( $object_id );
            $payment_data['action_title'] = __( 'Purchase listing', 'inventor-shop' );
            $payment_data['description'] = esc_attr( $post->post_title );
        }
        return $payment_data;
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
        if ( $success && $payment_type == 'listing' ) {
            // update quantity value
            $quantity_key = INVENTOR_SHOP_PREFIX . 'quantity';
            $old_quantity = get_post_meta( $object_id, $quantity_key, true );
            $new_quantity = $old_quantity == 0 ? 0 : $old_quantity - 1;
            update_post_meta( $object_id, $quantity_key, $new_quantity, $old_quantity );

            Inventor_Utilities::show_message( 'success', __( 'Listing successfully purchased.', 'inventor-shop' ) );
        }
    }

    /**
     * List of allowed post types for shop
     *
     * @access public
     * @return array
     */
    public static function get_allowed_post_types() {
        return apply_filters( 'inventor_shop_allowed_listing_post_types', array() );
    }

    /**
     * Adds shop metabox to allowed listing post types
     *
     * @access public
     * @return array
     */
    public static function fields() {
        if ( ! is_admin() ) {
            return;
        }

        $shop = new_cmb2_box( array(
            'id'            => INVENTOR_LISTING_PREFIX . INVENTOR_SHOP_PREFIX . 'config',
            'title'         => __( 'Shop configuration', 'inventor-shop' ),
            'object_types'  => self::get_allowed_post_types(),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $shop->add_field( array(
            'name'              => __( 'Enabled', 'inventor-shop' ),
            'description'       => __( 'Allow/disallow listing purchasing (also price needs to be set).', 'inventor-shop' ),
            'id'                => INVENTOR_SHOP_PREFIX . 'enabled',
            'type'              => 'checkbox',
        ) );

        $shop->add_field( array(
            'name'              => __( 'Quantity', 'inventor-shop' ),
            'description'       => __( 'In stock', 'inventor-shop' ),
            'id'                => INVENTOR_SHOP_PREFIX . 'quantity',
            'type'              => 'text_small',
            'attributes'        => array(
                'type'              => 'number',
                'min'               => '0',
                'pattern'           => '\d*',
            )
        ) );
    }

    /**
     * Renders buy button
     *
     * @access public
     * @param int $listing_id
     * @return void
     */
    public static function render_listing_buy_button( $listing_id ) {
        $post_type = get_post_type( $listing_id );

        if ( ! in_array( $post_type, self::get_allowed_post_types() ) ) {
            return;
        }

        $is_enabled = get_post_meta( $listing_id, INVENTOR_SHOP_PREFIX . 'enabled', true );

        if ( ! $is_enabled ) {
            return;
        }

        $quantity = get_post_meta( $listing_id, INVENTOR_SHOP_PREFIX . 'quantity', true );
        $is_available = $quantity > 0;
        $payment_page_id = get_theme_mod( 'inventor_general_payment_page', false );

        $attrs = array(
            'is_enabled' => $is_enabled,
            'listing_id' => $listing_id,
            'payment_page_id' => $payment_page_id,
            'is_available' => $is_available
        );

        echo Inventor_Template_Loader::load('buy-button', $attrs, $plugin_dir = INVENTOR_SHOP_DIR );
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
        $attrs = array(
            'payment_type'      => $payment_type,
            'object_id'         => $object_id,
            'payment_gateway'   => $payment_gateway,
        );

        echo Inventor_Template_Loader::load( 'payment-form-before', $attrs, INVENTOR_SHOP_DIR );
    }
}

Inventor_Shop_Logic::init();