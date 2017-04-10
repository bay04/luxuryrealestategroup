<?php if ( apply_filters( 'inventor_metabox_allowed', true, 'reviews', get_the_author_meta('ID') ) ): ?>
    <?php if ( comments_open() || get_comments_number() ): ?>
        <?php comments_template( '', true ); ?>
    <?php endif; ?>
<?php endif; ?>