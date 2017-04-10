<?php
/**
 * Template file
 *
 * @package Superlist
 * @subpackage Templates
 */

?>

<div class="action-bar">
	<div class="action-bar-content">
		<div class="action-bar-chapter">
			<strong><?php echo esc_attr__( 'Choose Page Layout', 'superlist' ); ?></strong>

			<ul>
				<li><a href="#" data-action="layout-wide" class="active"><?php echo esc_attr__( 'Wide', 'superlist' ); ?></a></li>
				<li><a href="#" data-action="layout-boxed"><?php echo esc_attr__( 'Boxed', 'superlist' ); ?></a></li>
			</ul>
		</div><!-- /.action-bar-chapter -->

		<div class="action-bar-chapter">
			<strong><?php echo esc_attr__( 'Header Position', 'superlist' ); ?></strong>

			<ul>
				<li><a href="#" data-action="header-default"><?php echo esc_attr__( 'Fixed', 'superlist' ); ?></a></li>
				<li><a href="#" data-action="header-sticky" class="active"><?php echo esc_attr__( 'Sticky', 'superlist' ); ?></a></li>
			</ul>
		</div><!-- /.action-bar-chapter -->

		<div class="action-bar-chapter">
			<strong><?php echo esc_attr__( 'Submenu Style', 'superlist' ); ?></strong>

			<ul>
				<li><a href="#" data-action="submenu-dark" class="active"><?php echo esc_attr__( 'Dark', 'superlist' ); ?></a></li>
				<li><a href="#" data-action="submenu-light"><?php echo esc_attr__( 'Light', 'superlist' ); ?></a></li>
			</ul>
		</div><!-- /.action-bar-chapter -->

		<div class="action-bar-chapter">
			<strong><?php echo esc_attr__( 'Color combination', 'superlist' ); ?></strong>

			<table>
				<tbody>
					<tr>
						<td class="color-style"><a class="color-style-background-blue-light" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-blue-light.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Blue Light', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-blue" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-blue.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Blue', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-blue-dark" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-blue-dark.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Blue Dark', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-brown" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-brown.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Brown', 'superlist' ); ?></a></td>
					</tr>

					<tr>
						<td class="color-style"><a class="color-style-background-green" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-green.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Green', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-green-dark" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-green-dark.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Green Dark', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-magenta" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-magenta.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Magenta', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-orange" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-orange.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Orange', 'superlist' ); ?></a></td>
					</tr>

					<tr>
						<td class="color-style"><a class="color-style-background-purple" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-purple.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Purple', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-mint active" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-mint.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Red', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-red" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-red.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Red', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-turquoise" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-turquoise.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Turquoise', 'superlist' ); ?></a></td>
					</tr>

					<tr>
						<td class="color-style"><a class="color-style-background-lime" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-lime.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Lime', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-pink" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-pink.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Pink', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-blue-gray" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-blue-gray.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Blue Gray', 'superlist' ); ?></a></td>
						<td class="color-style"><a class="color-style-background-purple-dark" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/css/superlist-purple-dark.css?ver=<?php echo VERSION ?>"><?php echo esc_attr__( 'Purple Dark', 'superlist' ); ?></a></td>
					</tr>
				</tbody>
			</table>
		</div><!-- /.action-bar-chapter -->
	</div><!-- /.action-bar-content -->

	<div class="action-bar-title"><i class="fa fa-wrench"></i></div><!-- /.action-bar-title -->
</div>
