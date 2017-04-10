<?php
/**
 * The template for displaying comments
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

?>

<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				echo esc_attr( sprintf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'superlist' ), number_format_i18n( get_comments_number() ), get_the_title() ) );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                    <div class="nav-previous pull-left"><?php previous_comments_link( __( '&larr; Older Comments', 'superlist' ) ); ?></div>
                    <div class="nav-next pull-right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'superlist' ) ); ?></div>
                </nav><!-- /#comment-nav-above -->
		<?php endif; ?>

		<ul class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      	=> 'ul',
					'short_ping' 	=> true,
					'avatar_size'	=> 90,
					'callback'		=> 'superlist_comment',
				) );
			?>
		</ul><!-- /.comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<div class="nav-previous pull-left"><?php previous_comments_link( __( '&larr; Older Comments', 'superlist' ) ); ?></div>
				<div class="nav-next pull-right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'superlist' ) ); ?></div>
			</nav><!-- /#comment-nav-below -->
		<?php endif; ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php echo esc_attr__( 'Comments are closed.', 'superlist' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php comment_form( array(
		'comment_notes_after'   => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'superlist' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		'title_reply'   => __( 'Write a Comment', 'superlist' ),
		'class_submit'  => 'btn btn-primary btn-block',
		'comment_field' => '<div class="form-group"><label for="comment">' . __( 'Comment', 'superlist' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" class="form-control" cols="45" rows="5" aria-required="true"></textarea></div><!-- /.form-group -->',
		'fields'        => apply_filters( 'comment_form_default_fields', array(
				'author'    => '<div class="row"><div class="form-group col-sm-4"><label for="comment-author">' . __( 'Name', 'superlist' ) . ' <span class="required">*</span></label><input id="comment-author" type="text" required="required" class="form-control" name="author"></div><!-- /.form-group -->',
				'email'     => '<div class="form-group col-sm-4"><label for="comment-email">' . __( 'Email', 'superlist' ) . ' <span class="required">*</span></label><input id="comment-email" type="email" required="required" class="form-control" name="email"></div><!-- /.form-group -->',
				'url'       => '<div class="form-group col-sm-4"><label for="comment-website">' . __( 'Website', 'superlist' ) . '</label><input id="comment-website" type="url" class="form-control" name="website"></div><!-- /.form-group --></div><!-- /.row -->',
				)
		),
	    )); ?>
</div><!-- /#comments -->
