<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Field_Types_Phone
 *
 * @access public
 * @package Inventor/Classes/Field_Types
 * @return void
 */
class Inventor_Field_Types_Phone {
    public static $international_calling_codes = array(
        '213' => 'Algeria',
        '376' => 'Andorra',
        '244' => 'Angola',
        '1264' => 'Anguilla',
        '1268' => 'Antigua &amp; Barbuda',
        '54' => 'Argentina',
        '374' => 'Armenia',
        '297' => 'Aruba',
        '61' => 'Australia',
        '43' => 'Austria',
        '994' => 'Azerbaijan',
        '1242' => 'Bahamas',
        '973' => 'Bahrain',
        '880' => 'Bangladesh',
        '1246' => 'Barbados',
        '375' => 'Belarus',
        '32' => 'Belgium',
        '501' => 'Belize',
        '229' => 'Benin',
        '1441' => 'Bermuda',
        '975' => 'Bhutan',
        '591' => 'Bolivia',
        '387' => 'Bosnia Herzegovina',
        '267' => 'Botswana',
        '55' => 'Brazil',
        '673' => 'Brunei',
        '359' => 'Bulgaria',
        '226' => 'Burkina Faso',
        '257' => 'Burundi',
        '855' => 'Cambodia',
        '237' => 'Cameroon',
        '238' => 'Cape Verde Islands',
        '1345' => 'Cayman Islands',
        '236' => 'Central African Republic',
        '56' => 'Chile',
        '86' => 'China',
        '57' => 'Colombia',
        '269' => 'Comoros',
        '242' => 'Congo',
        '682' => 'Cook Islands',
        '506' => 'Costa Rica',
        '385' => 'Croatia',
        '53' => 'Cuba',
        '357' => 'Cyprus',
        '42' => 'Czech Republic',
        '45' => 'Denmark',
        '253' => 'Djibouti',
        '1 767' => 'Dominica',
        '1 809' => 'Dominican Republic',
        '593' => 'Ecuador',
        '20' => 'Egypt',
        '503' => 'El Salvador',
        '240' => 'Equatorial Guinea',
        '291' => 'Eritrea',
        '372' => 'Estonia',
        '251' => 'Ethiopia',
        '500' => 'Falkland Islands',
        '298' => 'Faroe Islands',
        '679' => 'Fiji',
        '358' => 'Finland',
        '33' => 'France',
        '594' => 'French Guiana',
        '689' => 'French Polynesia',
        '241' => 'Gabon',
        '220' => 'Gambia',
        '7880' => 'Georgia',
        '49' => 'Germany',
        '233' => 'Ghana',
        '350' => 'Gibraltar',
        '30' => 'Greece',
        '299' => 'Greenland',
        '1473' => 'Grenada',
        '590' => 'Guadeloupe',
        '671' => 'Guam',
        '502' => 'Guatemala',
        '224' => 'Guinea',
        '245' => 'Guinea - Bissau',
        '592' => 'Guyana',
        '509' => 'Haiti',
        '504' => 'Honduras',
        '852' => 'Hong Kong',
        '36' => 'Hungary',
        '354' => 'Iceland',
        '91' => 'India',
        '62' => 'Indonesia',
        '98' => 'Iran',
        '964' => 'Iraq',
        '353' => 'Ireland',
        '972' => 'Israel',
        '39' => 'Italy',
        '1876' => 'Jamaica',
        '81' => 'Japan',
        '962' => 'Jordan',
        '7 7' => 'Kazakhstan',
        '254' => 'Kenya',
        '686' => 'Kiribati',
        '850' => 'Korea North',
        '82' => 'Korea South',
        '965' => 'Kuwait',
        '996' => 'Kyrgyzstan',
        '856' => 'Laos',
        '371' => 'Latvia',
        '961' => 'Lebanon',
        '266' => 'Lesotho',
        '231' => 'Liberia',
        '218' => 'Libya',
        '417' => 'Liechtenstein',
        '370' => 'Lithuania',
        '352' => 'Luxembourg',
        '853' => 'Macao',
        '389' => 'Macedonia',
        '261' => 'Madagascar',
        '265' => 'Malawi',
        '60' => 'Malaysia',
        '960' => 'Maldives',
        '223' => 'Mali',
        '356' => 'Malta',
        '692' => 'Marshall Islands',
        '596' => 'Martinique',
        '222' => 'Mauritania',
        '262' => 'Mayotte and Reunion',
        '52' => 'Mexico',
        '691' => 'Micronesia',
        '373' => 'Moldova',
        '377' => 'Monaco',
        '976' => 'Mongolia',
        '1664' => 'Montserrat',
        '212' => 'Morocco',
        '258' => 'Mozambique',
        '95' => 'Myanmar',
        '264' => 'Namibia',
        '674' => 'Nauru',
        '977' => 'Nepal',
        '31' => 'Netherlands',
        '687' => 'New Caledonia',
        '64' => 'New Zealand',
        '505' => 'Nicaragua',
        '227' => 'Niger',
        '234' => 'Nigeria',
        '683' => 'Niue',
        '672' => 'Norfolk Islands',
        '670' => 'Northern Marianas',
        '47' => 'Norway',
        '968' => 'Oman',
        '680' => 'Palau',
        '507' => 'Panama',
        '675' => 'Papua New Guinea',
        '595' => 'Paraguay',
        '51' => 'Peru',
        '63' => 'Philippines',
        '48' => 'Poland',
        '351' => 'Portugal',
        '1787' => 'Puerto Rico',
        '974' => 'Qatar',
        '40' => 'Romania',
        '7' => 'Russia',
        '250' => 'Rwanda',
        '378' => 'San Marino',
        '239' => 'Sao Tome &amp; Principe',
        '966' => 'Saudi Arabia',
        '221' => 'Senegal',
        '381' => 'Serbia',
        '248' => 'Seychelles',
        '232' => 'Sierra Leone',
        '65' => 'Singapore',
        '421' => 'Slovak Republic',
        '386' => 'Slovenia',
        '677' => 'Solomon Islands',
        '252' => 'Somalia',
        '27' => 'South Africa',
        '34' => 'Spain',
        '94' => 'Sri Lanka',
        '290' => 'St. Helena',
        '1869' => 'St. Kitts',
        '1758' => 'St. Lucia',
        '249' => 'Sudan',
        '597' => 'Suriname',
        '268' => 'Swaziland',
        '46' => 'Sweden',
        '41' => 'Switzerland',
        '963' => 'Syria',
        '886' => 'Taiwan',
        '66' => 'Thailand',
        '228' => 'Togo',
        '676' => 'Tonga',
        '1868' => 'Trinidad &amp; Tobago',
        '216' => 'Tunisia',
        '90' => 'Turkey',
        '993' => 'Turkmenistan',
        '1649' => 'Turks &amp; Caicos Islands',
        '688' => 'Tuvalu',
        '256' => 'Uganda',
        '44' => 'UK',
        '380' => 'Ukraine',
        '971' => 'United Arab Emirates',
        '598' => 'Uruguay',
        '1' => 'USA &amp; Canada',
        '+998' => 'Uzbekistan',
        '678' => 'Vanuatu',
        '379' => 'Vatican City',
        '58' => 'Venezuela',
        '84' => 'Vietnam',
        '1 284' => 'Virgin Islands - British',
        '1 340' => 'Virgin Islands - US',
        '681' => 'Wallis &amp; Futuna',
        '969' => 'Yemen (North)',
        '967' => 'Yemen (South)',
        '260' => 'Zambia',
        '263' => 'Zimbabwe',
    );

