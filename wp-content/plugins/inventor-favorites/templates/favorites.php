<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $create_collection_page_id = get_theme_mod( 'inventor_favorites_create_collection_page', null ); ?>

<?php if ( ! empty( $create_collection_page_id ) ) : ?>
    <a href="<?php echo get_permalink( $create_collection_page_id ); ?>" class="btn-create-collection"><?php echo __( 'Create collection', 'inventor-favorites' ); ?></a>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
    <div class="listings-row">

    <?php while ( have_posts() ) : the_post(); ?>
        <div class="listing-container">
            <?php echo Inventor_Template_Loader::load( 'listings/row' ); ?>
        </div><!-- /.listing-container -->
    <?php endwhile; ?>

    </div><!-- /.listing-row -->

    <?php the_posts_pagination( array(
        'prev_text' => __( 'Previous', 'inventor-favorites' ),
        'next_text' => __( 'Next', 'inventor-favorites' ),
        'mid_size'  => 2,
    ) ); ?>
<?php else : ?>
    <div class="alert alert-info">
        <?php if ( is_user_logged_in() ): ?>
            <?php echo __( "You don't have any favorite listings, yet. Start by adding some.", 'inventor-favorites' ); ?>
        <?php else: ?>
            <?php echo __( 'You need to log in at first.', 'inventor-favorites' ); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>