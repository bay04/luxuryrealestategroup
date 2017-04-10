<?php if ( class_exists( 'Inventor_Post_Types' ) ) : ?>
    <div class="header-post-types">
        <div class="container">
            <?php $post_types = apply_filters( 'inventor_submission_allowed_listing_post_types', Inventor_Post_Types::get_listing_post_types() ); ?>
            <?php $page_id = get_theme_mod( 'inventor_submission_create_page' ); ?>
            <?php $page_permalink = get_permalink( $page_id ); ?>

            <?php if ( ! empty( $post_types ) ) : ?>
                <ul>
                    <?php foreach ( $post_types as $post_type ) : ?>
                        <li>
                            <a href="<?php echo esc_attr( $page_permalink ); ?>?type=<?php echo esc_attr( $post_type ); ?>">
                                <?php echo esc_attr( get_post_type_object( $post_type )->labels->singular_name ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div><!-- /.container -->
    </div><!-- /.header-post-types -->
<?php endif; ?>