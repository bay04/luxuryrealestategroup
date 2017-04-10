<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="alert alert-warning">
	<?php if ( ! is_user_logged_in() ) : ?>
		<?php echo esc_attr__( 'You need to log in at first.', 'inventor' ); ?>
	<?php else: ?>
		<?php echo esc_attr__( 'You are not allowed to access this page.', 'inventor' ); ?>

		<?php if ( ! empty( $message ) ) : ?>
			<?php echo $message;  ?>
		<?php endif; ?>
	<?php endif; ?>
</div><!-- /.alert -->

<?php if ( ! is_user_logged_in() ) : ?>
	<div class="row">
		<div class="<?php echo get_option( 'users_can_register' ) ? 'col-md-6' : 'col-md-12'; ?>">
			<div class="login-form-wrapper">
				<h1 class="text-center"><?php echo __( 'Login', 'inventor' ); ?></h1>
				<?php echo Inventor_Shortcodes::login(); ?>
			</div>
		</div>

		<?php if ( get_option( 'users_can_register' ) ) : ?>
			<div class="<?php echo get_option( 'users_can_register' ) ? 'col-md-6' : 'col-md-12'; ?>">
				<div class="register-form-wrapper">
					<h1 class="text-center"><?php echo __( 'Register', 'inventor' ); ?></h1>
					<?php echo Inventor_Shortcodes::register(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>