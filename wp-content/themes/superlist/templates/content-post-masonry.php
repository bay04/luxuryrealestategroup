<div class="post-masonry-content">
    <?php if ( has_post_thumbnail() ) : ?>
        <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
        <?php $image = $thumbnail[0]; ?>
    <?php else: ?>
        <?php $image = esc_attr( plugins_url( 'inventor' ) ) . '/assets/img/default-item.png'; ?>
    <?php endif; ?>

    <!--        --><?php //if ( has_post_thumbnail() ) : ?>
    <div class="post-image" style="background-image: url('<?php echo esc_attr( $image ); ?>');">
        <a href="<?php the_permalink() ?>"></a>
    </div><!-- /.listing-column-image-->
    <!--        --><?php //endif; ?>

    <?php if ( has_category() ) : ?>
        <div class="post-meta-categories">
            <?php echo wp_kses( get_the_category_list( ', ' ), wp_kses_allowed_html( 'post' ) ); ?>
        </div><!-- /.listing-column-content -->
    <?php endif; ?>

    <div class="post-content">
        <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
        <?php the_excerpt(); ?>
    </div><!-- /.listing-column-title -->

    <div class="post-meta">
        <div class="post-meta-date"><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></div><!-- /.post-meta-date -->

        <?php if ( comments_open() ): ?>
            <div class="post-meta-comments"><i class="fa fa-comments"></i> <?php comments_number(); ?></div><!-- /.post-meta-comments -->
        <?php endif; ?>
    </div>
</div>