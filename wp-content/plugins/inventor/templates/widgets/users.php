<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $instance['per_row'] = empty( $instance['per_row'] ) ? 1 : $instance['per_row']; ?>
<?php $instance['per_row'] = $instance['display'] == 'carousel' ? 1 : $instance['per_row']; ?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

    <div class="widget-inner
 <?php if ( ! empty( $instance['classes'] ) ) : ?><?php echo esc_attr( $instance['classes'] ); ?><?php endif; ?>
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
            <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
            <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
        <?php endif; ?>

        <?php if ( ! empty( $instance['description'] ) ) : ?>
            <div class="description">
                <?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
            </div><!-- /.description -->
        <?php endif; ?>

        <?php if ( count( $users ) > 0 ) : ?>
            <div class="type-<?php echo esc_attr( $instance['display'] ); ?> items-per-row-<?php echo esc_attr( $instance['per_row'] ); ?>">

                <?php if ( 'carousel' == $instance['display'] ) : ?>

                    <div class="user-carousel">
                        <?php $index = 0; ?>
                        <?php foreach ( $users as $user ) : ?>
                            <div class="user-container">
                                <?php include Inventor_Template_Loader::locate( 'users/column' ); ?>
                            </div><!-- /.user-container -->
                            <?php $index++; ?>
                        <?php endforeach; ?>
                    </div><!-- /.user-row -->

                <?php else : ?>

                    <div class="users-row">

                    <?php $index = 0; ?>
                    <?php foreach ( $users as $user ) : ?>
                        <?php include Inventor_Template_Loader::locate( 'users/' . $instance['display'] ); ?>

                        <?php if ( 0 == ( ( $index + 1 ) % $instance['per_row'] ) && 1 != $instance['per_row'] && Inventor_Query::loop_has_next() ) : ?>
                            </div><div class="users-row">
                        <?php endif; ?>

                        <?php $index++; ?>
                    <?php endforeach; ?>

                    </div><!-- /.user-row -->

                <?php endif; ?>

            </div><!-- /.type-* -->
        <?php else : ?>
            <div class="alert alert-warning">
                <?php echo __( 'No users found.', 'inventor' ); ?>
            </div><!-- /.alert -->
        <?php endif; ?>

    </div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>