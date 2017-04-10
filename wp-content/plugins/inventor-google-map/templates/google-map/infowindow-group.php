<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( have_posts() ) : ?>
	<div class="infobox multiple">
		<div class="infobox-inner">
			<?php if ( is_array( $group ) ) : ?>
				<?php foreach ( $group as $id ) : ?>
					<div class="infobox-item">
						<?php $image_url = wp_get_attachment_url( get_post_thumbnail_id( $id ) ); ?>
						<div class="infobox-item-image" <?php if ( ! empty( $image_url ) ) : ?>style="background-image: url('<?php echo esc_attr( $image_url ); ?>');"<?php else : ?>style="background-image: url('<?php echo plugins_url('inventor'); ?>/assets/img/default-item.png');"<?php endif; ?>>
							<a href="<?php echo get_the_permalink( $id ); ?>"></a>
						</div>

						<div class="infobox-item-title">
							<a href="<?php echo get_the_permalink( $id ); ?>"><?php echo get_the_title( $id ); ?></a>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
