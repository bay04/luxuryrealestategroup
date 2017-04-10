<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php if ( ! empty( $name ) ) : ?>
    <strong><?php echo __( 'Name', 'inventor-jobs' ); ?>: </strong> <?php echo esc_attr( $name ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $email ) ) : ?>
    <strong><?php echo __( 'E-mail', 'inventor-jobs' ); ?>: </strong> <?php echo esc_attr( $email ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $phone ) ) : ?>
    <strong><?php echo __( 'Job', 'inventor-jobs' ); ?>: </strong> <?php echo esc_attr( $job ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $phone ) ) : ?>
    <strong><?php echo __( 'Resume', 'inventor-jobs' ); ?>: </strong> <?php echo esc_attr( $resume ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $url ) ) : ?>
    <strong><?php echo __( 'URL', 'inventor-jobs' ); ?>: </strong> <?php echo esc_attr( $url ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $message ) ) : ?>
    <?php echo esc_html( $message ); ?>
<?php endif; ?>