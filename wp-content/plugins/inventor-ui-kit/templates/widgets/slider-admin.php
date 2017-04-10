<?php
$height = ! empty( $instance['height'] ) ? $instance['height'] : '500px';
$body_classes = ! empty( $instance['body_classes'] ) ? $instance['body_classes'] : '';
$navigation_style = ! empty( $instance['navigation_style'] ) ? $instance['navigation_style'] : 'arrows';
$navigation_counter = ! empty( $instance['navigation_counter'] ) ? $instance['navigation_counter'] : '';
$dots = ! empty( $instance['dots'] ) ? $instance['dots'] : '';
$autoplay = ! empty( $instance['autoplay'] ) ? $instance['autoplay'] : '';
$autoplay_timeout = ! empty( $instance['autoplay_timeout'] ) ? $instance['autoplay_timeout'] : '2000';
$number_of_slides = ! empty( $instance['number_of_slides'] ) ? $instance['number_of_slides'] : '3';
?>

<!-- CLASSES -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'body_classes' ) ); ?>">
		<?php echo __( 'Body classes', 'inventor-ui-kit' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'body_classes' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'body_classes' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $body_classes ); ?>">
	<br>
	<small><?php echo __( 'Additional classes appended to body class and separated by , e.g. <i>header-transparent, inventor-slider-append-top, inventor-slider-fullscreen</i>', 'inventor-ui-kit' ); ?></small>
</p>

<!-- HEIGHT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">
		<?php echo __( 'Height', 'inventor-ui-kit' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $height ); ?>">
	<br>
	<small><?php echo __( 'For example: 500px, 75vh ...', 'inventor-ui-kit' ); ?></small>
</p>

<!-- NAVIGATION STYLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'navigation_style' ) ); ?>">
		<?php echo __( 'Navigation style', 'inventor-ui-kit' ); ?>
	</label>

	<select id="<?php echo esc_attr( $this->get_field_id( 'navigation_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'navigation_style' ) ); ?>">
		<option value="none" <?php echo ( $navigation_style == 'none' ) ? 'selected="selected"' : ''; ?>><?php echo __( 'None', 'inventor-ui-kit' ); ?></option>
		<option value="arrows" <?php echo ( $navigation_style == 'arrows' ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Arrows', 'inventor-ui-kit' ); ?></option>
		<option value="text" <?php echo ( $navigation_style == 'text' ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Text', 'inventor-ui-kit' ); ?></option>
	</select>
</p>

<!-- NAVIGATION COUNTER -->
<p>
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $navigation_counter ) ? 'checked="checked"' : ''; ?>
	        id="<?php echo esc_attr( $this->get_field_id( 'navigation_counter' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'navigation_counter' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'navigation_counter' ) ); ?>">
		<?php echo __( 'Navigation counter', 'inventor-ui-kit' ); ?>
	</label>
</p>

<!-- DOTS -->
<p>
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $dots ) ? 'checked="checked"' : ''; ?>
	        id="<?php echo esc_attr( $this->get_field_id( 'dots' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'dots' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'dots' ) ); ?>">
		<?php echo __( 'Dots', 'inventor-ui-kit' ); ?>
	</label>
</p>

<!-- AUTOPLAY -->
<p>
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $autoplay ) ? 'checked="checked"' : ''; ?>
	        id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>">
		<?php echo __( 'Autoplay', 'inventor-ui-kit' ); ?>
	</label>
</p>

<!-- AUTOPLAY TIMEOUT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay_timeout' ) ); ?>">
		<?php echo __( 'Autoplay timeout', 'inventor-ui-kit' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'autoplay_timeout' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'autoplay_timeout' ) ); ?>"
	        type="number"
	        step="1"
	        value="<?php echo esc_attr( $autoplay_timeout ); ?>">
	<br>
	<small><?php echo __( 'In miliseconds', 'inventor-ui-kit' ); ?></small>
</p>

<!-- NUMBER OF SLIDES -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_slides' ) ); ?>">
		<?php echo __( 'Number of slides', 'inventor-ui-kit' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'number_of_slides' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'number_of_slides' ) ); ?>"
	        type="number"
	        step="1"
	        value="<?php echo esc_attr( $number_of_slides ); ?>">
	<br>
	<small><?php echo __( 'Reload page after value changed.', 'inventor-ui-kit' ); ?></small>
</p>

