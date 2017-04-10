<?php //echo wp_kses( do_shortcode( '[inventor_breadcrumb]' ), wp_kses_allowed_html( 'post' ) ); ?>

<?php do_action( 'inventor_before_listing_detail', get_the_ID() ); ?>

<div class="listing-detail">
    <?php Inventor_Post_Types::render_listing_detail_sections(); ?>
</div><!-- /.listing-detail -->

<?php do_action( 'inventor_after_listing_detail', get_the_ID() ); ?>