    /**
     * Initialize customizations
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_filter( 'cmb2_render_phone', array( __CLASS__, 'render' ), 10, 5 );
        add_filter( 'cmb2_sanitize_phone', array( __CLASS__, 'sanitize' ), 12, 4 );
    }

    /**
     * Adds new field type
     *
     * @access public
     * @param $field
     * @param $value
     * @param $object_id
     * @param $object_type
     * @param $field_type_object
     * @return void
     */
    public static function render( $field, $value, $object_id, $object_type, $field_type_object ) {
        $object_type = $field->object_type;
        $metabox_id = $field_type_object->field->cmb_id;

        if ( $object_type == 'user' ) {
            $prefix = get_user_meta( $object_id, $field_type_object->_id( '_prefix' ), true );
            $number = get_user_meta( $object_id, $field_type_object->_id( '_number' ), true );
        } else {
            $prefix = get_post_meta( $object_id, $field_type_object->_id( '_prefix' ), true );
            $number = get_post_meta( $object_id, $field_type_object->_id( '_number' ), true );
        }

        $value = wp_parse_args( $value, array(
            'prefix'     => $prefix,
            'number'     => $number,
        ) );

        if ( empty( $value['prefix'] ) ) {
            $value['prefix'] = apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_type_object->_id( '_prefix' ), 'user' );
        }