<!-- SLIDES -->
<?php for ( $i = 1; $i <= $number_of_slides; $i++ ) : ?>
	<?php
		$attrs = array(
			'headline', 'title', 'text',
			'button_label', 'button_link',
			'background',
			'overlay_opacity', 'overlay_color',
			'alignment',
			'css_class'
		);

		$defaults = array(
			'overlay_opacity' => '0.55',
			'overlay_color' => '#545454'
		);

		foreach ( $attrs as $attr ) {
			${ $attr . '_id' } = $attr . '_' . $i;
			${ $attr } = ! empty( $instance[ $attr . '_' . $i ] ) ? $instance[ $attr . '_' . $i ] : ( empty( $defaults[ $attr ] ) ? '' : $defaults[ $attr ] );
		}
	?>
    
    <p>
        <div class="widget">
            <div class="widget-top">
                <span class="dashicons dashicons-arrow-down" style="color: #aaa; cursor: pointer; float: right; padding: 12px 12px 0; position: relative;"></span>

                <div class="widget-title" style="cursor: pointer;">
                    <h4><?php echo esc_attr( $i . '. ' . $headline ); ?></h4>
                </div>
            </div>
            <div class="widget-inside">

                <p>
                    <?php echo esc_attr__( 'Headline', 'inventor-ui-kit' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $headline_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $headline_id ) ); ?>" type="text" value="<?php echo esc_attr( $headline ); ?>">
                </p>

                <p>
                    <?php echo esc_attr__( 'Title', 'inventor-ui-kit' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $title_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $title_id ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
                </p>

                <p>
                    <?php echo esc_attr__( 'Text', 'inventor-ui-kit' ); ?>
                    <textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( $text_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $text_id ) ); ?>"><?php echo esc_attr( $text ); ?></textarea>
                </p>

                <p>
                    <?php echo esc_attr__( 'Button label', 'inventor-ui-kit' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $button_label_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $button_label_id ) ); ?>" type="text" value="<?php echo esc_attr( $button_label ); ?>">
                </p>

                <p>
                    <?php echo esc_attr__( 'Button link', 'inventor-ui-kit' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $button_link_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $button_link_id ) ); ?>" type="text" value="<?php echo esc_attr( $button_link ); ?>">
                </p>

				<p>
					<?php echo esc_attr__( 'Alignment', 'inventor-ui-kit' ); ?><br>

					<select id="<?php echo esc_attr( $this->get_field_id( $alignment_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $alignment_id ) ); ?>">
						<option value="left" <?php echo ( $alignment == 'left' ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Left', 'inventor-ui-kit' ); ?></option>
						<option value="center" <?php echo ( $alignment == 'center' || empty( $alignment ) ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Center', 'inventor-ui-kit' ); ?></option>
						<option value="right" <?php echo ( $alignment == 'right' ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Right', 'inventor-ui-kit' ); ?></option>
					</select>
				</p>

                <p>
                    <?php echo esc_attr__( 'Background', 'inventor-ui-kit' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $background_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $background_id ) ); ?>" type="text" value="<?php echo esc_attr( $background ); ?>">
                	<br>
					<small><?php echo __( 'Absolute path to image', 'inventor-ui-kit' ); ?></small>
                </p>

				<!-- OVERLAY COLOR -->
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( $overlay_color_id ) ); ?>">
						<?php echo esc_attr__( 'Overlay color', 'inventor-ui-kit' ); ?>
					</label>
					<br>
					<input  class="widefat color-picker"
							id="<?php echo esc_attr( $this->get_field_id( $overlay_color_id ) ); ?>"
							name="<?php echo esc_attr( $this->get_field_name( $overlay_color_id ) ); ?>"
							type="text"
							value="<?php echo esc_attr( $overlay_color ); ?>">
				</p>

				<!-- OVERLAY OPACITY -->
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( $overlay_opacity_id ) ); ?>">
						<?php echo esc_attr__( 'Overlay opacity', 'inventor-ui-kit' ); ?>
					</label>

					<input  class="widefat"
							id="<?php echo esc_attr( $this->get_field_id( $overlay_opacity_id ) ); ?>"
							name="<?php echo esc_attr( $this->get_field_name( $overlay_opacity_id ) ); ?>"
							type="number"
							step="any"
							pattern="\d*(\.\d*)?"
							value="<?php echo esc_attr( $overlay_opacity ); ?>">
				</p>

                <p>
                    <?php echo esc_attr__( 'CSS class', 'inventor-ui-kit' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $css_class_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $css_class_id ) ); ?>" type="text" value="<?php echo esc_attr( $css_class ); ?>">
                </p>
            </div>
        </div>
    </p>
<?php endfor; ?>