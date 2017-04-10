<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! is_user_logged_in() ) : ?>
    <form class="reset-form" action="<?php echo wp_lostpassword_url(); ?>" method="post">
    	<div class="form-group">
    		<label for="reset-form-username" ><?php echo esc_attr__( 'Username or E-mail:', 'inventor' ); ?></label>
    		<input type="text" name="user_login" id="reset-form-username" class="input" size="20">
    	</div><!-- /.form-group -->

        <button type="submit" class="button" name="reset_form"><?php echo esc_attr__( 'Get New Password', 'inventor' ); ?></button>
    </form>
<?php else: ?>
	<div class="alert alert-warning">
		<?php echo __( 'You are already logged in.', 'inventor' ); ?>
	</div><!-- /.alert -->
<?php endif; ?>
