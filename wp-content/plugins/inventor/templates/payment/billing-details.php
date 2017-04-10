<?php $billing_fields = apply_filters( 'inventor_billing_fields', array() );  ?>

<div class="billing-details">
    <?php foreach( $billing_fields as $key => $title ): ?>
        <div class="form-group <?php echo str_replace('_', '-', $key ); ?>">
            <?php $default_value = get_user_meta( get_current_user_id(), INVENTOR_USER_PREFIX . $key, true ) ;?>
            <label for="<?php echo str_replace('_', '-', $key ); ?>"><?php echo $title; ?></label>
            <input type="text" class="form-control" name="<?php echo $key; ?>" id="<?php echo str_replace('_', '-', $key ); ?>" value="<?php echo ! empty( $_POST[$key] ) ? esc_attr( $_POST[$key] ) : $default_value; ?>" >
        </div><!-- /.form-group -->
    <?php endforeach; ?>
</div><!-- /.billing-details -->