<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';

?>

<?php $style = ! empty( $instance['style'] ) ? $instance['style'] : ''; ?>
<?php $style_slug = ! empty( $_GET['map-style'] ) ? $_GET['map-style'] : $style; ?>
<?php $input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels'; ?>
<?php $is_closed = Inventor_Google_Map_Widgets::is_closed( $args['widget_id'], $instance ); ?>
<?php $height = esc_attr( $instance['height'] ); ?>

<?php $post_type = get_query_var( 'post_type' ); ?>

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

	<div class="map-wrapper" >
		<div class="map-inner <?php if ( $is_closed ) : ?>closed<?php endif; ?>" <?php if ( $is_closed ) : ?>style="margin-top:-<?php echo $height; ?>"<?php endif; ?> data-height="<?php echo $height; ?>">
			<div class="map-google">
				<div class="map-google-inner" style="height: <?php echo $height; ?>">
					<?php $latitude = ! empty( $_GET['latitude'] ) ? $_GET['latitude'] : ( ! empty( $instance['latitude'] ) ? $instance['latitude'] : null ); ?>
					<?php $longitude = ! empty( $_GET['longitude'] ) ? $_GET['longitude'] : ( ! empty( $instance['longitude'] ) ? $instance['longitude'] : null ); ?>

					<div class="map" id="map"
					     data-transparent-marker-image="<?php echo plugins_url( 'inventor-google-map' ); ?>/assets/img/transparent-marker-image.png"
					     data-marker-style="<?php echo esc_attr( $instance['marker_style'] ); ?>"
					     data-max-pins="<?php echo esc_attr( $instance['max_pins'] ); ?>"
					     data-orderby="<?php echo esc_attr( $instance['orderby'] ); ?>"
						 <?php if ( ! empty( $latitude ) ) : ?>data-latitude="<?php echo esc_attr( $latitude ); ?>"<?php endif; ?>
						 <?php if ( ! empty( $longitude ) ) : ?>data-longitude="<?php echo esc_attr( $longitude ); ?>"<?php endif; ?>
						 data-grid-size="<?php echo esc_attr( $instance['grid_size'] ); ?>"
			             data-ajax-action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
			             <?php if ( ! empty( $instance['show_all_markers'] ) ) : ?>data-show-all-markers="on"<?php endif; ?>
			             <?php if ( ! empty( $instance['intercept_filter'] ) ) : ?>data-filter-query="<?php echo Inventor_Google_Map::get_current_filter_query_uri(); ?>"<?php endif; ?>
						 <?php if ( is_post_type_archive() && ! empty( $instance['intercept_post_type'] ) && ! empty( $post_type ) && ! is_array( $post_type ) ) : ?>data-post-type="<?php echo $post_type; ?>"<?php endif; ?>
						 <?php if ( is_singular() ) : ?>data-post-id="<?php echo get_the_ID(); ?>"<?php endif; ?>
			             <?php if ( is_tax() && ! empty( $instance['intercept_term'] ) ) : global $wp_query; ?>data-term-taxonomy="<?php echo $wp_query->queried_object->taxonomy; ?>" data-term="<?php echo $wp_query->queried_object->slug; ?>"<?php endif; ?>
					     data-geolocation="<?php if ( ! empty( $instance['geolocation'] ) && $instance['geolocation'] == 'on' ) : ?>true<?php else : ?>false<?php endif; ?>"
					     data-zoom="<?php echo esc_attr( $instance['zoom'] ); ?>"
						 data-fit-bounds="true"
						 data-styles='<?php echo Inventor_Google_Map_Styles::get_style( $style_slug ); ?>'>

						<i class="fa fa-spinner fa-spin"></i>
					</div><!-- /.map -->
				</div><!-- /.map-google-inner -->

				<?php if ( ! empty( $instance['show_toggle'] ) ) : ?>
					<div class="map-switch"><?php echo esc_attr__( 'Toggle Map', 'inventor-google-map' ); ?></div><!-- /.map-switch -->
				<?php endif; ?>
			</div><!-- /.map-google -->

			<?php if ( ! empty( $instance['filter'] ) || ! empty( $instance['map_types'] ) ||  ! empty( $instance['map_zoom'] ) || ! empty( $instance['map_geolocation'] ) ) : ?>
				<div class="map-content">
					<div class="container">
						<?php if ( ! empty( $instance['filter'] ) ) : ?>
							<div class="row">
								<?php include Inventor_Template_Loader::locate( 'widgets/filter-form' ); ?>
							</div><!-- /.row -->
						<?php endif; ?>

						<?php if ( ! empty( $instance['map_types'] ) ||  ! empty( $instance['map_zoom'] ) || ! empty( $instance['map_geolocation'] ) ) : ?>
							<div class="row">
								<div class="col-sm-12">
									<div class="map-actions">
										<?php if ( ! empty( $instance['map_types'] ) && $instance['map_types'] == 'on' ) : ?>
					                        <div class="map-actions-group">
						                        <a id="map-control-type-roadmap"><span><?php echo __( 'Roadmap', 'inventor-google-map' ); ?></span></a>
					                            <a id="map-control-type-terrain"><span><?php echo __( 'Terrain', 'inventor-google-map' ); ?></span></a>
					                            <a id="map-control-type-satellite"><span><?php echo __( 'Satellite', 'inventor-google-map' ); ?></span></a>
					                        </div><!-- /.map-actions-group -->
										<?php endif; ?>

										<?php if ( ! empty( $instance['map_zoom'] ) && $instance['map_zoom'] == 'on' ) : ?>
											<div class="map-actions-group">
												<a id="map-control-zoom-in">
													<span><?php echo esc_attr__( 'Zoom In', 'inventor-google-map' ); ?></span>
												</a>

												<a id="map-control-zoom-out">
													<span><?php echo esc_attr__( 'Zoom Out', 'inventor-google-map' ); ?></span>
												</a>
											</div><!-- /.map-actions-group -->
										<?php endif; ?>

										<?php if ( ! empty( $instance['map_geolocation'] ) && $instance['map_geolocation'] == 'on' ) : ?>
					                        <div class="map-actions-group">
					                            <a id="map-control-current-position">
					                                <span><?php echo esc_attr__( 'Current Position', 'inventor-google-map' ); ?></span>
					                            </a>
					                        </div><!-- /.map-actions-group -->
										<?php endif; ?>
									</div><!-- /.map-actions -->
								</div><!-- /.col-* -->
							</div><!-- /.row -->
						<?php endif; ?>
					</div><!-- /.container -->
				</div><!-- /.map-content -->
			<?php endif; ?>
		</div><!-- /.map-inner -->
	</div><!-- /.map-wrapper -->
</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
