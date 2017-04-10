<?php
/**
 * Widget template
 *
 * @package Inventor_Boxes
 * @subpackage Widgets/Templates
 */

$title = ( isset( $instance['title'] ) ) ? $instance['title'] : '';
$description = ( isset( $instance['description'] ) ) ? $instance['description'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$button_url = ! empty( $instance['button_url'] ) ? $instance['button_url'] : '';
?>

<p>
    <?php echo esc_attr__( 'Title', 'inventor-boxes' ); ?>:
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
</p>

<p>
    <?php echo esc_attr__( 'Description', 'inventor-boxes' ); ?>:
    <textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
</p>

<!-- Button -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
		<?php echo __( 'Button', 'inventor-boxes' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $button_text ); ?>">
	<i><?php echo __( 'Text of the action button', 'inventor-boxes' ); ?></i>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $button_url ); ?>">
	<i><?php echo __( 'URL of the action button', 'inventor-boxes' ); ?></i>
</p>

<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
    <?php $title_id = 'title_' . $i; ?>
    <?php $content_id = 'content_' . $i; ?>
    <?php $icon_id = 'icon_' . $i; ?>
    <?php $number_id = 'number_' . $i; ?>
    <?php $link_id = 'link_' . $i; ?>
    <?php $background_image_id = 'background_image_' . $i; ?>
    <?php $css_class_id = 'css_class_' . $i; ?>

    <?php $title = ! empty( $instance[ $title_id ] ) ? $instance[ $title_id ] : ''; ?>
    <?php $content = ! empty( $instance[ $content_id ] ) ? $instance[ $content_id ] : ''; ?>
    <?php $icon = ! empty( $instance[ $icon_id ] ) ? $instance[ $icon_id ] : ''; ?>
    <?php $number = ! empty( $instance[ $number_id ] ) ? $instance[ $number_id ] : ''; ?>
    <?php $link = ! empty( $instance[ $link_id ] ) ? $instance[ $link_id ] : ''; ?>
    <?php $background_image = ! empty( $instance[ $background_image_id ] ) ? $instance[ $background_image_id ] : ''; ?>
    <?php $css_class = ! empty( $instance[ $css_class_id ] ) ? $instance[ $css_class_id ] : ''; ?>

    <p>
        <div class="widget">
            <div class="widget-top">
                <span class="dashicons dashicons-arrow-down" style="color: #aaa; cursor: pointer; float: right; padding: 12px 12px 0px; position: relative;"></span>

                <div class="widget-title" style="cursor: pointer;">
                    <h4><?php echo esc_attr( $i . '. ' . $title ); ?></h4>
                </div>
            </div>
            <div class="widget-inside">

                <p>
                    <?php echo esc_attr__( 'Title', 'inventor-boxes' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $title_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $title_id ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
                </p>

                <p>
                    <?php echo esc_attr__( 'Content', 'inventor-boxes' ); ?>
                    <textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( $content_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $content_id ) ); ?>"><?php echo esc_attr( $content ); ?></textarea>
                </p>

                <p>
                    <?php echo esc_attr__( 'Icon', 'inventor-boxes' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $icon_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $icon_id ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>">
                </p>

                <p>
                    <?php echo esc_attr__( 'Number', 'inventor-boxes' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $number_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $number_id ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">
                </p>

                <p>
                    <?php echo esc_attr__( 'Read More Link', 'inventor-boxes' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $link_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $link_id ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
                    <?php echo esc_attr__( 'For example', 'inventor-boxes' ); ?> <code>http://example.com/</code>.
                </p>

                <p>
                    <?php echo esc_attr__( 'Background image', 'inventor-boxes' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $background_image_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $background_image_id ) ); ?>" type="text" value="<?php echo esc_attr( $background_image ); ?>">
                </p>

                <p>
                    <?php echo esc_attr__( 'CSS class', 'inventor-boxes' ); ?>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $css_class_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $css_class_id ) ); ?>" type="text" value="<?php echo esc_attr( $css_class ); ?>">
                </p>
            </div>
        </div>
    </p>
<?php endfor; ?>