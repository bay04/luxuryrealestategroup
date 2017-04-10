<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Invoices_Logic
 *
 * @class Inventor_Invoices_Logic
 * @package Inventor/Classes
 * @property $allowed_post_types
 * @author Pragmatic Mates
 */
class Inventor_Invoices_Logic {
    /**
     * Initialize invoice logic
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'pre_get_posts', array( __CLASS__, 'restrict_user_on_archive' ) );
        add_action( 'wp', array( __CLASS__, 'restrict_user_on_detail' ) );
        add_action( 'inventor_payment_processed', array( __CLASS__, 'catch_payment' ), 10, 9 );

        add_filter( 'inventor_invoices_types', array( __CLASS__, 'default_types' ), 10, 1 );
        add_filter( 'inventor_payment_proceed_gateway', array( __CLASS__, 'proceed_payment_gateway' ), 10, 2 );
        add_filter( "single_template", array( __CLASS__, 'invoice_template' ) );
    }

    /**
     * Returns default invoice types
     *
     * @param $types array
     * @return array
     */
    public static function default_types( $types ) {
        $types['INVOICE'] = __( 'Invoice', 'inventor-invoices' );
        $types['ADVANCE'] = __( 'Advance invoice', 'inventor-invoices' );
        $types['PROFORMA'] = __( 'Proforma invoice', 'inventor-invoices' );
        $types['VAT_CREDIT_NOTE'] = __( 'VAT credit note', 'inventor-invoices' );
        return $types;
    }

    /**
     * Returns type name by its id
     *
     * @param $type string
     * @return string
     */
    public static function get_type_display( $type ) {
        $types = apply_filters( 'inventor_invoices_types', array() );
        return array_key_exists( $type, $types ) ? $types[ $type ] : $type;
    }

    /**
     * Determines if payment gateway should have proceed submit button
     *
     * @param bool $proceed
     * @param string $gateway
     * @return bool
     */
    public static function proceed_payment_gateway( $proceed, $gateway ) {
        if ( $gateway == 'wire-transfer' ) {
            return true;
        }
        return $proceed;
    }

    /**
     * Sets all user invoices into query
     *
     * @access public
     * @return void
     */
    public static function loop_my_invoices() {
        $paged = ( get_query_var('paged')) ? get_query_var('paged') : 1;

        query_posts( array(
            'post_type'     => 'invoice',
            'paged'         => $paged,
            'post_status'   => 'publish',
            'author'        => get_current_user_id(),
        ) );
    }

    /**
     * List only user invoices to avoid unauthorized access
     *
     * @access public
     * @param $query
     * @return WP_Query|null
     */
    public static function restrict_user_on_archive( $query ) {
        if ( ( get_query_var( 'post_type' ) == 'invoice' || is_post_type_archive( 'invoice' ) ) && $query->is_main_query() && ! is_admin() ) {
            $query->set( 'author', get_current_user_id() );
        }
    }

    /**
     * Forbidden access for unauthorized users
     *
     * @access public
     * @return void
     */
    public static function restrict_user_on_detail() {
        if( is_singular( 'invoice' ) && ! is_admin() ) {
            $invoice = get_post();
            $invoice_customer = $invoice->post_author;
            $current_user = get_current_user_id();

            if ( $current_user != $invoice_customer ) {
                Inventor_Utilities::show_message( 'danger', __( 'It is not your invoice.', 'inventor-invoices' ) );
                echo wp_redirect( home_url() );
                exit();
            }
        }
    }

    /**
     * Renders invoice template
     *
     * @access public
     * @return string
     */
    public static function invoice_template( $single ) {
        global $post;

        /* Checks for single template by post type */
        if ( $post->post_type == "invoice" ) {
            return Inventor_Template_Loader::locate( 'single-invoice', $plugin_dir = INVENTOR_INVOICES_DIR );
        }

        return $single;
    }

