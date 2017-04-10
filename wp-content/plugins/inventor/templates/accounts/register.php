<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( get_option( 'users_can_register' ) ) : ?>
	<?php if ( ! is_user_logged_in() ) : ?>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="register-form">
			<?php do_action( 'inventor_register_form_fields_before' ); ?>

		    <div class="form-group">
		        <label for="register-form-name"><?php echo __( 'Username', 'inventor' ); ?></label>
		        <input id="register-form-name" type="text" name="username" class="form-control" value="<?php echo empty( $_POST['username'] ) ? '' : esc_attr( $_POST['username'] ); ?>" required="required">
		    </div><!-- /.form-group -->

		    <div class="form-group">
		        <label for="register-form-email"><?php echo __( 'E-mail', 'inventor' ); ?></label>
		        <input id="register-form-email" type="email" name="email" class="form-control" value="<?php echo empty( $_POST['email'] ) ? '' : esc_attr( $_POST['email'] ); ?>" required="required">
		    </div><!-- /.form-group -->

		    <div class="form-group">
		        <label for="register-form-password"><?php echo __( 'Password', 'inventor' ); ?></label>
		        <input id="register-form-password" type="password" name="password" class="form-control" required="required">
		    </div><!-- /.form-group -->

		    <div class="form-group">
		        <label for="register-form-retype"><?php echo __( 'Retype Password', 'inventor' ); ?></label>
		        <input id="register-form-retype" type="password" name="password_retype" class="form-control" required="required">
		    </div><!-- /.form-group -->

			<?php do_action( 'inventor_register_form_fields_after' ); ?>

		    <?php $terms = get_theme_mod( 'inventor_general_terms_and_conditions_page', false ); ?>

		    <?php if ( ! empty( $terms ) ) : ?>
			    <div class="form-group terms-conditions-input">
			    	<div class="checkbox">
			    		<label for="register-form-conditions">
				        	<input id="register-form-conditions" type="checkbox" name="agree_terms" <?php if ( ! empty( $_POST['agree_terms'] ) ) echo 'checked'; ?>>
				            <?php echo sprintf( __( 'I agree with <a href="%s" target="_blank">terms & conditions</a>', 'inventor' ), get_permalink( $terms ) ); ?>
				        </label>
			        </div><!-- /.checkbox -->
			    </div><!-- /.form-group -->
		    <?php endif; ?>

			<?php if ( ! empty( $_POST['object_id'] ) && ! empty( $_POST['payment_type'] ) ) : ?>
				<input type="hidden" name="object_id" value="<?php echo esc_attr( $_POST['object_id'] ); ?>">
				<input type="hidden" name="payment_type" value="<?php echo esc_attr( $_POST['payment_type'] ); ?>">
			<?php endif; ?>

			<?php if ( class_exists( 'Inventor_Recaptcha' ) ) : ?>
				<?php if ( Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) : ?>
					<div id="recaptcha-<?php echo esc_attr( get_the_ID() ); ?>" class="g-recaptcha" data-sitekey="<?php echo get_theme_mod( 'inventor_recaptcha_site_key' ); ?>"></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php do_action( 'wordpress_social_login' ); ?>

		    <button type="submit" class="button" name="register_form"><?php echo __( 'Sign Up', 'inventor' ); ?></button>
		</form>
	<?php else : ?>
		<div class="alert alert-warning">
			<?php echo __( 'You are already logged in.', 'inventor' ); ?>
		</div><!-- /.alert -->
	<?php endif; ?>
<?php else: ?>
	<div class="alert alert-warning">
	    <?php echo __( 'Registrations are not allowed.', 'inventor' ); ?>
	</div><!-- /.alert -->
<?php endif; ?>