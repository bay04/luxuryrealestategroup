<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php if ( apply_filters( 'inventor_metabox_allowed', true, 'opening_hours', get_the_author_meta('ID') ) ): ?>

    <?php $visible = Inventor_Post_Types::opening_hours_visible( get_the_ID() ); ?>

    <?php if ( $visible ) : ?>

        <?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

        <div class="widget-inner
            <?php if ( ! empty( $instance['classes'] ) ) : ?><?php echo esc_attr( $instance['classes'] ); ?><?php endif; ?>
            <?php echo ( empty( $instance['padding_top'] ) ) ? '' : 'widget-pt' ; ?>
            <?php echo ( empty( $instance['padding_bottom'] ) ) ? '' : 'widget-pb' ; ?>"
            <?php if ( ! empty( $instance['background_color'] ) || ! empty( $instance['background_image'] ) ) : ?>style="
                    <?php if ( ! empty( $instance['background_color'] ) ) : ?>
                        background-color: <?php echo esc_attr( $instance['background_color'] ); ?>;
            <?php endif; ?>
                    <?php if ( ! empty( $instance['background_image'] ) ) : ?>
                        background-image: url('<?php echo esc_attr( $instance['background_image'] ); ?>');
                    <?php endif; ?>"<?php endif; ?>
        >

            <?php if ( ! empty( $instance['title'] ) ) : ?>
                <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
                <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
                <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
            <?php endif; ?>

            <?php $opening_hours_status = Inventor_Post_Types::opening_hours_status( get_the_ID() ); ?>
            <?php if ( $opening_hours_status == 'open' ): ?>
                <div class="alert alert-success">
                    <?php echo __( 'It is <span class="open">open</span>.', 'inventor' ); ?>
                </div>
            <?php endif; ?>
            <?php if ( $opening_hours_status == 'closed' ): ?>
                <div class="alert alert-danger">
                    <?php echo __( 'It is <span class="closed">closed</span>.', 'inventor' ); ?>
                </div>
            <?php endif; ?>

            <table class="opening-hours">
                <?php
                // week days
                $day_names = Inventor_Post_Types::opening_hours_day_names('short');

                // get opening hours
                $opening_hours = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'opening_hours', true );

                // preserve first day of week setting
                $opening_hours = array_merge( array_splice( $opening_hours, get_option( 'start_of_week' ) - 1 ), $opening_hours );
                ?>

                <?php foreach( $opening_hours as $day ): ?>
                    <tr>
                        <th>
                            <?php echo $day_names[ $day['listing_day'] ]; ?>
                        </th>

                        <td class="<?php echo Inventor_Post_Types::opening_hours_status( get_the_ID(), $day['listing_day'] ); ?>">
                            <?php echo Inventor_Post_Types::opening_hours_format_day( $day, false ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table><!-- /.opening-hours -->

        </div><!-- /.widget-inner -->

        <?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>

    <?php endif; ?>
<?php endif; ?>
