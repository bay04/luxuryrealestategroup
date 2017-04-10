<?php
/**
 * Class CMB2_Field_Google_Street_View
 */
class CMB2_Field_Google_Street_View {

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public function __construct() {
		add_filter( 'cmb2_render_street_view', array( $this, 'render_street_view' ), 10, 5 );
		add_filter( 'cmb2_sanitize_street_view', array( $this, 'sanitize_street_view' ), 10, 4 );
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_backend' ) );
	}

	/**
	 * Render field
	 */
	public function render_street_view( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {

        echo '<input type="text" class="large-text street-view-search" id="' . $field->args( 'id' ) . '" />';

		echo '<div id="street-view-map"></div>';
        echo '<div id="street-view"></div>';

		$field_type_object->_desc( true, true );

		echo $field_type_object->input( array(
			'type'       => 'hidden',
			'name'       => $field->args( '_name' ) . '[latitude]',
			'value'      => isset( $field_escaped_value['latitude'] ) ? $field_escaped_value['latitude'] : '',
			'class'      => 'street-view-latitude',
            'readonly'   => true,
 		) );
		echo $field_type_object->input( array(
			'type'       => 'hidden',
			'name'       => $field->args( '_name' ) . '[longitude]',
			'value'      => isset( $field_escaped_value['longitude'] ) ? $field_escaped_value['longitude'] : '',
			'class'      => 'street-view-longitude',
            'readonly'   => true,
		) );
        echo $field_type_object->input( array(
            'type'       => 'hidden',
            'name'       => $field->args( '_name' ) . '[zoom]',
            'value'      => isset( $field_escaped_value['zoom'] ) ? $field_escaped_value['zoom'] : '',
            'class'      => 'street-view-zoom',
            'readonly'   => true,
        ) );
        echo $field_type_object->input( array(
            'type'       => 'hidden',
            'name'       => $field->args( '_name' ) . '[heading]',
            'value'      => isset( $field_escaped_value['heading'] ) ? $field_escaped_value['heading'] : '',
            'class'      => 'street-view-heading',
            'readonly'   => true,
        ) );
        echo $field_type_object->input( array(
            'type'       => 'hidden',
            'name'       => $field->args( '_name' ) . '[pitch]',
            'value'      => isset( $field_escaped_value['pitch'] ) ? $field_escaped_value['pitch'] : '',
            'class'      => 'street-view-pitch',
            'readonly'   => true,
        ) );
	}

	/**
	 * Optionally save the latitude/longitude values into two custom fields
	 */
	public function sanitize_street_view( $override_value, $value, $object_id, $field_args ) {
		if ( isset( $field_args['split_values'] ) && $field_args['split_values'] ) {
			if ( isset( $value['latitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_latitude', $value['latitude'] );
			}

			if ( isset( $value['longitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_longitude', $value['longitude'] );
			}

            if ( isset( $value['zoom'] ) ) {
                update_post_meta( $object_id, $field_args['id'] . '_zoom', $value['zoom'] );
            }

            if ( isset( $value['heading'] ) ) {
                update_post_meta( $object_id, $field_args['id'] . '_heading', $value['heading'] );
            }

            if ( isset( $value['pitch'] ) ) {
                update_post_meta( $object_id, $field_args['id'] . '_pitch', $value['pitch'] );
            }
		}

		return $value;
	}

    /**
     * Enqueue scripts and styles
     */
    public static function enqueue_frontend() {
        wp_enqueue_script( 'cmb-google-street-view', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_style( 'cmb-google-street-view', plugins_url( 'css/style.css', __FILE__ ) );
    }

	/**
	 * Enqueue scripts and styles
	 */
	public static function enqueue_backend() {
		wp_enqueue_script( 'cmb-google-street-view', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_style( 'cmb-google-street-view', plugins_url( 'css/style.css', __FILE__ ) );
	}
}
new CMB2_Field_Google_Street_View();
