<?php if ( apply_filters( 'inventor_metabox_allowed', true, 'video', get_the_author_meta('ID') ) ): ?>
    <?php $video = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'video', true ); ?>
    <?php if ( ! empty( $video ) ) : ?>
        <div class="listing-detail-section" id="listing-detail-section-video">
            <h2 class="page-header"><?php echo $section_title; ?></h2>
            <div class="video-embed-wrapper <?php echo substr( $video, -strlen('.mp4') ) === '.mp4' ? 'mp4' : ''; ?>">
                <?php echo apply_filters( 'the_content', '[embed width="1280" height="720"]' . esc_attr( $video ) . '[/embed]' ); ?>
            </div><!-- /.video-embed-wrapper -->
        </div><!-- /.listing-detail-section -->
    <?php endif; ?>
<?php endif; ?>