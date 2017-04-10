<?php do_action( 'inventor_before_filter_form', $args ); ?>

<form method="get"
	  action="<?php echo esc_attr( Inventor_Filter::get_filter_action() ); ?>"
	  class="filter-form <?php if ( ! empty( $instance['live_filtering'] ) ) : ?>live <?php endif; ?><?php if ( ! empty( $instance['auto_submit_filter'] ) || empty( $instance['button_text'] ) ) : ?>auto-submit-filter <?php endif; ?><?php if ( ! empty( $input_titles ) && 'labels' == $input_titles ) : ?>has-labels<?php endif; ?>">

	<?php include Inventor_Template_Loader::locate( 'widgets/filter-fields' ); ?>

	<?php if ( ! empty( $instance['button_text'] ) && empty( $instance['auto_submit_filter'] ) ) : ?>
		<div class="form-group form-group-button">
			<button class="button" type="submit"><?php echo esc_attr( $instance['button_text'] ); ?></button>
		</div><!-- /.form-group -->
	<?php endif; ?>

	<?php if ( ! empty( $instance['sorting_options'] ) ) : ?>
		<?php include Inventor_Template_Loader::locate( 'widgets/filter-form-sorting-options' ); ?>
	<?php endif; ?>
</form>

<?php do_action( 'inventor_after_filter_form', $args ); ?>
