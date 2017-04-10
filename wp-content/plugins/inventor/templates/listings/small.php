<div class="listing-small">
    <?php if ( has_post_thumbnail() ) : ?>
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
        <div class="listing-small-image" style="background-image: url('<?php echo $image[0]; ?>');">
            <a href="<?php the_permalink(); ?>"></a>
        </div><!-- /.listing-small-image -->
    <?php else : ?>
        <div class="listing-small-image" style="background-image: url('<?php echo plugins_url( 'inventor' ); ?>/assets/img/default-item.png');">
            <a href="<?php the_permalink(); ?>"></a>
        </div><!-- /.listing-small-image -->
    <?php endif; ?>

    <div class="listing-small-content">
        <h4 class="listing-small-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

        <?php $location = Inventor_Query::get_listing_location_name( get_the_ID(), '/', false ); ?>
        <?php if ( ! empty( $location ) ) : ?>
            <div class="listing-small-location"><?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?></div>
        <?php endif; ?>

        <?php $price = Inventor_Price::get_price(); ?>
        <?php if ( ! empty( $price ) ) : ?>
            <div class="listing-small-price"><?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?></div>
        <?php endif; ?>
    </div><!-- /.listing-small-content -->
</div><!-- /.listing-small -->
