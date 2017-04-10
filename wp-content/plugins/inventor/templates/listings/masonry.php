<?php if ( has_post_thumbnail() ) : ?>
    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
    <?php $image = $thumbnail[0]; ?>
<?php else: ?>
    <?php $image = esc_attr( plugins_url( 'inventor' ) ) . '/assets/img/default-item.png'; ?>
<?php endif; ?>

<div class="listing-masonry" style="background-image: url('<?php echo esc_attr( $image ); ?>');">
    <a href="<?php the_permalink(); ?>" class="listing-masonry-content-link"></a>
    <div class="listing-masonry-background">
        <div class="listing-masonry-content">
            <h2 class="listing-masonry-title"><?php the_title(); ?></h2>

            <?php $location = Inventor_Query::get_listing_location_name( get_the_ID(), '/' ); ?>
            <?php if ( ! empty( $location ) ) : ?>
                <div class="listing-masonry-meta">
                    <?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
                </div><!-- /.card-meta -->
            <?php endif; ?>

            <?php do_action( 'inventor_listing_content', get_the_ID(), 'masonry' ); ?>

            <div class="listing-masonry-actions">
                <?php do_action( 'inventor_listing_actions', get_the_ID(), 'masonry' ); ?>
            </div><!-- /.listing-masonry-actions -->
        </div><!-- /.listing-masonry-content -->

        <?php $listing_category = Inventor_Query::get_listing_category_name(); ?>

        <?php if ( ! empty( $listing_category ) ) : ?>
            <div class="listing-masonry-label-top">
                <?php $icon = Inventor_Post_Type_Listing::get_icon( get_the_ID(), true, true ); ?>
                <?php if ( ! empty( $icon ) ) : ?>
                    <?php echo $icon; ?>
                <?php endif; ?>

                <?php echo wp_kses( $listing_category, wp_kses_allowed_html( 'post' ) ); ?>
            </div>
        <?php endif; ?>

    </div><!-- /.listing-masonry-background -->
</div><!-- /.listing-masonry -->
