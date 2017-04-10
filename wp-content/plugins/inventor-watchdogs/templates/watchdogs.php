<?php if ( have_posts() ) : ?>
    <div class="listings-row">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="listing-container">
                <?php echo Inventor_Template_Loader::load( 'watchdogs-row', array(), $plugin_dir = INVENTOR_WATCHDOGS_DIR ); ?>
            </div><!-- /.listing-container -->
        <?php endwhile; ?>
    </div><!-- /.listings-row -->

    <?php the_posts_pagination( array(
        'prev_text' => __( 'Previous', 'inventor-watchdogs' ),
        'next_text' => __( 'Next', 'inventor-watchdogs' ),
        'mid_size'  => 2,
    ) ); ?>
<?php else : ?>
    <div class="alert alert-warning">
        <?php if ( is_user_logged_in() ): ?>
            <?php echo __( "You don't have any watchdogs, yet. Start by adding some.", 'inventor-watchdogs' ); ?>
        <?php else: ?>
            <?php echo __( 'You need to log in at first.', 'inventor-watchdogs' ); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>