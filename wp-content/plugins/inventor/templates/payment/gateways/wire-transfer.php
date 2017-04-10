<?php
$payment_type = ! empty( $_POST['payment_type'] ) ? $_POST['payment_type'] : null;
$object_id = ! empty( $_POST['object_id'] ) ? $_POST['object_id'] : null;
$title = get_the_title( $object_id );
$variable_symbol = $object_id;
$reference = $title;
?>

<?php if ( 'package' == $payment_type ) : ?>
	<?php $reference = sprintf( __( 'for package "%s"', 'inventor' ), $title ); ?>
<?php endif; ?>

<div class="wire-transfer clearfix">
	<div class=".wire-transfer-section wire-transfer-section-one">
		<div class="wire-transfer-info wire-transfer-account-number">
			<dt><?php echo __( "Beneficiary's account number", 'inventor' ); ?></dt>
			<dd><?php echo get_theme_mod( 'inventor_wire_transfer_account_number', null ) ?></dd>
		</div><!-- /.wire-transfer-info -->

		<div class="wire-transfer-info wire-transfer-bank-code">
			<dt><?php echo __( 'Bank code (SWIFT/BIC)', 'inventor' ); ?></dt>
			<dd><?php echo get_theme_mod( 'inventor_wire_transfer_swift', null ) ?></dd>
		</div><!-- /.wire-transfer-info -->

		<div class="wire-transfer-info wire-transfer-variable-symbol">
			<dt><?php echo __( 'Variable symbol', 'inventor' ); ?></dt>
			<dd><?php echo esc_attr( $variable_symbol ); ?></dd>
		</div><!-- /.wire-transfer-info -->

		<div class="wire-transfer-info wire-transfer-reference">
			<dt><?php echo __( 'Information / reference', 'inventor' ); ?></dt>
			<dd><?php echo esc_attr( $reference ); ?></dd>
		</div><!-- /.wire-transfer-info -->
	</div><!-- /.wire-transfer-section -->

	<div class="wire-transfer-section wire-transfer-section-two">
		<div class="wire-transfer-info wire-transfer-full-name">
			<dt><?php echo __( "Beneficiary's name", 'inventor' ); ?></dt>
			<dd><?php echo get_theme_mod( 'inventor_wire_transfer_full_name', null ) ?></dd>
		</div><!-- /.wire-transfer-info -->

		<div class="wire-transfer-info wire-transfer-street">
			<dt><?php echo __( 'Street / P.O.Box', 'inventor' ); ?></dt>
			<dd><?php echo get_theme_mod( 'inventor_wire_transfer_street', null ) ?></dd>
		</div><!-- /.wire-transfer-info -->

		<div class="wire-transfer-info wire-transfer-postcode">
			<dt><?php echo __( 'Postcode (ZIP)', 'inventor' ); ?></dt>
			<dd><?php echo get_theme_mod( 'inventor_wire_transfer_postcode', null ) ?></dd>
		</div><!-- /.wire-transfer-info -->

		<div class="wire-transfer-info wire-transfer-city">
			<dt><?php echo __( 'City', 'inventor' ); ?></dt>
			<dd><?php echo get_theme_mod( 'inventor_wire_transfer_city', null ) ?></dd>
		</div><!-- /.wire-transfer-info -->

		<div class="wire-transfer-info wire-transfer-country">
			<dt><?php echo __( 'Country', 'inventor' ); ?></dt>
			<dd><?php echo get_theme_mod( 'inventor_wire_transfer_country', null ) ?></dd>
		</div><!-- /.wire-transfer-info -->
	</div><!-- /.wire-transfer-section -->
</div>

<div class="alert alert-info">
    <?php echo __( 'Your payment will be manually reviewed when transfer will be completed.', 'inventor' ); ?>
</div>