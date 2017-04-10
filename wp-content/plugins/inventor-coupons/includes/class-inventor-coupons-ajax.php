<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Coupons_Ajax
 *
 * @class Inventor_Coupons_Ajax
 * @package Inventor_Coupons_Ajax
 * @author Pragmatic Mates
 */
class Inventor_Coupons_Ajax {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_ajax_inventor_coupons_generate_code', array( __CLASS__, 'generate_code' ) );
	}

	/**
	 * Generate coupon code
	 *
	 * @access public
	 * @return void
	 */
	public static function generate_code() {
		header( 'HTTP/1.0 200 OK' );
		header( 'Content-Type: application/json' );

		$coupon_id = absint( $_GET['id'] );

		// Validated coupon ID
		if ( empty( $coupon_id ) || ! is_int( $coupon_id ) ) {
			echo json_encode( array(
				'status'    => false,
				'message'   => esc_attr__( 'Missing coupon ID.', 'inventor-coupons' ),
			) );
			wp_die();
		}

		$coupon = get_post( $coupon_id );

		// Check if coupon exists
		if ( null === $coupon ) {
			echo json_encode( array(
				'status'    => false,
				'message'   => esc_attr__( 'Coupon does not exists.', 'inventor-coupons' ),
			) );
			wp_die();
		}

		$codes = get_post_meta( $coupon_id, INVENTOR_COUPON_PREFIX . 'codes', true );

		// Initialize $codes array if we have no codes in dtabase
		if ( empty( $codes ) ) {
			 $codes = array();
		}

		// Check if code for already signed user exists
		$user_code = Inventor_Coupons_Logic::get_user_code( $coupon_id, get_current_user_id() );

		if ( ! empty( $user_code) ) {
			echo json_encode( array(
				'status'  => false,
				'message' => esc_attr__( 'You have already generated your coupon code.', 'inventor-coupons' ),
			) );
			wp_die();
		}

		// Max number of coupons exceeded
		$max_number = get_post_meta( $coupon_id, INVENTOR_COUPON_PREFIX . 'count', true );

		if ( ! empty( $max_number) ) {
			if ( count( $codes ) >= $max_number ) {
				echo json_encode( array(
					'status'  => false,
					'message' => esc_attr__( 'Max number of coupons exceeded.', 'inventor-coupons' ),
				) );
				wp_die();
			}
		}

		// Create new code
		$user_code = Inventor_Utilities::get_short_uuid();
		$user_id = get_current_user_id();

		if ( ! empty( $user_code ) && ! empty( $user_id ) ) {
			$codes[] = array(
				INVENTOR_COUPON_PREFIX . 'code_generated' => $user_code,
				INVENTOR_COUPON_PREFIX . 'user_id'        => $user_id,
			);
		}

		update_post_meta( $_GET['id'], INVENTOR_COUPON_PREFIX . 'codes', $codes );

		echo json_encode( array(
			'status'    => true,
			'code'      => $user_code,
		) );
		wp_die();
	}
}

Inventor_Coupons_Ajax::init();