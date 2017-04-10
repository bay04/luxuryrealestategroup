<?php $id = $user->ID; ?>
<?php $image = Inventor_Post_Type_User::get_user_image( $id );?>
<?php $name = Inventor_Post_Type_User::get_full_name( $id ); ?>
<?php $phone = get_user_meta( $id, INVENTOR_USER_PREFIX . 'general_phone', true ); ?>
<?php $email = get_user_meta( $id, INVENTOR_USER_PREFIX . 'general_email', true ); ?>
<?php $website = get_user_meta( $id, INVENTOR_USER_PREFIX . 'general_website', true ); ?>
<?php $social_facebook = get_user_meta( $id, INVENTOR_USER_PREFIX . 'social_facebook', true ); ?>
<?php $social_twitter = get_user_meta( $id, INVENTOR_USER_PREFIX . 'social_twitter', true ); ?>
<?php $social_linkedin = get_user_meta( $id, INVENTOR_USER_PREFIX . 'social_linkedin', true ); ?>
<?php $user_listings_query = Inventor_Query::get_listings_by_user( $user->ID, 'publish' ); ?>
<?php $user_listings = $user_listings_query->posts; ?>

<div class="user-container">
    <div class="user-small">
        <?php if ( ! empty( $image ) ) : ?>
            <div class="user-small-image" data-background-image="<?php echo esc_attr( $image ); ?>">
                <a href="<?php echo get_author_posts_url( $id ); ?>">
                    <img src="<?php echo esc_attr( $image ); ?>" alt="">
                </a>
            </div><!-- /.user-small-image -->
        <?php endif; ?>

        <div class="user-small-content">
            <div class="user-small-title">
                <span class="user-small-listings-count">
                    <?php printf( _n( '%d listing', '%d listings', count( $user_listings ), 'inventor' ), count( $user_listings ) ); ?>
                </span>

                <h3 class="user-small-name">
                    <a href="<?php echo get_author_posts_url( $id ); ?>">
                        <?php if ( ! empty( $name ) ) : ?>
                            <?php echo esc_attr( $name ) ; ?>
                        <?php endif; ?>
                    </a>
                </h3><!-- /.user-small-name -->
            </div><!-- /.user-small-title -->

            <?php if ( ! empty( $email ) ) : ?>
                <span class="user-small-email">
                    <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ) ; ?></a>
                </span>
            <?php endif; ?>

            <?php if ( ! empty( $phone ) ) : ?>
                <span class="user-small-phone">
                    <a href="tel:<?php echo esc_attr( str_replace(' ', '', $phone) ); ?>"><?php echo esc_attr( $phone ); ?></a>
                </span>
            <?php endif; ?>

            <?php if ( ! empty( $website ) ) : ?>
                <span class="user-small-website">
                    <a href="<?php echo esc_attr( $website ); ?>" target="_blank"><?php echo esc_attr( $website ) ; ?></a>
                </span>
            <?php endif; ?>
        </div><!-- /.user-small-content -->
    </div><!-- /.user-small-->
</div><!-- /.user-container-->