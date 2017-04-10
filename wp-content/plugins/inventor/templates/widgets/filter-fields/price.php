<?php if ( empty( $instance['hide_price'] ) ) : ?>
	<?php $price_range = Inventor_Filter::get_field_range( 'price', $_GET ); ?>
	<?php $current_currency = Inventor_Price::current_currency(); ?>
	<?php $currency_symbol = $current_currency['symbol']; ?>

	<div class="form-group form-group-price form-group-price-from">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_from"><?php echo __( 'Price from', 'inventor' ); ?></label>
		<?php endif; ?>

		<div class="input-group">
			<input type="text"
				   <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Price from', 'inventor' ); ?>"<?php endif; ?>
				   class="form-control price-from" value="<?php echo empty( $price_range['from'] ) ? '' : $price_range['from']; ?>"
				   id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_from">

			<span class="input-group-addon">
				<?php echo $currency_symbol; ?>
			</span>
		</div><!-- /.input-group -->
	</div><!-- /.form-group -->

	<div class="form-group form-group-price form-group-price-to">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_to"><?php echo __( 'Price to', 'inventor' ); ?></label>
		<?php endif; ?>

		<div class="input-group">
			<input type="text"
				   <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Price to', 'inventor' ); ?>"<?php endif; ?>
				   class="form-control price-to" value="<?php echo empty( $price_range['to'] ) ? '' : $price_range['to']; ?>"
				   id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_to">

			<span class="input-group-addon">
				<?php echo $currency_symbol; ?>
			</span>
		</div><!-- /.input-group -->
	</div><!-- /.form-group -->

	<input type="hidden" name="price" class="form-control" value="<?php echo is_array( $price_range ) ? implode( '-', $price_range ) : ''; ?>" id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price">
<?php endif; ?>