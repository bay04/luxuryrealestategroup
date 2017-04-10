<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$description = ! empty( $instance['description'] ) ? $instance['description'] : '';
$per_row = ! empty( $instance['per_row'] ) ? $instance['per_row'] : 4;
$show_count = ! empty( $instance['show_count'] ) ? $instance['show_count'] : '';
$appearance = ! empty( $instance['appearance'] ) ? $instance['appearance'] : 'tabs';
?>

<!-- TITLE -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
        <?php echo __( 'Title', 'inventor' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $title ); ?>">
</p>

<!-- DESCRIPTION -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
        <?php echo __( 'Description', 'inventor' ); ?>
    </label>

	<textarea class="widefat"
              rows="4"
              id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
              name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
</p>

<!-- PER ROW -->
<p class="per-row">
    <label for="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>">
        <?php echo __( 'Items per row', 'inventor' ); ?>
    </label>

    <select id="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'per_row' ) ); ?>">
        <option value="1" <?php echo ( '1' == $per_row ) ? 'selected="selected"' : ''; ?>>1</option>
        <option value="2" <?php echo ( '2' == $per_row ) ? 'selected="selected"' : ''; ?>>2</option>
        <option value="3" <?php echo ( '3' == $per_row ) ? 'selected="selected"' : ''; ?>>3</option>
        <option value="4" <?php echo ( '4' == $per_row ) ? 'selected="selected"' : ''; ?>>4</option>
        <option value="5" <?php echo ( '5' == $per_row ) ? 'selected="selected"' : ''; ?>>5</option>
        <option value="6" <?php echo ( '6' == $per_row ) ? 'selected="selected"' : ''; ?>>6</option>
    </select>
</p>

<!-- SHOW COUNT -->
<p>
    <label>
        <input  type="checkbox"
                class="checkbox"
            <?php echo ( ! empty( $show_count ) ) ? 'checked="checked"' : ''; ?>
                id="<?php echo esc_attr( $this->get_field_id( 'show_count' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'show_count' ) ); ?>">
        <?php echo __( 'Show count', 'inventor' ); ?>
    </label>
</p>

<!-- DISPLAY -->
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'appearance' ) ); ?>">
        <?php echo __( 'Display as', 'inventor' ); ?>
    </label>

    <select id="<?php echo esc_attr( $this->get_field_id( 'appearance' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'appearance' ) ); ?>">
        <option value="cards" <?php echo ( 'cards' == $appearance ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Cards', 'inventor' ); ?></option>
    </select>
</p>

<!-- LISTING TYPES -->
<ul class="inventor-listing-types">
    <?php $all_listing_types = Inventor_Post_Types::get_listing_post_types( false, true ); ?>
    <?php $listing_types = $all_listing_types; ?>

    <?php if ( ! empty( $instance['sort'] ) ) : ?>
        <?php
        $post_types = explode( ',', $instance['sort'] );
        $filtered_keys = array_filter( $post_types );
        $listing_types = array_replace( array_flip( $filtered_keys ), $listing_types );
        ?>
    <?php endif; ?>

    <input type="hidden"
           <?php if ( ! empty( $sort ) ): ?>value="<?php echo esc_attr( $sort ); ?>"<?php endif; ?>
           id="<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>"
           name="<?php echo esc_attr( $this->get_field_name( 'sort' ) ); ?>">

    <?php foreach ( $listing_types as $post_type => $label ) : ?>
        <?php if ( array_key_exists( $post_type, $all_listing_types ) ) : ?>
            <li data-field-id="<?php echo esc_attr( $post_type ); ?>" <?php if ( ! empty( $instance[ 'show_' . $post_type ] ) ) : ?>class="invisible"<?php endif; ?>>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'show_' . $post_type ) ); ?>">
                        <?php echo Inventor_Post_Types::get_icon( $post_type, true ); ?> <?php echo esc_attr( $label ); ?>
                    </label>

					<span class="visibility">
						<?php $input_name = esc_attr( $this->get_field_name( 'show_' . $post_type ) ); ?>
                        <input type="checkbox" class="checkbox field-visibility" name="<?php echo $input_name; ?>" <?php echo ! empty( $instance[ 'show_'. $post_type ] ) ? 'checked="checked"' : ''; ?>>
						<i class="dashicons dashicons-visibility"></i>
					</span>

                    <span class="appearance">
                        <!-- COLOR -->
                        <label for="<?php echo esc_attr( $this->get_field_id( 'color_' . $post_type ) ); ?>">
                            <?php echo __( 'Color', 'inventor' ); ?>
                        </label>
                        <input  class="widefat color-picker"
                                id="<?php echo esc_attr( $this->get_field_id( 'color_' . $post_type ) ); ?>"
                                name="<?php echo esc_attr( $this->get_field_name( 'color_' . $post_type ) ); ?>"
                                type="text"
                                value="<?php echo empty( $instance[ 'color_' . $post_type ] ) ? '' : esc_attr( $instance[ 'color_' . $post_type ] ); ?>">

                        <!-- BACKGROUND PATTERN -->
                        <label for="<?php echo esc_attr( $this->get_field_id( 'image_' . $post_type ) ); ?>">
                            <?php echo __( 'Image (URL)', 'inventor' ); ?>
                        </label>
                        <input  class="widefat"
                                id="<?php echo esc_attr( $this->get_field_id( 'image_' . $post_type ) ); ?>"
                                name="<?php echo esc_attr( $this->get_field_name( 'image_' . $post_type ) ); ?>"
                                type="text"
                                value="<?php echo empty( $instance[ 'image_' . $post_type ] ) ? '' : esc_attr( $instance[ 'image_' . $post_type ] ); ?>">
                    </span>
                </p>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.widget .inventor-listing-types').each(function() {
            var el = $(this);

            el.sortable({
                update: function(event, ui) {
                    var data = el.sortable('toArray', {
                        attribute: 'data-field-id'
                    });

                    $('#<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>').attr('value', data);
                }
            });

            $(this).find('input[type=checkbox]').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('li').removeClass('invisible');
                    $(this).closest('li').find('.appearance').show();
                } else {
                    $(this).closest('li').addClass('invisible');
                    $(this).closest('li').find('.appearance').hide();
                }
            }).change();
        });
    });
</script>