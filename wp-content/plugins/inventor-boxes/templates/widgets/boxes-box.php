<div class="box box-number-<?php echo esc_attr( $index + 1 ); ?> <?php if ( ! empty( $box['css_class'] ) ) : ?><?php echo esc_attr( $box['css_class'] ); ?><?php endif; ?>">
    <div class="box-inner">
        <?php if ( ! empty( $box['icon'] ) ) : ?>
            <div class="box-icon">
                <?php echo wp_kses( $box['icon'], wp_kses_allowed_html( 'post' ) ); ?>
            </div><!-- /.box-icon -->
        <?php endif; ?>

        <div class="box-body">
            <?php if ( ! empty( $box['title'] ) ) : ?>
                <h4 class="box-title">
                    <?php echo wp_kses( $box['title'], wp_kses_allowed_html( 'post' ) ); ?>
                </h4><!-- /.box-title -->
            <?php endif; ?>

            <?php if ( ! empty( $box['number'] ) ) : ?>
                <?php $number = wp_kses( $box['number'], wp_kses_allowed_html( 'post' ) ); ?>
                <div class="box-number" data-value="<?php echo $number; ?>">
                    <?php echo $number; ?>
                </div><!-- /.box-number -->
            <?php endif; ?>

            <?php if ( ! empty( $box['content'] ) ) : ?>
                <div class="box-content">
                    <?php echo wp_kses( $box['content'], wp_kses_allowed_html( 'post' ) ); ?>
                </div><!-- /.box-content -->
            <?php endif; ?>

            <?php if ( ! empty( $box['link'] ) ) : ?>
                <a href="<?php echo wp_kses( $box['link'], wp_kses_allowed_html( 'post' ) ); ?>" class="box-read-more">
                    <?php echo esc_attr__( 'Read More', 'inventor-boxes' ); ?>
                </a>
            <?php endif; ?>
        </div><!-- /.box-body -->
    </div><!-- /.box-inner -->

    <?php if ( ! empty( $box['background_image'] ) ) : ?>
        <div class="box-layer" style="background-image: url('<?php echo esc_attr( $box['background_image'] ); ?>');">
        </div><!-- /.box-layer -->
    <?php endif; ?>
</div><!-- /.box -->