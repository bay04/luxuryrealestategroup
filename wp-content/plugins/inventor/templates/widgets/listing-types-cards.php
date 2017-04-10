<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $instance['per_row'] = ! empty( $instance['per_row'] ) ? $instance['per_row'] : 4; ?>

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

    <?php if ( is_array( $listing_types ) ) : ?>
        <div class="listing-types-cards items-per-row-<?php echo esc_attr( $instance['per_row'] ); ?>">

            <?php foreach( $listing_types as $post_type => $data ) : ?>
                <div class="listing-types-card-container">
                    <div class="listing-types-card">
                        <div class="listing-types-card-image" style="background-image: url('<?php echo $data['image']; ?>');">
                            <a href="<?php echo $data['url']; ?>" <?php if ( ! empty( $data['icon'] ) ) :?>style="border-color:<?php echo $data['color']; ?>;"<?php endif; ?>>
                                <?php
                                if ( ! empty( $data['icon'] ) ) {
                                    $style = empty( $data['icon'] ) ? '' : 'style="background-color: ' . $data['color'] .' ;"';
                                    echo '<i class="inventor-poi '. $data['icon'] .'" ' . $style .'></i>';
                                }
                                ?>
                            </a>
                        </div><!-- /.listing-types-card-image -->

                        <h3 class="listing-types-card-title">
                            <a href="<?php echo $data['url']; ?>"><?php echo $data['label']; ?></a>
                        </h3><!-- /.listing-types-card-title -->

                        <?php if ( ! empty( $instance['show_count'] ) ) : ?>
                            <div class="listing-types-card-bottom">
                                <?php printf( _n( '%d listing', '%d listings', $data['count'], 'inventor' ), $data['count'] ); ?>
                            </div>
                        <?php endif; ?>
                    </div><!-- /.listing-types-card -->
                </div><!-- /.listing-types-card-container -->
            <?php endforeach; ?>
        </div><!-- /.listing-types-cards -->
    <?php endif; ?>

</div><!-- /.widget-inner -->

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>	