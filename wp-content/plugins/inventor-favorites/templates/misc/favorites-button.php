<?php if ( Inventor_Favorites_Logic::is_my_favorite( $listing_id ) ) : ?>
    <a href="#" class="inventor-favorites-btn-toggle heart marked" data-listing-id="<?php echo $listing_id; ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
        <i class="fa fa-heart-o"></i> <span data-toggle="<?php echo __( 'Add to favorites', 'inventor-favorites' ); ?>"><?php echo __( 'I Love It', 'inventor-favorites' ); ?></span>
    </a><!-- /.inventor-favorites-btn-toggle -->
<?php else: ?>
    <a href="#" class="inventor-favorites-btn-toggle heart" data-listing-id="<?php echo $listing_id; ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
        <i class="fa fa-heart-o"></i> <span data-toggle="<?php echo __( 'I Love It', 'inventor-favorites' ); ?>"><?php echo __( 'Add to favorites', 'inventor-favorites' ); ?></span>
    </a><!-- /.inventor-favorites-btn-toggle -->
<?php endif ; ?>