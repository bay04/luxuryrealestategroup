<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page = empty( $instance[ 'front_page' ] ) ? '' : $instance[ 'front_page' ];
$listing_detail = empty( $instance[ 'listing_detail' ] ) ? '' : $instance[ 'listing_detail' ];
$listing_archive = empty( $instance[ 'listing_archive' ] ) ? '' : $instance[ 'listing_archive' ];
$listing_taxonomies = empty( $instance[ 'listing_taxonomies' ] ) ? '' : $instance[ 'listing_taxonomies' ];
$pages = empty( $instance[ 'pages' ] ) ? '' : $instance[ 'pages' ];
?>

<div class="widget widget-advanced-options">
    <div class="widget-top" style="background-color: transparent;">
        <div class="widget-title" style="cursor: pointer;">
            <h4 style="color: #333"><span class="dashicons dashicons-admin-post" style="margin: -3px 0px -4px -2px; font-size: 18px;"></span> <?php echo __( 'Visibility', 'inventor' ); ?></h4>
        </div>
    </div>
    <div class="widget-inside">
        <p>
            <?php echo __( 'Using following settings you can specify, on which pages will be widget shown.', 'inventor' ); ?>
        </p>
        <small>
            <i><?php echo __( 'If none of the following is set, widget will be visible by default.', 'inventor' ); ?></i>
        </small>
        <hr>
        <!-- FRONT PAGE -->
        <p>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'front_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'front_page' ) ); ?>" type="checkbox" value=1 <?php checked( $front_page, 1 ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'front_page' ) ); ?>">
                <?php echo __( 'Front page', 'inventor' ); ?>
            </label>
        </p>

        <!-- LISTING DETAIL -->
        <p>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'listing_detail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'listing_detail' ) ); ?>" type="checkbox" value=1 <?php checked( $listing_detail, 1 ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'listing_detail' ) ); ?>">
                <?php echo __( 'Listing detail', 'inventor' ); ?>
            </label>
        </p>

        <!-- LISTING ARCHIVE -->
        <p>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'listing_archive' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'listing_archive' ) ); ?>" type="checkbox" value=1 <?php checked( $listing_archive, 1 ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'listing_archive' ) ); ?>">
                <?php echo __( 'Listing archive', 'inventor' ); ?>
            </label>
        </p>

        <!-- LISTING TAXONOMIES -->
        <p>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'listing_taxonomies' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'listing_taxonomies' ) ); ?>" type="checkbox" value=1 <?php checked( $listing_taxonomies, 1 ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'listing_taxonomies' ) ); ?>">
                <?php echo __( 'Listing taxonomies', 'inventor' ); ?>
            </label>
        </p>

        <!-- PAGES -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'pages' ) ); ?>">
                <?php echo __( 'Pages', 'inventor' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pages' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pages' ) ); ?>" type="text" value="<?php echo esc_attr( $pages ); ?>">
            <br>
            <small><?php echo __( 'Page slugs delimited by comma e.g. <i>image-cover,listing-slider</i>', 'inventor' ); ?></small>
        </p>
    </div><!-- /.widget-inside -->
</div><!-- /.widget -->