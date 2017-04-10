<?php if ( has_post_thumbnail() ) : ?>
    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
    <?php $image = $thumbnail[0]; ?>
<?php else: ?>
    <?php $image = esc_attr( plugins_url( 'inventor' ) ) . '/assets/img/default-item.png'; ?>
<?php endif; ?>

<div class="listing-box" style="background-image: url('<?php echo esc_attr( $image ); ?>');">
    <a href="<?php the_permalink() ?>" class="listing-box-content-link"></a>

    <div class="listing-box-background">
        <div class="listing-box-content">

            <?php do_action( 'inventor_listing_content', get_the_ID(), 'box' ); ?>

            <div class="listing-box-actions">
                <?php do_action( 'inventor_listing_actions', get_the_ID(), 'box' ); ?>
            </div><!-- /.listing-box-actions -->
        </div><!-- /.listing-box-content -->

        <?php $listing_category = Inventor_Query::get_listing_category_name(); ?>

        <?php if ( ! empty( $listing_category ) ) : ?>
            <div class="listing-box-label-top">
                <?php $icon = Inventor_Post_Type_Listing::get_icon( get_the_ID(), true, true ); ?>
                <?php if ( ! empty( $icon ) ) : ?>
                    <?php echo $icon; ?>
                <?php endif; ?>

                <?php echo wp_kses( $listing_category, wp_kses_allowed_html( 'post' ) ); ?>
            </div>
        <?php endif; ?>

        <?php $location = Inventor_Query::get_listing_location_name(); ?>
        <?php if ( ! empty( $location ) ) : ?>
            <div class="listing-box-label-bottom"><?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?></div>
        <?php endif; ?>
    </div><!-- /.listing-box-background -->
    <span class="listing-box-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </span><!-- /.listing-box-title -->
</div><!-- /.listing-box -->
