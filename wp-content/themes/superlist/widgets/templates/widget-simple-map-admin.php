<?php
/**
 * Widget template
 *
 * @package Superlist
 * @subpackage Widgets/Templates
 */

$latitude = ! empty( $instance['latitude'] ) ? $instance['latitude'] : 40.772799;
$longitude = ! empty( $instance['longitude'] ) ? $instance['longitude'] : -73.968653;
$zoom = ! empty( $instance['zoom'] ) ? $instance['zoom'] : 16;
$height = ! empty( $instance['height'] ) ? $instance['height'] : 350;
$style = ! empty( $instance['style'] ) ? $instance['style'] : '';
?>

<!-- LATITUDE -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>">
        <?php echo esc_attr__( 'Latitude', 'superlist' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'latitude' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $latitude ); ?>">
</p>

<!-- LONGITUDE -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>">
        <?php echo esc_attr__( 'Longitude', 'superlist' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'longitude' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $longitude ); ?>">
</p>

<!-- ZOOM -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>">
        <?php echo esc_attr__( 'Zoom', 'superlist' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'zoom' ) ); ?>"
            type="number"
            max="25"
            min="0"
            value="<?php echo esc_attr( $zoom ); ?>">
</p>

<!-- HEIGHT -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">
        <?php echo esc_attr__( 'Height in pixels', 'superlist' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"
            type="number"
            min="0"
            step="50"
            value="<?php echo esc_attr( $height ); ?>">
</p>

<!-- STYLE-->
<?php if ( class_exists( 'Inventor_Google_Map_Styles' ) ) : ?>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>">
            <?php echo esc_attr__( 'Style', 'superlist' ); ?>
        </label>

        <select id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
            <option value=""><?php echo esc_attr__( 'Default', 'superlist' ); ?></option>
            <?php $maps = Inventor_Google_Map_Styles::styles(); ?>
            <?php if ( is_array( $maps ) ) : ?>
                <?php foreach ( $maps as $map ) :   ?>
                    <option <?php if ( $style == $map['slug'] ) : ?>selected="selected"<?php endif; ?>value="<?php echo esc_attr( $map['slug'] ); ?>"><?php echo esc_html( $map['title'] ); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </p>
<?php endif; ?>
