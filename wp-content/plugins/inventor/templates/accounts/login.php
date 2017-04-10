<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! is_user_logged_in() ) : ?>
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="login-form">
	    <div class="form-group">
	        <label for="login-form-username"><?php echo __( 'Username', 'inventor' ); ?></label>
	        <input id="login-form-username" type="text" name="login" class="form-control" required="required">
	    </div><!-- /.form-group -->

	    <div class="form-group">
	        <label for="login-form-password"><?php echo __( 'Password', 'inventor' ); ?></label>
	        <input id="login-form-password" type="password" name="password" class="form-control" required="required">
	    </div><!-- /.form-group -->

		<?php do_action( 'wordpress_social_login' ); ?>

		<?php if ( ! empty( $_POST['object_id'] ) && ! empty( $_POST['payment_type'] ) ) : ?>
			<input type="hidden" name="object_id" value="<?php echo esc_attr( $_POST['object_id'] ); ?>">
			<input type="hidden" name="payment_type" value="<?php echo esc_attr( $_POST['payment_type'] ); ?>">
		<?php endif; ?>

		<button type="submit" name="login_form" class="button"><?php echo __( 'Log in', 'inventor' ); ?></button>

		<div class="extra-actions">
			<?php
			$reset_password_page = get_theme_mod( 'inventor_general_reset_password_page', null );
			if ( ! empty( $reset_password_page ) ) {
				echo '<a href="'. get_permalink( $reset_password_page ) .'" class="forgotten-password">'. __( "I've forgotten my password.", 'inventor' ) .'</a>';
			}
			?>
		</div>
	</form>
<?php else: ?>
	<div class="alert alert-warning">
		<?php echo __( 'You are already logged in.', 'inventor' ); ?>
	</div><!-- /.alert -->
<?php endif; ?>