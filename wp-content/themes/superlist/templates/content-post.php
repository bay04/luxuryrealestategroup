<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */

?>

<div <?php post_class( 'post post-detail' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail(); ?>
    <?php endif; ?>

    <div class="post-meta clearfix">
        <div class="post-meta-author"><?php echo esc_attr__( 'By', 'superlist' ); ?> <?php the_author_posts_link(); ?></div><!-- /.post-meta-author -->
        <div class="post-meta-date"><?php the_date(); ?></div><!-- /.post-meta-date -->
        <?php if ( has_category() ) : ?>
            <div class="post-meta-categories"><i class="fa fa-tags"></i> <?php echo wp_kses( get_the_category_list( ', ' ), wp_kses_allowed_html( 'post' ) ); ?></div><!-- /.post-meta-categories -->
        <?php endif; ?>
        <?php if ( comments_open() ): ?>
            <div class="post-meta-comments"><i class="fa fa-comments"></i> <?php comments_number(); ?></div><!-- /.post-meta-comments -->
        <?php endif; ?>
    </div><!-- /.post-meta -->

    <?php $content = get_the_content(); ?>
    <?php if ( ! empty( $content ) ) : ?>
        <div class="post-content">
            <?php the_content(); ?>
        </div><!-- /.post-content -->
    <?php endif; ?>

    <?php
	wp_link_pages( array(
		'before'      => '<div class="pagination page-links"><span class="page-links-title">' . __( 'Post Pages:', 'superlist' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span class="page-numbers">',
		'link_after'  => '</span>',
	) );
	?>

    <?php if ( has_tag() ) : ?>
        <div class="post-meta-tags clearfix">
            <?php echo esc_attr__( 'Tags', 'superlist' ); ?>:
            <ul>
                <?php the_tags( '<li class="tag">', '</li><li class="tag">', '</li>' ); ?>
            </ul>
        </div><!-- /.post-meta -->
    <?php endif; ?>

    <?php if ( comments_open() || get_comments_number() ) :   ?>
        <?php comments_template( '', true ); ?>
    <?php endif; ?>

</div><!-- /.post -->
