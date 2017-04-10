<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

    <div class="package-info-wrapper">
        <?php $current_package = Inventor_Packages_Logic::get_package_for_user( get_current_user_id() ); ?>

        <?php if ( empty( $current_package ) ) : ?>
            <?php if ( get_theme_mod( 'inventor_submission_type', 'free' ) == 'packages' ) :   ?>
                <p class="package-info">
                    <?php echo __( 'Site is using packages. Before you can post listing, please upgrade your package.', 'inventor-packages' ); ?>
                </p>
            <?php else: ?>
                <p class="package-info">
                    <?php echo __( "You don't have any package.", 'inventor-packages' ); ?>
                </p>
            <?php endif; ?>
        <?php else : ?>
            <div class="package-info">
                <p><?php echo sprintf( __( 'You are using <strong>%s</strong> package.', 'inventor-packages' ), esc_attr( $current_package->post_title ) ); ?></p>

                <?php $date = Inventor_Packages_Logic::get_package_valid_date_for_user( get_current_user_id() ); ?>
                <?php if ( Inventor_Packages_Logic::is_package_valid_for_user( get_current_user_id() ) ) : ?>

                    <?php if ( $date ): ?>
                        <p>
                            <?php echo sprintf( __( 'Your membership is valid until <strong>%s</strong>.', 'inventor-packages' ), esc_attr( $date ) ); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( get_theme_mod( 'inventor_submission_type', 'free' ) == 'packages' ) :   ?>
                        <p>
                            <?php $remaining = Inventor_Packages_Logic::get_remaining_listings_count_for_user( get_current_user_id() ); ?>

                            <?php if ( 'unlimited' === $remaining ) : ?>
                                <?php echo __( 'You can add <strong>unlimited</strong> amount of items', 'inventor-packages' ); ?>
                            <?php elseif ( (int) $remaining < 0 ) :   ?>
                                <?php echo sprintf( __( 'You can not add new listings because you spent all of your available listings. Change your package. First <strong>%s</strong> items has been disabled from listing.', 'inventor-packages' ), esc_attr( abs( $remaining ) ) ); ?>
                            <?php else : ?>
                                <?php echo sprintf( __( 'You can add <strong>%s</strong> items.', 'inventor-packages' ), esc_attr( $remaining ) ); ?>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                <?php else : ?>
                    <p>
                        <?php echo sprintf( __( 'Your membership already expired at <strong>%s</strong>.', 'inventor-packages' ), $date ); ?>
                        <?php if ( get_theme_mod( 'inventor_submission_type', 'free' ) == 'packages' ) :   ?>
                            <?php echo sprintf ( __( 'All your items has been deactivated until you pay for new membership.', 'inventor-packages' ), $date ); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div><!-- /.package-info -->
        <?php endif; ?>

        <?php $packages = Inventor_Packages_Logic::get_packages_choices(); ?>
        <?php $payment_page_id = get_theme_mod( 'inventor_general_payment_page', false ); ?>

        <?php if ( ! empty( $packages ) && ! empty( $payment_page_id ) ) : ?>
            <form method="post" action="<?php echo esc_attr( get_permalink( $payment_page_id ) ); ?>">
                <input type="hidden" name="payment_type" value="package">

                <div class="form-group">
                    <select name="object_id">
                        <option value=""><?php echo __( 'Select Package', 'inventor-packages' ); ?></option>

                        <?php foreach ( $packages as $package_id => $package_title ) : ?>
                            <option value="<?php echo esc_attr( $package_id ); ?>" <?php if ( ! empty( $current_package->ID ) && $current_package->ID == $package_id ) : ?>selected="selected"<?php endif; ?>>
                                <?php echo esc_attr( Inventor_Packages_Logic::get_package_title( $package_id, true ) ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div><!-- /.form-group -->

                <button type="submit" class="btn btn-primary btn-block" name="change-package"><?php echo __( 'Change', 'inventor-packages' ); ?></button>
            </form>
        <?php endif; ?>

    </div><!-- /.package-info-wrapper -->
