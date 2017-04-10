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
    <div class="user-card">
        <?php if ( ! empty( $image ) ) : ?>
            <div class="user-card-image" data-background-image="<?php echo esc_attr( $image ); ?>">
                <a href="<?php echo get_author_posts_url( $id ); ?>">
                    <img src="<?php echo esc_attr( $image ); ?>" alt="">
                </a>
            </div><!-- /.user-card-image -->
        <?php endif; ?>

        <div class="user-card-content">
            <div class="user-card-title">
                <span class="user-card-listings-count">
                    <?php printf( _n( '%d listing', '%d listings', count( $user_listings ), 'inventor' ), count( $user_listings ) ); ?>
                </span>

                <h3 class="user-card-name">
                    <a href="<?php echo get_author_posts_url( $id ); ?>">
                        <?php if ( ! empty( $name ) ) : ?>
                            <?php echo esc_attr( $name ) ; ?>
                        <?php endif; ?>
                    </a>
                </h3><!-- /.user-card-name -->
            </div><!-- /.user-card-title -->

            <dl>
                <?php if ( ! empty( $email ) ) : ?>
                    <dt class="user-card-email"><?php echo __( 'E-mail', 'inventor' ); ?></dt>
                    <dd>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ) ; ?></a>
                    </dd>
                <?php endif; ?>

                <?php if ( ! empty( $phone ) ) : ?>
                    <dt class="user-card-phone"><?php echo __( 'Phone', 'inventor' ); ?></dt>
                    <dd>
                        <a href="tel:<?php echo esc_attr( str_replace(' ', '', $phone) ); ?>"><?php echo esc_attr( $phone ); ?></a>
                    </dd>
                <?php endif; ?>

                <?php if ( ! empty( $website ) ) : ?>
                    <dt class="user-card-website"><?php echo __( 'Website', 'inventor' ); ?></dt>
                    <dd>
                        <a href="<?php echo esc_attr( $website ); ?>" target="_blank"><?php echo esc_attr( $website ) ; ?></a>
                    </dd>
                <?php endif; ?>
            </dl>
        </div><!-- /.user-card-content -->
    </div><!-- /.user-card-->
</div><!-- /.user-container-->