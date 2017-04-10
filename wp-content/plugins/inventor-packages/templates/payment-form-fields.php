<?php if ( 'package' == $payment_type ) : ?>

    <?php if ( ! empty( $object_id ) ) : ?>

        <?php if ( Inventor_Packages_Logic::is_package_trial( $object_id ) ) : ?>

            <div class="payment-info">
                <?php echo __( 'Trial packages can only be used as a default package. They cannot be purchased or chosen.', 'inventor-packages' ); ?>
            </div><!-- /.payment-info -->

        <?php elseif ( Inventor_Packages_Logic::is_package_free( $object_id ) ) : ?>

            <input type="hidden" name="action" value="set_free_package">

            <button type="submit" name="process-payment" class="btn btn-primary payment-process">
                <?php echo __( 'Confirm', 'inventor-packages' ); ?>
            </button>

        <?php endif; ?>

    <?php else : ?>
        <div class="payment-info">
            <?php echo __( 'Missing package.', 'inventor-packages' ); ?>
        </div><!-- /.payment-info -->
    <?php endif; ?>

<?php endif; ?>