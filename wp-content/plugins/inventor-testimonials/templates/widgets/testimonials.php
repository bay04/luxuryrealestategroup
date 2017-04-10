<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
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

<?php if ( have_posts() ) : ?>

    <div class="testimonials">

        <?php while ( have_posts() ) : the_post(); ?>

            <div class="testimonial">

                <?php if ( has_post_thumbnail() ) : ?>
                    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
                    <div class="testimonial-image" style="background-image: url('<?php echo $thumbnail[0]; ?>');"></div><!-- /.testimonial-image -->
                <?php endif; ?>

                <div class="testimonial-inner">
                    <div class="testimonial-title">
                        <h2><?php the_title(); ?></h2>

                        <div class="testimonial-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div><!-- /.testimonial-rating -->

                    </div><!-- /.testimonial-title -->

                    <div class="testimonial-content">
                        <?php the_content(); ?>
                    </div>

                    <?php $author = get_post_meta( get_the_ID(), INVENTOR_TESTIMONIALS_PREFIX . 'author', true ); ?>
                    <?php if ( ! empty( $author ) ) : ?>
                        <div class="testimonial-sign">
                            - <?php echo esc_attr( $author ); ?>
                        </div><!-- /.testimonial-sign -->
                    <?php endif; ?>
                </div><!-- /.testimonial-inner -->
            </div><!-- /.testimonial -->

        <?php endwhile; ?>

    </div><!-- /.faq -->

<?php else : ?>

	<div class="alert alert-warning">
		<?php echo __( 'No Testimonials found.', 'inventor-testimonials' ); ?>
	</div><!-- /.alert -->

<?php endif; ?>

</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>