    /**
     * Calculates invoices item tax
     *
     * @param $item array
     * @return float
     */
    public static function get_invoice_item_tax( $item ) {
        // unit price
        $unit_price_key = INVENTOR_INVOICE_PREFIX . 'item_unit_price';
        $unit_price = ( ! empty( $item[$unit_price_key] ) ) ? (float) $item[$unit_price_key] : 0;

        // quantity
        $quantity_key = INVENTOR_INVOICE_PREFIX . 'item_quantity';
        $quantity = ( ! empty( $item[ $quantity_key ] ) ) ? (float) $item[ $quantity_key ] : 0;

        // tax rate
        $tax_rate_key = INVENTOR_INVOICE_PREFIX . 'item_tax_rate';
        $tax_rate = ( ! empty( $item[ $tax_rate_key ] ) ) ? (float) $item[ $tax_rate_key ] : 0;

        // item tax
        $tax_rate_ratio = (float) $tax_rate / 100;
        $tax = $unit_price * $quantity * $tax_rate_ratio;

        return round( $tax, 2);
    }

    /**
     * Calculates invoices item subtotal
     *
     * @param $item array
     * @return float
     */
    public static function get_invoice_item_subtotal( $item ) {
        // unit price
        $unit_price_key = INVENTOR_INVOICE_PREFIX . 'item_unit_price';
        $unit_price = ( ! empty( $item[$unit_price_key] ) ) ? (float) $item[$unit_price_key] : 0;

        // quantity
        $quantity_key = INVENTOR_INVOICE_PREFIX . 'item_quantity';
        $quantity = ( ! empty( $item[ $quantity_key ] ) ) ? (float) $item[ $quantity_key ] : 0;

        // tax rate
        $tax_rate_key = INVENTOR_INVOICE_PREFIX . 'item_tax_rate';
        $tax_rate = ( ! empty( $item[ $tax_rate_key ] ) ) ? (float) $item[ $tax_rate_key ] : 0;

        // item price
        $rate = (float) (100 + $tax_rate) / 100;
        $subtotal = $unit_price * $quantity * $rate;

        return round( $subtotal, 2);
    }

    /**
     * Calculates invoice total price
     *
     * @param $invoice_id int
     * @return float
     */
    public static function get_invoice_total( $invoice_id ) {
        $items = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'item', true );

        $total = 0;

        if ( ! is_array( $items ) ) {
            return $total;
        }

        foreach( $items as $item ) {
            $item_price = self::get_invoice_item_subtotal( $item );
            $total += $item_price;
        }

