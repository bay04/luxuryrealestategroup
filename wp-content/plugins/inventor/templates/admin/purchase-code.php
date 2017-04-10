<tr class="plugin-update-tr inventor-update-plugin-message"><td colspan="<?php echo esc_attr( $count ); ?>" class="plugin-update colspanchange">
	<div class="update-message installer-q-icon">
		<div class="inventor-update-plugin-message-purchase-code" data-action="<?php echo INVENTOR_API_VERIFY_URL; ?>">
			<?php echo __( 'Please enter valid purchase code to get an update', 'inventor' ) ?>:
			<input type="text" size="37" name="purchase-code" class="inventor-update-plugin-message-input">

			<button type="submit" class="button inventor-update-plugin-message-submit"
			        data-preloader="<?php echo site_url( '/wp-admin/images/wpspin_light.gif' ); ?>"
			        data-action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
				<?php echo __( 'Confirm', 'inventor' ); ?>
			</button><!-- /.inventor-update-plugin-message-submit -->
		</div>

		<div class="inventor-update-plugin-message-how-to" >
			<small>
				<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Can-I-Find-my-Purchase-Code-">
					<?php echo __( 'How to find purchase code.', 'inventor' ); ?>
				</a>
			</small>
		</div><!-- /.inventor-update-plugin-message-how-to -->
	</div><!-- /.update-message  -->
</tr><!-- /.inventor-update-plugin-message -->