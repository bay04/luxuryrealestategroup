<?php $collections = Inventor_Favorites_Logic::get_user_collections(); ?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php if ( ! empty( $instance['title'] ) ) : ?>
    <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
    <?php echo esc_attr( $instance['title'] ); ?>
    <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>

<?php if ( count( $collections ) > 0 ) : ?>
    <?php $favorites_config = Inventor_Favorites_Logic::get_config(); ?>
    <?php $favorites_page_id = $favorites_config['favorites_page']; ?>

    <ul class="collections">
        <?php foreach ( $collections as $collection_id => $collection_data ): ?>
            <?php $collection_title = $collection_data['title']; ?>
                <?php $collection_listings = $collection_data['listings']; ?>
            <li>
                <a href="<?php if ( ! empty( $favorites_page_id ) ) : ?><?php echo get_the_permalink( $favorites_page_id ) ?><?php endif; ?>?collection-id=<?php echo esc_attr( $collection_id ); ?>"><?php echo esc_attr( $collection_title ); ?></a>
                <span <?php if ( count( $collection_listings ) > 0 ) : ?>class="non-empty"<?php endif; ?>><?php echo count( $collection_listings ); ?></span>
            </li>
        <?php endforeach; ?>
    </ul><!-- /.collections -->
<?php else : ?>
    <div class="alert alert-warning">
        <?php if ( is_user_logged_in() ): ?>
            <?php echo __( "You haven't created any collections yet.", 'inventor-favorites' ); ?>
        <?php else: ?>
            <?php echo __( 'You need to log in at first.', 'inventor-favorites' ); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>