        if ( empty( $value['number'] ) ) {
            $value['number'] = apply_filters( 'inventor_metabox_field_default', null, $metabox_id, $field_type_object->_id( '_number' ), 'user' );
        }

        $prefix_options = '';
        // can override via the field options param
        $select_text = esc_html( $field_type_object->_text( 'phone_select_prefix_text', 'Select a Country' ) );

        $prefix_options .= '<option value="" '. selected( $value['prefix'], "", false ) .'>'. $select_text . '</option>';
        foreach ( self::$international_calling_codes as $code => $country ) {
            $prefix_options .= '<option value="+'. $code .'" '. selected( $value['prefix'], '+' . $code, false ) .'>'. $country .' (+'. $code .') </option>';
        }
        ?>

        <div class="alignleft"><p><label for="<?php echo $field_type_object->_id( '_prefix' ); ?>'"><?php echo esc_html( $field_type_object->_text( 'phone_prefix_text', 'Country Code' ) ); ?></label></p>
            <?php echo $field_type_object->select( array(
                'name'      => $field_type_object->_name( '[prefix]' ),
                'id'        => $field_type_object->_id( '_prefix' ),
                'options'   => $prefix_options,
                'desc'      => '',
                'data-size' => 10
            ) ); ?>
        </div>
        <div class="alignleft"><p><label for="<?php echo $field_type_object->_id( '_number' ); ?>'"><?php echo esc_html( $field_type_object->_text( 'phone_number_text', 'Number' ) ); ?></label></p>
            <?php echo $field_type_object->input( array(
                'class' => 'cmb_text_small',
                'name'  => $field_type_object->_name( '[number]' ),
                'id'    => $field_type_object->_id( '_number' ),
                'value' => $value['number'],
                'type'  => 'text',
                'desc'  => '',
            ) ); ?>
        </div>
        <p class="clear">
            <?php echo $field_type_object->_desc();?>
        </p>
        <?php
    }

    /**
     * Sanitizes the value
     *
     * @access public
     * @param $override_value
     * @param $value
     * @param $object_id
     * @param $field_args
     * @return mixed
     */
    public static function sanitize( $override_value, $value, $object_id, $field_args ) {
        $user_exists = get_user_by( 'ID', $object_id );
        $object_type = $user_exists ? 'user' : 'post';

        $phone_keys = array( 'prefix', 'number' );

        $phone = '';

        foreach ( $phone_keys as $key ) {
            $part = esc_attr( $value[ $key ] );

            if ( isset( $part ) ) {

                if ( $object_type == 'user' ) {
                    update_user_meta( $object_id, $field_args['id'] . '_'. $key, $part );
                } else {
                    update_post_meta( $object_id, $field_args['id'] . '_'. $key, $part );
                }

                $phone .= $part;
            }
        }

        // Tell CMB2 we already did the update
        return $phone;
    }

    /**
     * Escapes the value
     *
     * @access public
     * @param @value
     * @return mixed
     */
    public static function escape( $value ) {
        return $value;
    }
}

Inventor_Field_Types_Phone::init();