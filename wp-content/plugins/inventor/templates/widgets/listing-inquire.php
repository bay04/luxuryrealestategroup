<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

	<div class="widget-inner
 <?php if ( ! empty( $instance['classes'] ) ) : ?><?php echo esc_attr( $instance['classes'] ); ?><?php endif; ?>
 <?php echo ( empty( $instance['padding_top'] ) ) ? '' : 'widget-pt' ; ?>
 <?php echo ( empty( $instance['padding_bottom'] ) ) ? '' : 'widget-pb' ; ?>"
		<?php if ( ! empty( $instance['background_color'] ) || ! empty( $instance['background_image'] ) ) : ?>
			style="
			<?php if ( ! empty( $instance['background_color'] ) ) : ?>
				background-color: <?php echo esc_attr( $instance['background_color'] ); ?>;
    <?php endif; ?>
			<?php if ( ! empty( $instance['background_image'] ) ) : ?>
				background-image: url('<?php echo esc_attr( $instance['background_image'] ); ?>');
			<?php endif; ?>"
		<?php endif; ?>>

		<?php if ( ! empty( $instance['title'] ) ) : ?>
			<?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
			<?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
			<?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
		<?php endif; ?>
		<form method="post" action="<?php the_permalink(); ?>">
			<input type="hidden" name="post_id" value="<?php the_ID(); ?>">

			<?php if ( ! empty( $instance['receive_admin'] ) ) : ?>
				<input type="hidden" name="receive_admin" value="1">
			<?php endif; ?>

			<?php if ( ! empty( $instance['receive_author'] ) ) : ?>
				<input type="hidden" name="receive_author" value="1">
			<?php endif; ?>

			<?php if ( ! empty( $instance['receive_listing_email'] ) ) : ?>
				<input type="hidden" name="receive_listing_email" value="1">
			<?php endif; ?>

			<?php if ( ! empty( $instance['show_name'] ) ) : ?>
				<div class="form-group">
					<input class="form-control" name="name" type="text" placeholder="<?php echo __( 'Name', 'inventor' ); ?>" value="<?php echo empty( $_POST['name'] ) ? '' : esc_attr( $_POST['name'] ); ?>" required="required">
				</div><!-- /.form-group -->
			<?php endif; ?>

			<?php if ( ! empty( $instance['show_email'] ) ) : ?>
				<div class="form-group">
					<input class="form-control" name="email" type="email" placeholder="<?php echo __( 'E-mail', 'inventor' ); ?>" value="<?php echo empty( $_POST['email'] ) ? '' : esc_attr( $_POST['email'] ); ?>" required="required">
				</div><!-- /.form-group -->
			<?php endif; ?>

			<?php if ( ! empty( $instance['show_phone'] ) ) : ?>
				<div class="form-group">
					<input class="form-control" name="phone" type="text" placeholder="<?php echo __( 'Phone', 'inventor' ); ?>" value="<?php echo empty( $_POST['phone'] ) ? '' : esc_attr( $_POST['phone'] ); ?>" required="required">
				</div><!-- /.form-group -->
			<?php endif; ?>

			<?php if ( ! empty( $instance['show_subject'] ) ) : ?>
				<div class="form-group">
					<input class="form-control" name="subject" type="text" placeholder="<?php echo __( 'Subject', 'inventor' ); ?>" value="<?php echo empty( $_POST['subject'] ) ? '' : esc_attr( $_POST['subject'] ); ?>" required="required">
				</div><!-- /.form-group -->
			<?php endif; ?>

			<?php if ( ! empty( $instance['show_date'] ) ) : ?>
				<div class="form-group">
					<input class="form-control" name="date" type="date" placeholder="<?php echo __( 'Date', 'inventor' ); ?>" value="<?php echo empty( $_POST['date'] ) ? '' : esc_attr( $_POST['date'] ); ?>" required="required">
				</div><!-- /.form-group -->
			<?php endif; ?>

			<?php if ( ! empty( $instance['show_message'] ) ) : ?>
				<div class="form-group">
					<textarea class="form-control" name="message" required="required" placeholder="<?php echo __( 'Message', 'inventor' ); ?>" rows="4"><?php echo empty( $_POST['message'] ) ? '' : esc_attr( $_POST['message'] ); ?></textarea>
				</div><!-- /.form-group -->
			<?php endif; ?>

			<?php if ( ! empty( $instance['show_recaptcha'] ) && class_exists( 'Inventor_Recaptcha' ) ) : ?>
				<?php if ( Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) : ?>
					<div id="recaptcha-<?php echo esc_attr( $this->id ); ?>" class="g-recaptcha" data-sitekey="<?php echo get_theme_mod( 'inventor_recaptcha_site_key' ); ?>"></div>
				<?php endif; ?>
			<?php endif; ?>

			<div class="button-wrapper">
				<button type="submit" class="button" name="inquire_form"><?php echo __( 'Send Message', 'inventor' ); ?></button>
			</div><!-- /.button-wrapper -->
		</form>
	</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>