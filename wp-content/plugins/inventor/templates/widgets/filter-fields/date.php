<?php if ( empty( $instance['hide_date'] ) ) : ?>
    <?php $date_range = Inventor_Filter::get_field_range( 'date', $_GET ); ?>

    <div class="form-group form-group-date form-group-date-from">
        <?php if ( 'labels' == $input_titles ) : ?>
            <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_date_from"><?php echo __( 'Date from', 'inventor' ); ?></label>
        <?php endif; ?>

        <div class="input-group">
            <input type="date"
                   <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Date from', 'inventor' ); ?>"<?php endif; ?>
                   class="form-control date-from" value="<?php echo empty( $date_range['from'] ) ? '' : $date_range['from']; ?>"
                   id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_date_from">

			<span class="input-group-addon">
                <i class="fa fa-calendar"></i>
			</span>
        </div><!-- /.input-group -->
    </div><!-- /.form-group -->

    <div class="form-group form-group-date form-group-date-to">
        <?php if ( 'labels' == $input_titles ) : ?>
            <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_date_to"><?php echo __( 'Date to', 'inventor' ); ?></label>
        <?php endif; ?>

        <div class="input-group">
            <input type="date"
                   <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Date to', 'inventor' ); ?>"<?php endif; ?>
                   class="form-control date-to" value="<?php echo empty( $date_range['to'] ) ? '' : $date_range['to']; ?>"
                   id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_date_to">

			<span class="input-group-addon">
                <i class="fa fa-calendar"></i>
			</span>
        </div><!-- /.input-group -->
    </div><!-- /.form-group -->

    <input type="hidden" name="date" class="form-control" value="<?php echo is_array( $date_range ) ? implode( '-', $date_range ) : ''; ?>" id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_date">
<?php endif; ?>