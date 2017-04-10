<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Coupons_Widget_Coupon_Detail
 *
 * @class Inventor_Coupons_Widget_Coupon_Detail
 * @package Inventor_Coupons/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Coupons_Widget_Coupon_Detail extends WP_Widget {
	/**
	 * Initialize widget
	 *
	 * @access public
	 */
	function __construct() {
		parent::__construct(
			'coupon_detail',
			__( 'Coupon Detail', 'inventor-coupons' ),
			array(
				'description' => __( 'Coupon Detail.', 'inventor-coupons' ),
			)
		);
	}

	/**
	 * Frontend
	 *
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		if ( is_singular( 'coupon' ) && class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate('widgets/coupon-detail', INVENTOR_COUPONS_DIR);
		}
	}

	/**
	 * Update
	 *
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Backend
	 *
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		if ( class_exists( 'Inventor_Template_Loader' ) ) {
			include Inventor_Template_Loader::locate( 'widgets/coupon-detail-admin', INVENTOR_COUPONS_DIR );
			include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
			include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
		}
	}
}