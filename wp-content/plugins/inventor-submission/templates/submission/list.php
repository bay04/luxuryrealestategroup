<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $create_page_id = get_theme_mod( 'inventor_submission_create_page', null ); ?>

<?php if ( ! empty( $create_page_id ) ) : ?>
	<?php if ( Inventor_Submission_Logic::is_allowed_to_add_submission( get_current_user_id() ) ) :   ?>
		<a href="<?php echo get_permalink( $create_page_id ); ?>" class="listing-create"><?php echo __( 'Create listing', 'inventor-submission' ); ?></a>
	<?php endif; ?>
<?php endif; ?>

<?php $number_of_user_listings = Inventor_Query::get_listings_by_user( get_current_user_id(), 'any', null, true ); ?>

<?php $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; ?>
<?php $listing_status = empty( $_GET['listing-status'] ) ? 'any' : $_GET['listing-status']; ?>
<?php $post_type = empty( $_GET['listing-type'] ) ? Inventor_Post_Types::get_listing_post_types() : $_GET['listing-type']; ?>
<?php query_posts( array(
    'post_type'     => $post_type,
	'post_status'   => $listing_status,
	'paged'         => $paged,
	'author'        => get_current_user_id(),
) ); ?>

<?php if ( $number_of_user_listings > 0 ) : ?>
	<div class="listings-system-legend">
		<a class="published" href="?listing-status=published"><?php echo esc_attr__( 'Listing published', 'inventor-submission' ); ?></a>
		<a class="in-review" href="?listing-status=pending"><?php echo esc_attr__( 'Waiting for review', 'inventor-submission' ); ?></a>
		<a class="disabled" href="?listing-status=draft"><?php echo esc_attr__( 'Listing disabled', 'inventor-submission' ); ?></a>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="listings-system">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="listing-system">
					<div class="listing-system-row">
						<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
						<div class="listing-system-row-image">
							<a href="<?php the_permalink(); ?>" style="background-image: url('<?php if ( has_post_thumbnail() ) : ?><?php echo esc_attr( $image[0] ); ?><?php else : ?><?php echo plugins_url( 'inventor' ); ?>/assets/img/default-item.png<?php endif; ?>')">
								<?php if ( get_post_status() == 'pending' ) : ?>
									<div class="ribbon warning">
										<?php echo esc_attr__( 'Pending', 'inventor-submission' ); ?>
									</div><!-- /.ribbon -->
								<?php elseif ( get_post_status() == 'publish' ) : ?>
									<div class="ribbon publish">
										<?php echo esc_attr__( 'Published', 'inventor-submission' ); ?>
									</div><!-- /.ribbon -->
								<?php elseif ( get_post_status() == 'draft' ) : ?>
									<div class="ribbon draft">
										<?php echo esc_attr__( 'Disabled', 'inventor-submission' ); ?>
									</div><!-- /.ribbon -->
								<?php endif; ?>
							</a>
						</div><!-- /.listing-system-row-image -->

						<div class="listing-system-row-info">
							<div class="listing-system-row-title">
								<a href="<?php the_permalink(); ?>"><?php echo Inventor_Utilities::excerpt( get_the_title(), 50 ); ?></a>
							</div><!-- /.listing-system-row-title -->

							<?php $post_type = get_post_type(); ?>
							<?php $listing_type = Inventor_Post_Types::get_listing_type_name(); ?>

							<?php if ( ! empty( $listing_type ) ) : ?>
								<div class="listing-system-row-listing-type <?php echo $post_type; ?>">
									<?php $post_type_object = get_post_type_object( $post_type ); ?>
									<?php $icon = Inventor_Post_Type_Listing::get_icon( get_the_ID(), true ); ?>

									<?php if ( ! empty( $icon ) ) : ?>
										<?php echo $icon; ?>
									<?php endif; ?>

									<?php echo wp_kses( $listing_type, wp_kses_allowed_html( 'post' ) ); ?>
								</div><!-- /.listing-system-row-listing-type -->
							<?php endif; ?>

							<?php $location = Inventor_Query::get_listing_location_name(); ?>
							<?php if ( ! empty( $location ) ) : ?>
								<div class="listing-system-row-location">
									<?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
								</div><!-- /.listing-system-row-location -->
							<?php endif; ?>

							<div class="listing-system-row-additional">
								<?php do_action( 'inventor_submission_list_row', get_the_ID() ); ?>
							</div><!-- /.listing-system-row-location -->
						</div><!-- /.listing-system-row-info -->

						<?php $payment_page_id = get_theme_mod( 'inventor_general_payment_page', null ); ?>
						<?php if ( ! empty( $payment_page_id ) ) : ?>

							<div class="listing-system-row-submission-actions">
								<!-- FEATURED -->
								<?php if ( ! Inventor_Post_Types::is_featured_listing( get_the_ID() ) ) : ?>
									<?php $price = Inventor_Submission_Logic::payment_price_value( null, 'featured_listing', get_the_ID() ); ?>

									<?php if ( ! empty( $price ) ) : ?>
										<form method="post" action="<?php echo get_permalink( $payment_page_id ); ?>">
											<input type="hidden" name="payment_type" value="featured_listing">
											<input type="hidden" name="object_id" value="<?php the_ID(); ?>">

											<button type="submit">
												<?php echo __( 'Make featured', 'inventor-submission' ); ?> <span class="label label-primary"><?php echo Inventor_Price::format_price( $price ); ?></span>
											</button>
										</form>
									<?php endif; ?>
								<?php else : ?>
									<button class="disabled">
										<?php echo __( 'Featured', 'inventor-submission' ); ?>
									</button>
								<?php endif; ?>

								<!-- PAY PER POST -->
								<?php $submission_type = get_theme_mod( 'inventor_submission_type', false ); ?>
								<?php if ( 'pay-per-post' == $submission_type ) : ?>

									<?php $status = get_post_status(); ?>
									<?php if ( 'publish' == $status ) : ?>

										<!-- PUBLISHED -->
										<button class="disabled">
											<?php echo __( 'Published', 'inventor-submission' ); ?>
										</button>

									<?php elseif ( 'pending' == $status ) : ?>

										<!-- PENDING -->
										<button class="disabled">
											<?php echo __( 'Pending', 'inventor-submission' ); ?>
										</button>

									<?php else : ?>

										<?php $price = Inventor_Submission_Logic::payment_price_value( null, 'publish_listing', get_the_ID() ); ?>
										<?php if ( ! empty( $price ) ) : ?>
											<form method="post" action="<?php echo get_permalink( $payment_page_id ); ?>">
												<input type="hidden" name="payment_type" value="publish_listing">
												<input type="hidden" name="object_id" value="<?php the_ID(); ?>">

												<button type="submit">
													<?php echo __( 'Publish', 'inventor-submission' ); ?> <span class="label label-primary"><?php echo Inventor_Price::format_price( $price ); ?></span>
												</button>
											</form>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
							</div><!-- /.listing-system-row-actions-submission -->
						<?php endif; ?>

						<div class="listing-system-row-actions">
							<?php $edit_page_id = get_theme_mod( 'inventor_submission_edit_page', null ); ?>
							<?php $remove_page_id = get_theme_mod( 'inventor_submission_remove_page', null ); ?>

							<?php if ( ! empty( $edit_page_id ) ) : ?>
								<a href="<?php echo get_permalink( $edit_page_id ); ?>?type=<?php echo get_post_type(); ?>&id=<?php the_ID(); ?>" class="listing-table-action">
									<i class="fa fa-pencil"></i> <?php echo __( 'Edit', 'inventor-submission' ); ?>
								</a>
							<?php endif; ?>

							<?php if ( ! empty( $remove_page_id ) ) : ?>
								<a href="<?php echo get_permalink( $remove_page_id ); ?>?id=<?php the_ID(); ?>" class="listing-table-action listing-button-delete">
									<i class="fa fa-trash"></i> <?php echo __( 'Remove', 'inventor-submission' ); ?>
								</a>
							<?php endif; ?>

							<?php do_action( 'inventor_submission_list_row_actions', get_the_ID() ); ?>
						</div><!-- /.listing-system-row-actions -->
					</div><!-- /.listing-system-row -->
				</div><!-- /.listing-system -->
			<?php endwhile; ?>
		</div><!-- /.listing-system -->

		<?php the_posts_pagination( array(
			'prev_text'          => __( 'Previous page', 'inventor-submission' ),
			'next_text'          => __( 'Next page', 'inventor-submission' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'inventor-submission' ) . ' </span>',
		) ); ?>

		<?php wp_reset_query(); ?>

	<?php else : ?>
		<div class="alert alert-warning">
			<?php echo __( 'No listings found.', 'inventor-submission' ); ?>
		</div>
	<?php endif; ?>

<?php else: ?>
	<div class="alert alert-warning">
		<?php echo __( 'You don\'t have any listings, yet. Start by creating new one.', 'inventor-submission' ); ?>
	</div>
<?php endif; ?>