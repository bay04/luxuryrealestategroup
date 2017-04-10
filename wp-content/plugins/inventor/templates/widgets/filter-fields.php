<?php $fields = Inventor_Filter::get_fields(); ?>
<?php if ( ! empty( $instance['sort'] ) ) : ?>
    <?php
    $keys = explode( ',', $instance['sort'] );
    $filtered_keys = array_filter( $keys );
    $fields = array_merge( array_flip( $filtered_keys ), $fields );
    ?>
<?php endif; ?>

<?php foreach ( $fields as $key => $value ) : ?>
    <?php $is_field_visible = empty( $instance[ sprintf( 'hide_%s', $key ) ] ); ?>
    <?php $is_field_active = in_array( $key, array_keys( Inventor_Filter::get_fields() ) ); ?>

    <?php if ( $is_field_visible && $is_field_active ) : ?>
        <?php $template = str_replace( '_', '-', $key ); ?>
        <?php $plugin_dir = apply_filters( 'inventor_filter_field_plugin_dir', INVENTOR_DIR, $template, $key ); ?>
        <?php
        try {
            include Inventor_Template_Loader::locate( 'widgets/filter-fields/' . $template, $plugin_dir );
        } catch (Exception $e) {
            if ( strpos( $e->getMessage(), 'not found') !== false ) {
                echo Inventor_Template_Loader::load( 'widgets/filter-fields/generic', array( 'field_id' => $key, 'input_titles' => $input_titles ), $plugin_dir );
            }
        }
        ?>
    <?php endif; ?>

<?php endforeach; ?>