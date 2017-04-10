<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Inventor_Coupons_Metaboxes
 *
 * @class Inventor_Coupons/Metaboxes
 * @package Inventor_Coupons_Metaboxes/Classes/Metaboxes
 * @author Pragmatic Mates
 */
class Inventor_Coupons_Metaboxes {
	/**
	 * General fields
	 *
	 * @access public
	 * @return void
	 */
   public static function metabox_details() {
     	$cmb = new_cmb2_box( array(
 			'id'                => INVENTOR_COUPON_PREFIX . 'details',
 			'title'             => __( 'Coupon details', 'inventor-coupons' ),
 			'object_types'      => array( 'coupon' ),
 			'context'           => 'normal',
 			'priority'          => 'high',
 			'show_names'        => true,
 			'skip'              => true,
		 	'show_in_rest'      => true,
 		) );

 		$cmb->add_field( array(
 			'id'                => INVENTOR_COUPON_PREFIX . 'discount',
 			'name'              => __( 'Discount', 'inventor-coupons' ),
 			'type'              => 'text_small',
			'description'       => __( 'Insert integer number like: 30. It will be outputted as 30%.', 'inventor-coupons' ),
			'attributes'		=> array(
				'type'				=> 'number',
				'min'				=> 0,
				'pattern'			=> '\d*',
			)
		) );

 		$cmb->add_field( array(
 			'id'                    => INVENTOR_COUPON_PREFIX . 'variant',
 			'name'                  => __( 'Variant', 'inventor-coupons' ),
 			'type'                  => 'radio',
 			'default'               => 'image',
 			'options'               => array(
 				'image'             => __( 'Image', 'inventor-coupons' ),
 				'code'              => __( 'Custom code', 'inventor-coupons' ),
 				'code_generated'    => __( 'Generated code', 'inventor-coupons' ),
 			),
 		) );

 		$cmb->add_field( array(
 			'id'                => INVENTOR_COUPON_PREFIX . 'image',
 			'name'              => __( 'Image', 'inventor-coupons' ),
 			'type'              => 'file',
 		) );

 		$cmb->add_field( array(
 			'id'                => INVENTOR_COUPON_PREFIX . 'count',
 			'name'              => __( 'Max. number', 'inventor-coupons' ),
			'type'              => 'text_small',
 			'description'       => __( 'Insert integer for max. number of codes which can be generated.', 'inventor-coupons' ),
			'attributes'		=> array(
				'type'				=> 'number',
				'min'				=> 0,
				'pattern'			=> '\d*',
			)
 		) );

 		$cmb->add_field( array(
 			'id'                => INVENTOR_COUPON_PREFIX . 'code',
 			'name'              => __( 'Coupon code', 'inventor-coupons' ),
 			'type'              => 'text',
 		) );

 		$cmb->add_field( array(
 			'id'                => INVENTOR_COUPON_PREFIX . 'valid',
 			'name'              => __( 'Coupon Valid', 'inventor-coupons' ),
 			'description'       => __( 'Validation description', 'inventor-coupons' ),
 			'type'              => 'text',
 		) );

 		$cmb->add_field( array(
 			'id'                => INVENTOR_COUPON_PREFIX . 'conditions',
 			'name'              => __( 'Conditions', 'inventor-coupons' ),
 			'type'              => 'textarea',
 		) );
   }

   /**
   	* Codes
   	*
   	* @access public
   	* @return void
   	*/
   public static function metabox_codes() {
     	// codes
  		$cmb = new_cmb2_box( array(
  			'id'            => INVENTOR_COUPON_PREFIX . 'codes',
  			'title'         => __( 'Generated Code', 'inventor-coupons' ),
  			'object_types'  => array( 'coupon' ),
  			'context'       => 'advanced',
  			'priority'      => 'low',
  			'skip'          => true,
  		) );

  		$group = $cmb->add_field( array(
  			'id'          	=> INVENTOR_COUPON_PREFIX . 'codes',
  			'type'        	=> 'group',
  			'post_type'   	=> 'coupon',
  			'repeatable'  	=> true,
  			'options'     	=> array(
  				'group_title'   => __( 'Generated Codes', 'inventor-coupons' ),
  				'add_button'    => __( 'Add Another Code', 'inventor-coupons' ),
  				'remove_button' => __( 'Remove Code', 'inventor-coupons' ),
  			),
  		) );

  		$cmb->add_group_field( $group, array(
  			'id'            => INVENTOR_COUPON_PREFIX . 'user_id',
  			'name'          => __( 'User ID', 'inventor-coupons' ),
  			'type'          => 'text',
  		) );

  		$cmb->add_group_field( $group, array(
  			'id'            => INVENTOR_COUPON_PREFIX . 'code_generated',
  			'name'          => __( 'Code', 'inventor-coupons' ),
  			'type'          => 'text',
  		) );
   }
}
