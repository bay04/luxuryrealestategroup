<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="alert alert-danger">
    <?php echo esc_attr__( 'Object does not exist.', 'inventor' ); ?>

    <?php if ( ! empty( $message ) ) : ?>
        <?php echo $message;  ?>
    <?php endif; ?>
</div><!-- /.alert -->