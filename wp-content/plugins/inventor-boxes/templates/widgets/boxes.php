<?php
/**
 * Widget template
 *
 * @package Inventor_Boxes
 * @subpackage Widgets/Templates
 */

?>

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

    <?php $description_column = ! empty( $instance['description'] ); ?>

    <?php if ( ! empty( $instance['title'] ) && ! $description_column ) : ?>
        <h2 class="widgettitle">
            <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
        </h2><!-- /.widgettitle -->
    <?php endif; ?>

    <?php if ( is_array( $boxes ) ) : ?>
        <?php $boxes = Inventor_Template_Loader::load( 'widgets/boxes-boxes', array( 'content' => $boxes ), INVENTOR_BOXES_DIR ); ?>

        <?php if ( $description_column ): ?>
            <div class="row">
                <div class="boxes-title-description col-md-4">
                    <?php if ( ! empty( $instance['title'] ) ) : ?>
                        <h2 class="widgettitle">
                            <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
                        </h2><!-- /.widgettitle -->
                    <?php endif; ?>

                    <div class="description">
                        <?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
                    </div><!-- /.description -->

                    <?php if ( ! empty( $instance['button_text'] ) && ! empty ( $instance['button_url'] ) ) : ?>
                        <a class="btn btn-primary" href="<?php echo esc_attr( $instance[ 'button_url' ] ); ?>">
                            <?php echo wp_kses( $instance['button_text'], wp_kses_allowed_html( 'post' ) ); ?>
                        </a><!-- /.btn -->
                    <?php endif; ?>
                </div>
                <div class="boxes-condensed col-md-8">
                    <?php echo $boxes; ?>
                </div>
            </div><!-- /.row -->
        <?php else: ?>
            <?php echo $boxes; ?>
        <?php endif; ?>

    <?php endif; ?>
</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>