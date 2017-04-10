<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! empty( $name ) ) : ?>
	<strong><?php echo __( 'Name', 'inventor' ); ?>: </strong> <?php echo esc_attr( $name ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $email ) ) : ?>
	<strong><?php echo __( 'E-mail', 'inventor' ); ?>: </strong> <?php echo esc_attr( $email ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $phone ) ) : ?>
	<strong><?php echo __( 'Phone', 'inventor' ); ?>: </strong> <?php echo esc_attr( $phone ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $date ) ) : ?>
	<strong><?php echo __( 'Date', 'inventor' ); ?>: </strong> <?php echo esc_attr( $date ); ?><br><br>
<?php endif; ?>

<?php $permalink = get_permalink( $post->ID ); ?>
<?php if ( ! empty( $permalink ) ) : ?>
	<strong><?php echo __( 'URL', 'inventor' ); ?>: </strong> <?php echo esc_attr( $permalink ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $_POST['message'] ) ) : ?>
	<?php echo esc_html( $_POST['message'] ); ?>
<?php endif; ?>