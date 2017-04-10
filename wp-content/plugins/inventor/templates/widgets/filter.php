<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels'; ?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<div class="widget-inner
     <?php echo esc_attr( $instance['classes'] ); ?>
     <?php echo ( empty( $instance['padding_top'] ) ) ? '' : 'widget-pt' ; ?>
     <?php echo ( empty( $instance['padding_bottom'] ) ) ? '' : 'widget-pb' ; ?>"
     <?php if ( ! empty( $instance['background_color'] ) || ! empty( $instance['background_image'] ) ) : ?>
        style="
        <?php if ( ! empty( $instance['background_color'] ) ) : ?>
            background-color: <?php echo esc_attr( $instance['background_color'] ); ?>;
        <?php endif; ?>
        <?php if ( ! empty( $instance['background_image'] ) ) : ?>
            background-image: url('<?php echo esc_attr( $instance['background_image'] ); ?>');
        <?php endif; ?>"
     <?php endif; ?>>

    <?php if ( ! empty( $instance['title'] ) ) : ?>
        <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
        <?php echo esc_attr( $instance['title'] ); ?>
        <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
    <?php endif; ?>

    <?php include Inventor_Template_Loader::locate( 'widgets/filter-form' ); ?>

    <?php if ( ! empty( $instance['result_numbers_enabled'] ) ) : ?>
        <?php global $wp_query; ?>

        <?php $matches = $wp_query->found_posts; ?>
        <?php $post_type = $wp_query->query_vars['post_type']; ?>
        <?php $total = Inventor_Post_Types::count_posts( $post_type ); ?>

        <?php if ( Inventor_Filter::has_filter( false ) && $total != 0 && $matches != 0 and $total != $matches ) : ?>
            <h3 class="filter-result-numbers">
                <?php if ( ! empty( $instance['result_numbers_total'] ) ) : ?>
                    <?php printf( _n( '<span class="match">%d</span> listing from <span class="total">%d</span> matches your search criteria', '<span class="match">%d</span> listings from <span class="total">%d</span> match your search criteria', $matches, 'inventor' ), $matches, $total ); ?>
                <?php else: ?>
                    <?php printf( _n( '<span class="match">%d</span> listing matches your search criteria', '<span class="match">%d</span> listings match your search criteria', $matches, 'inventor' ), $matches ); ?>
                <?php endif; ?>
            </h3>
            <?php do_action( 'inventor_after_filter_result_numbers' ); ?>
        <?php endif; ?>

    <?php endif; ?>
</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>