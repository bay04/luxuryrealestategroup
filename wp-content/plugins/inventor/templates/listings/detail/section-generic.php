<?php if ( apply_filters( 'inventor_metabox_allowed', true, $metabox_key, get_the_author_meta('ID') ) ): ?>
    <?php $section_content = ''; ?>

    <?php foreach( $fields as $field ): ?>
        <?php $value = Inventor_Post_Types::get_field_value( $field, get_the_ID(), 'section' ); ?>

        <?php if ( ! empty( $value ) && $field['skip'] ): ?>
            <?php $section_content .= '<h3 class="listing-detail-section-subtitle '. esc_attr( $field['id'] ) .'">' . esc_attr( $field['name'] ) .'</h3>'; ?>
            <?php $section_content .= '<p class="'. esc_attr( $field['id'] ) .' '. esc_attr( $field['type'] ) .'">'. $value .'</p>'; ?>
        <?php endif; ?>

    <?php endforeach; ?>

    <?php if ( ! empty( $section_content ) ): ?>
        <div class="listing-detail-section listing-detail-section-generic" id="listing-detail-section-<?php echo $metabox_key; ?>">
            <h2 class="page-header"><?php echo $section_title; ?></h2>

            <div class="listing-detail-section-content-wrapper">
                <?php echo $section_content; ?>
            </div>
        </div><!-- /.listing-detail-section -->
    <?php endif; ?>
<?php endif; ?>