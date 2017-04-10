<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Properties_Logic
 *
 * @class Inventor_Properties_Logic
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Properties_Logic {
    /**
     * Initialize property system
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'inventor_after_listing_detail_overview', array( __CLASS__, 'special_sections' ) );
        add_filter( 'inventor_attribute_value', array( __CLASS__, 'attribute_value' ), 10, 2 );
    }

    /**
     * Renders special sections for property type
     *
     * @access public
     * @return void
     */
    public static function special_sections() {
        $price_comparison = self::get_price_comparison();
        if ( count( $price_comparison ) ) {
            echo Inventor_Template_Loader::load( 'price-comparison', $price_comparison, INVENTOR_PROPERTIES_DIR );
        }
        echo Inventor_Template_Loader::load( 'amenities', array(), INVENTOR_PROPERTIES_DIR );
        echo Inventor_Template_Loader::load( 'floor-plans', array(), INVENTOR_PROPERTIES_DIR );
        echo Inventor_Template_Loader::load( 'valuation', array(), INVENTOR_PROPERTIES_DIR );
        echo Inventor_Template_Loader::load( 'public-facilities', array(), INVENTOR_PROPERTIES_DIR );
    }

    /**
     * Modifies home and lot area attributes
     *
     * @access public
     * @param string $value
     * @param array $field
     * @return string
     */
    public static function attribute_value( $value, $field ) {
        // Home and lot area
        $field_ids = array(
            INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'home_area',
            INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'lot_area'
        );

        if ( in_array( $field['id'], $field_ids ) ) {
            $area_unit = get_theme_mod( 'inventor_measurement_area_unit', 'sqft' );
            $value = sprintf( '%s %s', $value, $area_unit );
        }

        return $value;
    }

    /**
     * Returns average area price per measurement unit
     *
     * @access public
     * @param string $size | lot_area / home_area
     * @param string $contract | RENT / SALE
     * @return float
     */
    public static function get_average_area_unit_price( $size, $contract ) {
        global $wpdb;

        $sql = "
            SELECT ROUND(sum_price / sum_area, 2) as average_area_price FROM
              ( SELECT SUM(pm_price.meta_value) as sum_price
              FROM $wpdb->postmeta pm_price, $wpdb->postmeta pm_area, $wpdb->postmeta pm_contract, $wpdb->posts
              WHERE pm_price.meta_key='%s'
                AND $wpdb->posts.post_type='property'
                AND pm_price.post_id=$wpdb->posts.id
                AND pm_price.post_id=pm_area.post_id
                AND pm_area.post_id=pm_contract.post_id
                AND pm_area.meta_key='%s'
                AND pm_contract.meta_key='listing_property_contract_type'
                AND pm_contract.meta_value='%s'
                %s
                ) as sum_price_query,
              ( SELECT SUM(pm_area.meta_value) as sum_area
              FROM $wpdb->postmeta pm_area, $wpdb->postmeta pm_contract, $wpdb->posts
              WHERE pm_area.meta_key='%s'
                AND $wpdb->posts.post_type='property'
                AND pm_area.post_id=$wpdb->posts.id
                AND pm_area.post_id=pm_contract.post_id
                AND pm_contract.meta_key='listing_property_contract_type'
                AND pm_contract.meta_value='%s'
                %s
                ) as sum_area_query;
                ";

        $exclude_query = "";

        if( $size == 'home_area' ) {
            $exclude_query = "
                    AND NOT EXISTS (
                        SELECT * FROM $wpdb->postmeta
                        WHERE $wpdb->postmeta.meta_key = 'listing_property_lot_area'
                        AND $wpdb->postmeta.post_id=$wpdb->posts.ID
                      )
                ";
        }

        $price_key = INVENTOR_LISTING_PREFIX . "price";
        $size_key = INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . $size;

        $sql = sprintf( $sql,
            // sum price query
            $price_key,
            $size_key,
            $contract,
            $exclude_query,

            // sum area query
            $size_key,
            $contract,
            $exclude_query
        );

        $average_area_unit_price = $wpdb->get_var($sql);

        return $average_area_unit_price;
    }

    /**
     * Returns price comparison values
     *
     * @access public
     * @param $post_id
     * @return array
     */
    public static function get_price_comparison( $post_id = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $price_comparison = array();

        $price = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . 'price', true );
        $contract_type = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'contract_type', true );

        if ( ! empty( $price ) && $price != 0 && ! empty( $contract_type ) ) {
            $lot_area = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'lot_area', true );
            $home_area = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'home_area', true );

            $area = empty( $lot_area ) ? $home_area : $lot_area;

            if ( ! empty( $area ) ) {
                $area_size = empty( $lot_area ) ? 'home_area' : 'lot_area';

                // Area unit price
                $area_unit_price = round( $price / $area, 2 );
                $price_formatted = Inventor_Price::format_price( $area_unit_price );
                $price_comparison[ INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'area_unit_price' ] = $price_formatted;

                // Average area unit price
                $average_area_unit_price = self::get_average_area_unit_price( $area_size, $contract_type );
                $price_formatted = Inventor_Price::format_price( $average_area_unit_price );
                $price_comparison[ INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'average_area_unit_price' ] = $price_formatted;

                // Property price
                $difference_area_unit_price = $area_unit_price - $average_area_unit_price;
                $sign = $difference_area_unit_price > 0 ? '+' : '';
                $price_formatted = Inventor_Price::format_price( $difference_area_unit_price );
                $price_comparison[ INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'average_area_unit_price_difference' ] = sprintf( '%s%s', $sign, $price_formatted );
            }
        }

        return $price_comparison;
    }
}

Inventor_Properties_Logic::init();