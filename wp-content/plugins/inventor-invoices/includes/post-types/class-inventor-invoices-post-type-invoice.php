<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Invoices_Post_Type_Invoice
 *
 * @class Inventor_Invoices_Post_Type_Invoice
 * @package Inventor_Invoices/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Invoices_Post_Type_Invoice {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_filter( 'cmb2_init', array( __CLASS__, 'fields' ) );
        add_filter( 'manage_edit-invoice_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_invoice_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Invoices', 'inventor-invoices' ),
            'singular_name'         => __( 'Invoice', 'inventor-invoices' ),
            'add_new'               => __( 'Add New Invoice', 'inventor-invoices' ),
            'add_new_item'          => __( 'Add New Invoice', 'inventor-invoices' ),
            'edit_item'             => __( 'Edit Invoice', 'inventor-invoices' ),
            'new_item'              => __( 'New Invoice', 'inventor-invoices' ),
            'all_items'             => __( 'Invoices', 'inventor-invoices' ),
            'view_item'             => __( 'View Invoice', 'inventor-invoices' ),
            'search_items'          => __( 'Search Invoice', 'inventor-invoices' ),
            'not_found'             => __( 'No Invoices found', 'inventor-invoices' ),
            'not_found_in_trash'    => __( 'No Invoices found in Trash', 'inventor-invoices' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Invoices', 'inventor-invoices' ),
        );

        register_post_type( 'invoice',
            array(
                'labels'                => $labels,
                'supports'              => array( 'title', 'author' ),
                'public'                => true,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'show_in_nav_menus'     => false,
                'show_ui'               => true,
                'show_in_menu'          => class_exists( 'Inventor_Admin_Menu') ? 'inventor' : true,
            )
        );
    }

    /**
     * Custom admin columns
     *
     * @access public
     * @return array
     */
    public static function custom_columns() {
        $fields = array(
            'cb' 				=> '<input type="checkbox" />',
            'title' 		    => __( 'Number', 'inventor-invoices' ),
            'type' 		        => __( 'Type', 'inventor-invoices' ),
            'customer' 		    => __( 'Customer', 'inventor-invoices' ),
            'total' 			=> __( 'Total', 'inventor-invoices' ),
            'currency'     	    => __( 'Currency', 'inventor-invoices' ),
            'issue_date'        => __( 'Issue date', 'inventor-invoices' ),
        );
        return $fields;
    }

    /**
     * Custom admin columns implementation
     *
     * @access public
     * @param string $column
     * @return array
     */
    public static function custom_columns_manage( $column ) {
        switch ( $column ) {
            case 'type':
                $type = get_post_meta( get_the_ID(), INVENTOR_INVOICE_PREFIX . 'type', true );
                $types = apply_filters( 'inventor_invoices_types', array() );
                echo ( empty ( $types[$type] ) ) ? $type : $types[$type];
                break;
            case 'customer':
                $customer_name = get_post_meta( get_the_ID(), INVENTOR_INVOICE_PREFIX . 'customer_name', true );
                echo $customer_name;
                break;
            case 'total':
                $total = Inventor_Invoices_Logic::get_invoice_total( get_the_ID() );
                echo $total;
                break;
            case 'currency':
                $currency_code = get_post_meta( get_the_ID(), INVENTOR_INVOICE_PREFIX . 'currency_code', true );
                echo $currency_code;
                break;
            case 'issue_date':
                echo get_the_date( 'Y-m-d' );
                break;
        }
    }

    /**
     * Defines custom fields
     *
     * @access public
     * @return array
     */
    public static function fields() {
        // General
        $general = new_cmb2_box( array(
            'id'            => INVENTOR_INVOICE_PREFIX  . 'general',
            'title'         => __( 'General information', 'inventor-invoices' ),
            'object_types'  => array( 'invoice' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $general->add_field( array(
            'name'          => __( 'Type', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'type',
            'type'          => 'radio',
            'options'       => apply_filters( 'inventor_invoices_types', array() )
        ) );

        // Payment information
        $payment = new_cmb2_box( array(
            'id'            => INVENTOR_INVOICE_PREFIX  . 'payment',
            'title'         => __( 'Payment information', 'inventor-invoices' ),
            'object_types'  => array( 'invoice' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $payment->add_field( array(
            'name'          => __( 'Currency code', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'currency_code',
            'type'          => 'text_small',
        ) );

        $payment->add_field( array(
            'name'          => __( 'Reference', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'reference',
            'type'          => 'text',
        ) );

        $payment->add_field( array(
            'name'          => __( 'Payment term', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'payment_term',
            'type'          => 'text_small',
            'description'   => __( 'days', 'inventor-invoices' ),
            'attributes'    => array(
                'type'          => 'number',
                'pattern'       => '\d*',
            ),
        ) );

        $payment->add_field( array(
            'name'          => __( 'Details / Instructions', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'details',
            'type'          => 'textarea',
        ) );

        // Supplier
        $supplier = new_cmb2_box( array(
            'id'            => INVENTOR_INVOICE_PREFIX  . 'supplier',
            'title'         => __( 'Supplier', 'inventor-invoices' ),
            'object_types'  => array( 'invoice' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $supplier->add_field( array(
            'name'          => __( 'Name', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'supplier_name',
            'type'          => 'text',
        ) );

        $supplier->add_field( array(
            'name'          => __( 'Registration No.', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'supplier_registration_number',
            'type'          => 'text_medium',
        ) );

        $supplier->add_field( array(
            'name'          => __( 'VAT No.', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'supplier_vat_number',
            'type'          => 'text_medium',
        ) );

        $supplier->add_field( array(
            'name'          => __( 'Details', 'inventor-invoices' ),
            'description'   => __( 'for example address or any additional information', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'supplier_details',
            'type'          => 'textarea',
        ) );

        // Customer
        $supplier = new_cmb2_box( array(
            'id'            => INVENTOR_INVOICE_PREFIX  . 'customer',
            'title'         => __( 'Customer', 'inventor-invoices' ),
            'object_types'  => array( 'invoice' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $supplier->add_field( array(
            'name'          => __( 'Name', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'customer_name',
            'type'          => 'text',
        ) );

        $supplier->add_field( array(
            'name'          => __( 'Registration No.', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'customer_registration_number',
            'type'          => 'text_medium',
        ) );

        $supplier->add_field( array(
            'name'          => __( 'VAT No.', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'customer_vat_number',
            'type'          => 'text_medium',
        ) );

        $supplier->add_field( array(
            'name'          => __( 'Details', 'inventor-invoices' ),
            'description'   => __( 'for example address or any additional information', 'inventor-invoices' ),
            'id'            => INVENTOR_INVOICE_PREFIX  . 'customer_details',
            'type'          => 'textarea',
        ) );

        // Invoice items
        $cmb = new_cmb2_box( array(
            'id'            => INVENTOR_INVOICE_PREFIX . 'items',
            'title'         => __( 'Items', 'inventor-invoices' ),
            'object_types'  => array( 'invoice' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $group = $cmb->add_field( array(
            'id'          	=> INVENTOR_INVOICE_PREFIX . 'item',
            'type'        	=> 'group',
            'post_type'   	=> 'invoice',
            'repeatable'  	=> true,
            'options'     	=> array(
                'group_title'   => __( 'Item', 'inventor-invoices' ),
                'add_button'    => __( 'Add Another Item', 'inventor-invoices' ),
                'remove_button' => __( 'Remove Item', 'inventor-invoices' ),
            ),
        ) );

        $cmb->add_group_field( $group, array(
            'id'            => INVENTOR_INVOICE_PREFIX  . 'item_title',
            'name'          => __( 'Title', 'inventor-invoices' ),
            'type'          => 'text',
        ) );

        $cmb->add_group_field( $group, array(
            'id'            => INVENTOR_INVOICE_PREFIX  . 'item_quantity',
            'name'          => __( 'Quantity', 'inventor-invoices' ),
            'type'          => 'text_small',
            'attributes'    => array(
                'pattern'       => "\\d*\\.?\\d+",
            ),
        ) );

        $cmb->add_group_field( $group, array(
            'id'            => INVENTOR_INVOICE_PREFIX  . 'item_unit_price',
            'name'          => __( 'Unit price', 'inventor-invoices' ),
            'type'          => 'text_small',
            'attributes'    => array(
                'pattern'       => "\\d*\\.?\\d+",
            ),
        ) );

        $cmb->add_group_field( $group, array(
            'id'            => INVENTOR_INVOICE_PREFIX  . 'item_tax_rate',
            'name'          => __( 'Tax rate', 'inventor-invoices' ),
            'description'   => '%',
            'type'          => 'text_small',
            'attributes'    => array(
                'pattern'       => "\\d*\\.?\\d+",
            ),
        ) );
    }
}

Inventor_Invoices_Post_Type_Invoice::init();