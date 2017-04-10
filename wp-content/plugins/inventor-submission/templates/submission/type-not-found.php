<div class="submission-choose-type">
	<?php $post_types = apply_filters( 'inventor_submission_allowed_listing_post_types', Inventor_Post_Types::get_listing_post_types() ); ?>
	<?php $icons = apply_filters( 'inventor_poi_icons', array() ); ?>

	<?php if ( ! empty( $post_types ) ) : ?>
		<p>
			<?php echo __( 'Please define type of your submission', 'inventor-submission' ); ?>:
		</p>

		<ul>
			<?php $index = 0; ?>
			<?php foreach( $post_types as $post_type ) : ?>
				<?php $post_type_object = get_post_type_object( $post_type ); ?>

				<?php $icon = ! empty( $post_type_object->labels->icon ) && array_key_exists( $post_type_object->labels->icon, $icons ) ? $icons[ $post_type_object->labels->icon ] : null; ?>

				<li>
					<a href="?type=<?php echo esc_attr( $post_type );?><?php if ( ! empty( $_GET['id'] ) ) { echo esc_attr( '&id=' . $_GET['id'] ); }; ?>">
						<?php if ( ! empty( $icon ) ) : ?>
							<?php echo $icon; ?>
						<?php endif; ?>

						<?php echo esc_attr( $post_type_object->labels->singular_name ); ?>
					</a>
					<?php if ( count( $post_types ) != $index + 1 ) : ?>
						<span>,</span>
					<?php endif; ?>
				</li>
				<?php $index++; ?>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<?php echo __( "You don't have privilege to create any submission.", 'inventor-submission' ); ?>
	<?php endif; ?>
</div><!-- /.submission-choose-type -->
