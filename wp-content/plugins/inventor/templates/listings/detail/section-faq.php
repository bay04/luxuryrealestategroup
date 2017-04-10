<?php $faqs = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'faq', true );?>

<?php if ( ! empty( $faqs ) && is_array( $faqs ) && ! empty ( $faqs[0] ) ) : ?>
    <div class="listing-detail-section" id="listing-detail-section-faq">
        <h2 class="page-header"><?php echo $section_title; ?></h2>

        <dl class="listing-detail-section-faq-list">
            <?php foreach ( $faqs as $faq ) : ?>
                <dt><?php echo esc_attr( $faq[ INVENTOR_LISTING_PREFIX . 'question' ] ); ?></dt>
                <dd><?php echo esc_attr( $faq[ INVENTOR_LISTING_PREFIX . 'answer' ] ); ?></dd>
            <?php endforeach; ?>
        </dl>
    </div><!-- /.listing-detail-section -->
<?php endif; ?>