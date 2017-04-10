<?php $count = count( $collections ); ?>

<div id="collection-pickup" data-collections='<?php echo json_encode( $collections ); ?>'>
    <p>
        <?php echo __( 'Choose collection:', 'inventor-favorites' ); ?>
        <span class="close"></span>
    </p>

    <ul>
        <?php foreach ( $collections as $collection_id => $collection_data ): ?>
            <?php $collection_title = $collection_data['title']; ?>
            <?php $collection_listings = $collection_data['listings']; ?>
            <li>
                <?php echo esc_attr( $collection_title ) ?>
                <a href="#?collection-id=<?php echo $collection_id; ?>" class="heart" data-collection-id="<?php echo $collection_id; ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                    <i class="fa fa-heart-o"></i>
                </a><!-- /.heart -->
            </li>
        <?php endforeach; ?>
    </ul><!-- /.collections -->
</div><!-- /.collection-pickup -->