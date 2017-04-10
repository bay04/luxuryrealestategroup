<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $instance['per_row'] = ! empty( $instance['per_row'] ) ? $instance['per_row'] : 3; ?>

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

        <?php if ( have_posts() ) : ?>
            <div class="packages">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( Inventor_Packages_Logic::is_package_trial( get_the_ID() ) ): ?>
                        <?php continue; ?>
                    <?php endif; ?>

                    <div class="package">
                        <?php $payment_page_id = get_theme_mod( 'inventor_general_payment_page', false ); ?>
                        <?php $package_id = get_the_ID(); ?>
                        <?php $price = Inventor_Packages_Logic::get_package_price( get_the_ID() ); ?>
                        <?php $formatted_price = Inventor_Packages_Logic::get_package_formatted_price( get_the_ID() ); ?>

                        <h3 class="package-title">
                            <?php the_title(); ?>

                            <?php if ( ! empty( $package_id ) && ! empty( $payment_page_id ) ) : ?>
                                <form method="post" action="<?php echo get_permalink( $payment_page_id ); ?>">
                                    <input type="hidden" name="payment_type" value="package">
                                    <input type="hidden" name="object_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
                                    <button type="submit">
                                        <?php if ( ! empty( $price ) ) : ?>
                                            <?php echo __( 'Purchase', 'inventor-packages' ); ?>
                                        <?php else : ?>
                                            <?php echo __( 'Change', 'inventor-packages' ); ?>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </h3>

                        <?php if ( ! empty( $formatted_price ) ) : ?>
                            <div class="package-price">
                                <strong><?php echo __( 'Price', 'inventor-packages' ); ?>:</strong>
                                <span><?php echo esc_attr( $formatted_price ); ?></span>
                            </div><!-- /.package-price -->
                        <?php endif; ?>

                        <?php $duration = Inventor_Packages_Logic::get_package_duration( get_the_ID(), true )?>
                        <?php if ( ! empty( $duration ) ) : ?>
                            <div class="package-duration">
                                <strong><?php echo __( 'Duration', 'inventor-packages' ); ?>:</strong>
                                <span><?php echo esc_attr( $duration ); ?></span>
                            </div><!-- /.package-duration -->
                        <?php endif; ?>

                        <?php $max_listings = get_post_meta( get_the_ID(), INVENTOR_PACKAGE_PREFIX . 'max_listings' , true ); ?>
                        <?php if ( ! empty( $max_listings ) ) : ?>
                            <div class="package-max-listings">
                                <strong><?php echo __( 'Max Listings', 'inventor-packages' ); ?>:</strong>
							<span>
								<?php if ( '-1' == $max_listings ) : ?>
                                    <?php echo __( 'Unlimited', 'inventor-packages' ); ?>
                                <?php else : ?>
                                    <?php echo esc_attr( $max_listings ); ?>
                                <?php endif; ?>
							</span>
                            </div><!-- /.package-of-items -->
                        <?php endif; ?>
                    </div><!-- /.package -->
                <?php endwhile; ?>
            </div><!-- /.packages -->
        <?php else : ?>
            <div class="alert alert-warning">
                <?php echo __( 'No packages found.', 'inventor-packages' ); ?>
            </div><!-- /.alert -->
        <?php endif; ?>

    </div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>