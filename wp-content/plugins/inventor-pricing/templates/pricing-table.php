<?php $formatted_price = Inventor_Pricing_Logic::get_pricing_formatted_price( get_the_ID() ); ?>
<?php $description = get_post_meta( get_the_ID(), INVENTOR_PRICING_PREFIX . 'description', true ); ?>
<?php $table_items = get_post_meta( get_the_ID(), INVENTOR_PRICING_PREFIX . 'items', true ); ?>
<?php $table_items = apply_filters( 'inventor_pricing_table_items', $table_items, get_the_ID() ); ?>
<?php $button_text = get_post_meta( get_the_ID(), INVENTOR_PRICING_PREFIX . 'button_text', true ); ?>
<?php $button_url = get_post_meta( get_the_ID(), INVENTOR_PRICING_PREFIX . 'button_url', true ); ?>
<?php $highlighted = get_post_meta( get_the_ID(), INVENTOR_PRICING_PREFIX . 'highlighted', true ); ?>
<?php $package = get_post_meta( get_the_ID(), INVENTOR_PRICING_PREFIX . 'package', true ); ?>

<div class="pricing-container">
    <div class="pricing-inner <?php if ( $highlighted ) : ?>highlighted<?php endif; ?>">

        <div class="pricing-header">

            <?php if( get_the_title() ) : ?>
                <h2 class="pricing-title"><?php the_title(); ?></h2>
            <?php endif; ?>

            <?php if( ! empty( $description ) ) : ?>
                <h5 class="pricing-description"><?php echo esc_attr( $description ); ?></h5>
            <?php endif; ?>

            <?php if( ! empty( $formatted_price ) ) : ?>
                <h3 class="pricing-price"><?php echo wp_kses( $formatted_price, wp_kses_allowed_html( 'post' ) ); ?></h3>
            <?php endif; ?>

        </div><!-- /.pricing-header -->

        <?php if( is_array( $table_items ) && ! empty( $table_items ) ) : ?>
            <ul class="pricing-list">
                <?php foreach ( $table_items as $table_item ) : ?>
                    <li><?php echo wp_kses( $table_item, wp_kses_allowed_html( 'post' ) ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php $payment_page_id = get_theme_mod( 'inventor_general_payment_page', false ); ?>

        <?php if ( ! empty( $package ) && ! empty( $payment_page_id ) && class_exists( 'Inventor_Packages' ) && ! Inventor_Packages_Logic::is_package_trial( $package ) ) : ?>
            <form method="post" action="<?php echo get_permalink( $payment_page_id ); ?>">
                <input type="hidden" name="payment_type" value="package">
                <input type="hidden" name="object_id" value="<?php echo esc_attr( $package ); ?>">

                <button type="submit"><?php echo esc_attr( $button_text ); ?></button>
            </form>
        <?php elseif ( ! empty ( $button_text ) ) : ?>
            <a href="<?php echo esc_attr( $button_url ); ?>" class="btn btn-primary">
                <?php echo esc_attr( $button_text ); ?>
            </a>
        <?php endif; ?>

    </div><!-- /.pricing-inner -->
</div><!-- /.pricing-container -->