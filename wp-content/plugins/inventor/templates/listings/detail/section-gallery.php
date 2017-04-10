<?php if ( apply_filters( 'inventor_metabox_allowed', true, 'gallery', get_the_author_meta('ID') ) ): ?>
    <?php $gallery = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'gallery', true ); ?>

    <?php if ( get_theme_mod( 'inventor_general_show_featured_image_in_gallery', false ) ): ?>
        <?php $gallery = is_array( $gallery ) ? $gallery : array(); ?>
        <?php $featured_image_id = get_post_thumbnail_id( get_the_ID() ); ?>
        <?php $featured_image_src = wp_get_attachment_url( $featured_image_id ); ?>
        <?php if ( ! empty( $featured_image_id ) && ! empty( $featured_image_src ) ) : ?>
            <?php $gallery = array( $featured_image_id => $featured_image_src ) + $gallery; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ( ! empty( $gallery ) && is_array( $gallery ) ) : ?>
        <div class="listing-detail-section" id="listing-detail-section-gallery">
            <h2 class="page-header"><?php echo $section_title; ?></h2>

            <div class="listing-detail-gallery-wrapper">
                <div class="listing-detail-gallery">
                    <?php $index = 0; ?>
                    <?php foreach ( $gallery as $id => $src ) : ?>
                        <?php $img = wp_get_attachment_image_src( $id, 'large' ); ?>
                        <?php $src = $img[0]; ?>
                        <a href="<?php echo esc_url( $src ); ?>" rel="listing-gallery" data-item-id="<?php echo esc_attr( $index++ ); ?>">
                            <span class="item-image" data-background-image="<?php echo esc_url( $src ); ?>"></span><!-- /.item-image -->
                        </a>
                    <?php endforeach; ?>
                </div><!-- /.listing-detail-gallery -->

                <div class="listing-detail-gallery-preview" data-count="<?php echo count( $gallery ) ?>">
                    <div class="listing-detail-gallery-preview-inner">
                        <?php $index = 0; ?>
                        <?php foreach ( $gallery as $id => $src ) : ?>
                            <div data-item-id="<?php echo esc_attr( $index++ ); ?>">
                                <?php $img = wp_get_attachment_image_src( $id, 'thumbnail' ); ?>
                                <?php $img_src = $img[0]; ?>
                                <img src="<?php echo $img_src; ?>" alt="<?php the_title(); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div><!-- /.listing-detail-gallery-preview-inner -->
                </div><!-- /.listing-detail-gallery-preview -->
            </div><!-- /.listing-detail-gallery-wrapper -->
        </div><!-- /.listing-detail-section -->
    <?php endif; ?>
<?php endif; ?>