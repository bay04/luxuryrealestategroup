<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */

?>

<div <?php comment_class( empty( $args['has_children'] ) ? '' : 'comments' ); ?> id="comment-<?php comment_ID() ?>">
    <div class="comment">
        <div class="comment-image">
            <?php if ( 0 != $args['avatar_size']  ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
        </div><!-- /.comment-image -->

        <div class="comment-inner">
            <div class="comment-header">
                <h2><?php comment_author(); ?></h2>
                <span class="separator">&#8226;</span>
                <span class="comment-date"><?php echo get_comment_date(); ?></span>
                <?php comment_reply_link( array_merge( $args, array(
					'add_below'     => 'comment',
					'depth'         => $depth,
					'reply_text'    => '<i class="fa fa-reply"></i> ' . __( 'Reply', 'superlist' ),
					'max_depth'     => $args['max_depth'],
	            ) ) ); ?>

            </div><!-- /.comment-header -->

            <div class="comment-content-wrapper">
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- /.comment-content -->
            </div><!-- /.comment-content-wrapper -->

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <em class="comment-awaiting-moderation"><?php echo esc_attr__( 'Your comment is awaiting moderation.', 'superlist' ); ?></em>
                <br />
            <?php endif; ?>
        </div><!-- /.comment-content -->
    </div><!-- /.comment -->

