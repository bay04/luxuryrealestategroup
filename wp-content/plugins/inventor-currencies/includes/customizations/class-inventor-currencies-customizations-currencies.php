<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Customizations_Currencies
 *
 * @class Inventor_Currencies_Customizations_Currencies
 * @package Inventor_Currencies/Classes/Customizations
 * @author Pragmatic Mates
 */
class Inventor_Currencies_Customizations_Currencies {
    /**
     * Initialize customization type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'customize_register', array( __CLASS__, 'customizations' ) );
    }

    /**
     * Customizations
     *
     * @access public
     * @param object $wp_customize
     * @return void
     */
    public static function customizations( $wp_customize ) {
        $wp_customize->add_section( 'inventor_currencies', array(
            'title'     => __( 'Inventor Currencies', 'inventor' ),
            'priority'  => 1,
        ) );

        // Another currencies
        $wp_customize->add_setting( 'inventor_currencies_other', array(
            // 'default'           => 0,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_currencies_other', array(
            'type'        => 'number',
            'label'       => __( 'Number of additional currencies', 'inventor-currencies' ),
            'section'     => 'inventor_currencies',
            'settings'    => 'inventor_currencies_other',
            'description' => __( 'Input positive integer or 0 for no other currencies.', 'inventor-currencies' ),
        ) );

        $other_currencies = get_theme_mod( 'inventor_currencies_other', 0 );

        if ( ! empty( $other_currencies ) && $other_currencies > 0 ) {
            self::currency_settings( $wp_customize, $other_currencies );
        }

        // Another currencies
        $wp_customize->add_setting( 'inventor_currencies_currencylayer_api_key', array(
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'inventor_currencies_currencylayer_api_key', array(
            'label'         => __( 'currencylayer.com API key', 'inventor-currencies' ),
            'section'       => 'inventor_currencies',
            'settings'      => 'inventor_currencies_currencylayer_api_key',
            'description'   => __( 'Enter if you want to automatically update rates of currencies.', 'inventor-currencies' ),
        ) );
    }

    /**
     * Creates currency options
     *
     * @access public
     * @param object $wp_customize
     * @param int $count
     * @return void
     */
    public static function currency_settings( $wp_customize, $count ) {
        for ( $i = 1; $i <= $count; $i++ ) {
            $wp_customize->add_section( "inventor_currencies[$i]", array(
                'title'     => 'Inventor' . ' ' . ( $i + 1 ). '. ' . __( 'Currency', 'inventor-currencies' ),
                'priority'  => 1,
            ) );

            // Currency symbol
            $wp_customize->add_setting( "inventor_currencies[$i][symbol]", array(
                'default'           => '',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( "inventor_currencies[$i][symbol]", array(
                'label'     => __( 'Currency Symbol', 'inventor-currencies' ),
                'section'   => "inventor_currencies[$i]",
                'settings'  => "inventor_currencies[$i][symbol]",
            ) );

            // Currency code
            $wp_customize->add_setting( "inventor_currencies[$i][code]", array(
                'default'           => '',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( "inventor_currencies[$i][code]", array(
                'label'     => __( 'Currency Code', 'inventor-currencies' ),
                'section'   => "inventor_currencies[$i]",
                'settings'  => "inventor_currencies[$i][code]",
            ) );

            // Show after
            $wp_customize->add_setting( "inventor_currencies[$i][show_after]", array(
                'default'           => false,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( "inventor_currencies[$i][show_after]", array(
                'type'      => 'checkbox',
                'label'     => __( 'Show Symbol After Amount', 'inventor-currencies' ),
                'section'   => "inventor_currencies[$i]",
                'settings'  => "inventor_currencies[$i][show_after]",
            ) );

            // Decimal places
            $wp_customize->add_setting( "inventor_currencies[$i][money_decimals]", array(
                'default'           => 0,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( "inventor_currencies[$i][money_decimals]", array(
                'label'         => __( 'Decimal places', 'inventor-currencies' ),
                'section'       => "inventor_currencies[$i]",
                'settings'      => "inventor_currencies[$i][money_decimals]",
                'type'          => 'select',
                'choices'       => array(
                    0               => '0',
                    1               => '1',
                    2               => '2',
                ),
            ) );

            // Decimal separator
            $wp_customize->add_setting( "inventor_currencies[$i][money_dec_point]", array(
                'default'           => '.',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( "inventor_currencies[$i]_money_dec_point", array(
                'label'         => __( 'Decimal Separator', 'inventor-currencies' ),
                'section'       => "inventor_currencies[$i]",
                'settings'      => "inventor_currencies[$i][money_dec_point]",
                'type'          => 'select',
                'choices'       => array(
                    '.'               => __ ( '. (dot)', 'inventor-currencies' ),
                    ','               => __ ( ', (comma)', 'inventor-currencies' ),
                ),
            ) );

            // Thousands Separator
            $wp_customize->add_setting( "inventor_currencies[$i][money_thousands_separator]", array(
                'default'           => ',',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( "inventor_currencies[$i][money_thousands_separator]", array(
                'label'         => __( 'Thousands Separator', 'inventor-currencies' ),
                'section'       => "inventor_currencies[$i]",
                'settings'      => "inventor_currencies[$i][money_thousands_separator]",
                'type'          => 'select',
                'choices'       => array(
                    '.'               => __ ( '. (dot)', 'inventor-currencies' ),
                    ','               => __ ( ', (comma)', 'inventor-currencies' ),
                    'space'           => __ ( '" " (space)', 'inventor-currencies' ),
                    ''                => __ ( '"" (empty string)', 'inventor-currencies' ),
                ),
            ) );

            // Rate
            $wp_customize->add_setting( "inventor_currencies[$i][rate]", array(
                'default'           => 1,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( "inventor_currencies[$i][rate]", array(
                'label'         => __( 'Rate', 'inventor-currencies' ),
                'section'       => "inventor_currencies[$i]",
                'settings'      => "inventor_currencies[$i][rate]",
                'description'   => __( 'Rate from default currency', 'inventor-currencies' ),
            ) );
        }
    }
}

Inventor_Currencies_Customizations_Currencies::init();
