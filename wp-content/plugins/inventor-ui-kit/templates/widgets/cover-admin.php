<?php
/**
 * Widget template
 *
 * @package inventor
 * @subpackage Widgets/Templates
 */

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
$height = ! empty( $instance['height'] ) ? $instance['height'] : '';
$overlay_color = ! empty( $instance['overlay_color'] ) ? $instance['overlay_color'] : '#242424';
$overlay_opacity = ! empty( $instance['overlay_opacity'] ) ? $instance['overlay_opacity'] : '0.4';
$poster = ! empty( $instance['poster'] ) ? $instance['poster'] : '';
$video_mp4 = ! empty( $instance['video_mp4'] ) ? $instance['video_mp4'] : '';
$video_ogg = ! empty( $instance['video_ogg'] ) ? $instance['video_ogg'] : '';
$video_embed = ! empty( $instance['video_embed'] ) ? $instance['video_embed'] : '';
$classes = ! empty( $instance['classes'] ) ? $instance['classes'] : '';
$filter = ! empty( $instance['filter'] ) ? $instance['filter'] : '';
?>

<!-- TITLE -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
        <?php echo esc_attr__( 'Title', 'inventor-ui-kit' ); ?>
    </label>


    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $title ); ?>">
</p>

<!-- SUBTITLE -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>">
        <?php echo esc_attr__( 'Subtitle', 'inventor-ui-kit' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $subtitle ); ?>">
</p>

<!-- HEIGHT -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">
        <?php echo esc_attr__( 'Height', 'inventor-ui-kit' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $height ); ?>">
</p>

<!-- OVERLAY COLOR -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'overlay_color' ) ); ?>">
        <?php echo esc_attr__( 'Overlay color', 'inventor-ui-kit' ); ?>
    </label>
    <br>
    <input  class="widefat color-picker"
            id="<?php echo esc_attr( $this->get_field_id( 'overlay_color' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'overlay_color' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $overlay_color ); ?>">
</p>

<!-- OVERLAY OPACITY -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'overlay_opacity' ) ); ?>">
        <?php echo esc_attr__( 'Overlay opacity', 'inventor-ui-kit' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'overlay_opacity' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'overlay_opacity' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $overlay_opacity ); ?>">
</p>

<!-- POSTER -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'poster' ) ); ?>">
        <?php echo esc_attr__( 'Preset Image URL', 'inventor-ui-kit' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'poster' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'poster' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $poster ); ?>">
</p>

<!-- VIDEO MP4 -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'video_mp4' ) ); ?>">
        <?php echo esc_attr__( 'Video MP4', 'inventor-ui-kit' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'video_mp4' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'video_mp4' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $video_mp4 ); ?>">
</p>

<!-- VIDEO OGG -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'video_ogg' ) ); ?>">
        <?php echo esc_attr__( 'Video OGG', 'inventor-ui-kit' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'video_ogg' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'video_ogg' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $video_ogg ); ?>">
</p>

<!-- VIDEO EMBED -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'video_embed' ) ); ?>">
        <?php echo esc_attr__( 'Video URL', 'inventor-ui-kit' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'video_embed' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'video_embed' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $video_embed ); ?>">
    <small><?php echo __( 'Enter a youtube or vimeo URL.', 'inventor-ui-kit' ); ?></small>
</p>

<!-- CLASSES -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'classes' ) ); ?>">
        <?php echo __( 'Classes', 'inventor-ui-kit' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'classes' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'classes' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $classes ); ?>">
    <br>
    <small><?php echo __( 'Additional classes appended to body class and separated by , e.g. <i>header-transparent, cover-widget-append-top</i>', 'inventor-ui-kit' ); ?></small>
</p>

<?php if ( class_exists( 'Inventor' ) ) : ?>
    <!-- FILTER -->
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>">
            <input 	type="checkbox"
                      data-rel="inventor-filter"
                      <?php if ( ! empty( $filter ) ) : ?>checked="checked"<?php endif; ?>
                      name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>"
                      id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>">

            <?php echo esc_attr__( 'Filter', 'inventor-ui-kit' ); ?>
        </label>
    </p>

    <?php include Inventor_Template_Loader::locate( 'widgets/filter-form-admin' ); ?>
<?php endif; ?>
