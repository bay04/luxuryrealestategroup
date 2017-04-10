<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $id = get_the_author_meta( 'ID' ); ?>
<?php $image = Inventor_Post_Type_User::get_user_image( $id ); ?>
<?php $name = Inventor_Post_Type_User::get_full_name( $id ); ?>
<?php $email = get_user_meta( $id, INVENTOR_USER_PREFIX . 'general_email', true ); ?>
<?php $website = get_user_meta( $id, INVENTOR_USER_PREFIX . 'general_website', true ); ?>

<?php $social_networks = apply_filters( 'inventor_metabox_social_networks', array(), 'user' ); ?>
<?php
	$social = '';
	foreach( $social_networks as $key => $title ) {
		$field_id = INVENTOR_USER_PREFIX  . 'social_' . $key;

		if ( apply_filters( 'inventor_metabox_field_enabled', true, INVENTOR_USER_PREFIX . 'profile', $field_id, 'user' ) ) {
			$social_value = get_user_meta( $id, $field_id, true );

			if( ! empty( $social_value ) ) {
				$social_network_url = apply_filters( 'inventor_social_network_url', esc_attr( $social_value ), $key );
				$social .= '<a href="' . $social_network_url . '" target="_blank"><i class="fa fa-'. esc_attr( $key ) .'"></i></a>';
			}
		}
	}
?>

<?php if ( ! empty( $image ) || ! empty( $name ) || ! empty( $email ) || ! empty( $website ) || ! empty( $social ) ): ?>

	<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

	<div class="widget-inner
	<?php if ( ! empty( $instance['classes'] ) ) : ?><?php echo esc_attr( $instance['classes'] ); ?><?php endif; ?>
	<?php echo ( empty( $instance['padding_top'] ) ) ? '' : 'widget-pt' ; ?>
	<?php echo ( empty( $instance['padding_bottom'] ) ) ? '' : 'widget-pb' ; ?>"
		<?php if ( ! empty( $instance['background_color'] ) || ! empty( $instance['background_image'] ) ) : ?>
			style="
			<?php if ( ! empty( $instance['background_color'] ) ) : ?>
				background-color: <?php echo esc_attr( $instance['background_color'] ); ?>;
		<?php endif; ?>
			<?php if ( ! empty( $instance['background_image'] ) ) : ?>
				background-image: url('<?php echo esc_attr( $instance['background_image'] ); ?>');
			<?php endif; ?>"
		<?php endif; ?>>

		<?php if ( ! empty( $instance['title'] ) ) : ?>
			<?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
			<?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
			<?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
		<?php endif; ?>

		<div class="listing-author">
			<?php if ( ! empty( $image ) ) : ?>
				<a href="<?php echo get_author_posts_url( $id ); ?>" class="listing-author-image" data-background-image="<?php echo esc_attr( $image ); ?>">
					<img src="<?php echo esc_attr( $image ); ?>" alt="">
				</a><!-- /.listing-author-image -->
			<?php endif; ?>

			<?php if ( ! empty( $name ) ) : ?>
				<div class="listing-author-name">
					<a href="<?php echo get_author_posts_url( $id ); ?>">
						<?php echo esc_attr( $name ) ; ?>
					</a>
				</div><!-- /.listing-author-name -->
			<?php endif; ?>

			<?php if ( ! empty( $website ) || ! empty( $email ) ) : ?>
				<div class="listing-author-contact">
					<?php if ( ! empty( $website ) ):  ?>
						<?php if ( strpos( $website, 'http' ) !== 0 ) $website = sprintf( 'http://%s', $website ); ?>
						<a href="<?php echo esc_attr( $website ); ?>" target="_blank"><?php echo __( 'Website', 'inventor' ); ?></a>
					<?php endif; ?>

					<?php if ( ! empty( $email ) ) : ?>
						<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo __( 'Message', 'inventor' ); ?></a>
					<?php endif; ?>
				</div><!-- /.listing-author-contact -->
			<?php endif; ?>

			<?php if ( ! empty( $social ) ) : ?>
				<div class="listing-author-social">
					<?php echo $social; ?>
				</div><!-- /.listing-author-social -->
			<?php endif; ?>
		</div><!-- /.listing-author -->
	</div><!-- /.widget-inner -->

	<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>