<?php global $post; ?>

<?php if ( ! empty( $post->post_content ) ) : ?>
	<div class="listing-detail-section" id="listing-detail-section-description">
	    <h2 class="page-header"><?php echo $section_title; ?></h2>
		<div class="listing-detail-description-wrapper">
	    	<?php the_content(); ?>
		</div>
	</div><!-- /.listing-detail-section -->
<?php endif; ?>