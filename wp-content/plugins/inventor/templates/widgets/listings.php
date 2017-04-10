<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $instance['per_row'] = empty( $instance['per_row'] ) ? 3 : $instance['per_row']; ?>
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

        <?php if ( have_posts() ) : ?>
            <?php if ( ! empty( $instance['description'] ) ) : ?>
                <div class="description">
                    <?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
                </div><!-- /.description -->
            <?php endif; ?>

            <div class="type-<?php echo esc_attr( $instance['display'] ); ?> items-per-row-<?php echo esc_attr( $instance['per_row'] ); ?>">

                <?php if ( 'masonry' == $instance['display'] ) : ?>

                    <div class="listings-row">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="listing-masonry-container">
                                <?php include Inventor_Template_Loader::locate( 'listings/' . $instance['display'] ); ?>
                            </div><!-- /.listing-masonry-container -->
                        <?php endwhile; ?>
                    </div><!-- /.listing-row -->

                <?php elseif ( 'carousel' == $instance['display'] ) : ?>

                    <div class="listing-carousel">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="listing-container">
                                <?php include Inventor_Template_Loader::locate( 'listings/column' ); ?>
                            </div><!-- /.listing-container -->
                        <?php endwhile; ?>
                    </div><!-- /.listing-row -->

                <?php else : ?>

                    <div class="listings-row">

                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="listing-container">
                                <?php include Inventor_Template_Loader::locate( 'listings/' . $instance['display'] ); ?>
                            </div><!-- /.listing-container -->
                        <?php endwhile; ?>

                    </div><!-- /.listing-row -->

                <?php endif; ?>

            </div><!-- /.type-* -->
        <?php else : ?>
            <div class="alert alert-warning">
                <?php echo __( 'No listings found.', 'inventor' ); ?>
            </div><!-- /.alert -->
        <?php endif; ?>

    </div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>