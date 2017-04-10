<?php $days = Inventor_Post_Types::opening_hours_day_names(); ?>

<table>
    <thead>
        <tr>
            <th><?php echo __( 'Day', 'inventor' ); ?></th>
            <th><?php echo __( 'Time from', 'inventor' ); ?></th>
            <th><?php echo __( 'Time to', 'inventor' ); ?></th>
            <th><?php echo __( 'Custom text', 'inventor' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $index = 0; ?>
        <?php foreach( $days as $key => $display ): ?>
            <tr>
                <?php $time_from = ''; ?>
                <?php $time_to = ''; ?>
                <?php $custom = ''; ?>

                <?php if ( is_array( $field->value ) ) : ?>
                    <?php foreach( $field->value as $opening_hours ) : ?>
                        <?php if( $opening_hours['listing_day'] == $key ) : ?>
                            <?php
                            $time_from = ! empty ( $opening_hours['listing_time_from'] ) ? $opening_hours['listing_time_from'] : '';
                            $time_to = ! empty( $opening_hours['listing_time_to'] ) ? $opening_hours['listing_time_to'] : '';
                            $custom = ! empty( $opening_hours['listing_custom'] ) ? $opening_hours['listing_custom'] : '';
                            ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <td><label for="listing_opening_hours_<?php echo $index; ?>_listing_day"></label><input type="hidden" name="listing_opening_hours[<?php echo $index; ?>][listing_day]" id="listing_opening_hours_<?php echo $index; ?>_listing_day" value="<?php echo $key; ?>"><?php echo $display; ?></td>
                <td><label for="listing_opening_hours_<?php echo $index; ?>_listing_time_from"></label><input type="text" class="cmb2-timepicker text-time" name="listing_opening_hours[<?php echo $index; ?>][listing_time_from]" id="listing_opening_hours_<?php echo $index; ?>_listing_time_from" value="<?php echo $time_from; ?>"></td>
                <td><label for="listing_opening_hours_<?php echo $index; ?>_listing_time_to"></label><input type="text" class="cmb2-timepicker text-time" name="listing_opening_hours[<?php echo $index; ?>][listing_time_to]" id="listing_opening_hours_<?php echo $index; ?>_listing_time_to" value="<?php echo $time_to; ?>"></td>
                <td><label for="listing_opening_hours_<?php echo $index; ?>_listing_time_custom"></label><input type="text" class="regular-text" name="listing_opening_hours[<?php echo $index; ?>][listing_custom]" id="listing_opening_hours_<?php echo $index; ?>_listing_custom" value="<?php echo $custom; ?>"></td>
            </tr>
            <?php $index++; ?>
        <?php endforeach; ?>
    </tbody>
</table>
