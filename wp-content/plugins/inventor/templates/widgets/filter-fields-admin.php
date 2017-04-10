<h4><?php echo __( 'Filter Fields', 'inventor-google-map' ); ?></h4>

<ul class="inventor-filter-fields">
    <?php $all_fields = Inventor_Filter::get_fields(); ?>
    <?php $fields = $all_fields; ?>

    <?php if ( ! empty( $instance['sort'] ) ) : ?>
        <?php
        $keys = explode( ',', $instance['sort'] );
        $filtered_keys = array_filter( $keys );
        $fields = array_replace( array_flip( $filtered_keys ), $fields );
        ?>
    <?php endif; ?>

    <input type="hidden"
           <?php if ( ! empty( $sort ) ): ?>value="<?php echo esc_attr( $sort ); ?>"<?php endif; ?>
           id="<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>"
           name="<?php echo esc_attr( $this->get_field_name( 'sort' ) ); ?>">

    <?php foreach ( $fields as $key => $value ) : ?>
        <?php if ( array_key_exists( $key, $all_fields ) ) : ?>
            <li data-field-id="<?php echo esc_attr( $key ); ?>" <?php if ( ! empty( $instance[ 'hide_' . $key ] ) ) : ?>class="invisible"<?php endif; ?>>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'hide_' . $key ) ); ?>">
                        <?php echo esc_attr( $value ); ?>
                    </label>

					<span class="visibility">
						<?php $input_name = esc_attr( $this->get_field_name( 'hide_' . $key ) ); ?>
                        <input type="checkbox" class="checkbox field-visibility" name="<?php echo $input_name; ?>" <?php echo ! empty( $instance[ 'hide_'. $key ] ) ? 'checked="checked"' : ''; ?>>
						<i class="dashicons dashicons-visibility"></i>
					</span>
                </p>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.widget .inventor-filter-fields').each(function() {
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
                    $(this).closest('li').addClass('invisible');
                } else {
                    $(this).closest('li').removeClass('invisible');
                }
            });
        });
    });
</script>