        return round( $total, 2 );
    }

    /**
     * Returns invoice item list
     *
     * @param $invoice_id int
     * @return array
     */
    public static function get_invoice_item_list( $invoice_id ) {
        $items = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'item', true );

        if ( ! is_array( $items ) ) {
            return array();
        }

        $result = array();

        foreach ( $items as $item ) {
            $item_title_key = INVENTOR_INVOICE_PREFIX . 'item_title';
            $item_title = ( ! empty( $item[$item_title_key] ) ) ? $item[$item_title_key] : null;

            if ( ! empty( $item_title ) ) {
                $result[] = $item_title;
            }
        }

        return $result;
    }

    /**
     * Returns all invoices
     *
     * @return array
     */
    public static function get_all_invoices() {
        $query = new WP_Query( array(
            'post_type'         => 'invoice',
            'posts_per_page'    => -1,
            'post_status'       => 'any',
            'orderby'           => 'date',
            'order'             => 'DESC'
        ) );

        return $query->posts;
    }

    /**
     * Checks if invoice number already exist
     *
     * @return bool
     */
    public static function invoice_number_exists( $invoice_number ) {
        global $wpdb;
        $title_ids = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_title = '%s'", $invoice_number ) );
        return count( $title_ids ) > 0;
    }

    /**
     * Returns the very next number for new invoice
     *
     * @return string
     */
    public static function get_next_invoice_number() {
        $next_number = 1;

        $invoices = self::get_all_invoices();

        if( count( $invoices ) > 0 ) {
            $last_invoice = $invoices[0];
            $last_invoice_number = get_the_title( $last_invoice );

            if ( is_numeric( $last_invoice_number ) ) {
                $next_number = (int) $last_invoice_number + 1;
            }
        }

        while ( self::invoice_number_exists( $next_number ) ) {
            $next_number += 1;
        }

        return apply_filters( 'inventor_invoices_next_invoice_number', $next_number );
    }

    /**
     * Creates invoice for user payment
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
        if ( ! $success ) {
            return;
        }

        $invoice_number = self::get_next_invoice_number();

        $invoice_id = wp_insert_post( array(
            'post_type'     => 'invoice',
            'post_title'    => $invoice_number,
            'post_status'   => 'publish',
            'post_author'   => $user_id,
        ) );

        // invoice type
        $type = 'INVOICE';

        // reference
        $reference = empty( $payment_id ) ? $invoice_number : $payment_id;

        // payment term
        $payment_term = get_theme_mod( 'inventor_invoices_payment_term', 15 );

        // supplier
        $supplier_name = get_theme_mod( 'inventor_invoices_billing_name', '' );
        $supplier_registration_number = get_theme_mod( 'inventor_invoices_billing_registration_number', '' );
        $supplier_vat_number = get_theme_mod( 'inventor_invoices_billing_vat_number', '' );
        $supplier_details = get_theme_mod( 'inventor_invoices_billing_details', '' );

        // customer
        $customer_name = ! empty( $billing_details[ 'billing_name' ] ) ? $billing_details[ 'billing_name' ] : null;
        $customer_registration_number = ! empty( $billing_details[ 'billing_registration_number' ] ) ? $billing_details[ 'billing_registration_number' ] : null;
        $customer_vat_number = ! empty( $billing_details[ 'billing_vat_number' ] ) ? $billing_details[ 'billing_vat_number' ] : null;

        $customer_address = array();
        foreach( array( 'billing_street_and_number', 'billing_city', 'billing_postal_code', 'billing_county', 'billing_country' ) as $address_key ) {
            $value = ! empty( $billing_details[ $address_key ] ) ? $billing_details[ $address_key ] : null;

            if ( ! empty( $value ) ) {
                $customer_address[] = $value;
            }
        }
        $customer_details = implode( "\r\n", $customer_address );

        // item
        $tax_rate = get_theme_mod( 'inventor_invoices_tax_rate', 0 );

        // tax rate filter
        $tax_rate = apply_filters( 'inventor_invoices_tax_rate', $tax_rate, $supplier_vat_number, $customer_vat_number );

        $item_tax_rate = (float) $tax_rate;
        $rate = (float) (100 + $item_tax_rate) / 100;
        $item_unit_price = round($price / $rate, 2);

        $item = array(
            INVENTOR_INVOICE_PREFIX . 'item_title' => get_the_title( $object_id ),
            INVENTOR_INVOICE_PREFIX . 'item_quantity' => 1,
            INVENTOR_INVOICE_PREFIX . 'item_unit_price' => strval( $item_unit_price ),
            INVENTOR_INVOICE_PREFIX . 'item_tax_rate' => strval( $item_tax_rate ),
        );
        $items = array( $item );

        // details
        $details = '';

        // Wire transfer gateway handle
        if ( $gateway == 'wire-transfer' ) {
            $type = 'ADVANCE';

            $bank_details = array();
            foreach ( array( 'account_number', 'swift', 'full_name', 'street', 'postcode', 'city', 'country' ) as $details_key ) {
                $customize_key = 'inventor_wire_transfer_' . $details_key;
                $value = get_theme_mod( $customize_key, '' );
                $label = Inventor_Customizations_Wire_Transfer::get_control_label( $customize_key );

                if ( ! empty( $value ) ) {
                    $bank_details[] = $label . ': ' . $value;
                }
            }
            if ( count( $bank_details ) > 0 ) {
                array_unshift($bank_details, __( 'Bank details', 'inventor-invoices' ) . ':');
            }
            $details = implode( "\r\n", $bank_details );
        }

        # update invoice
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'type', $type );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'currency_code', $currency_code );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'reference', $reference );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'payment_term', $payment_term );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'details', $details );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'supplier_name', $supplier_name );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'supplier_registration_number', $supplier_registration_number );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'supplier_vat_number', $supplier_vat_number );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'supplier_details', $supplier_details );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'customer_name', $customer_name );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'customer_registration_number', $customer_registration_number );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'customer_vat_number', $customer_vat_number );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'customer_details', $customer_details );
        update_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'item', $items );

        if ( $gateway == 'wire-transfer' ) {
            Inventor_Utilities::show_message( 'success', __( 'Advance invoice was created.', 'inventor-invoices' ) );
        }
    }
}

Inventor_Invoices_Logic::init();