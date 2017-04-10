<ol class="breadcrumb">
    <?php if ( is_front_page() ) : ?>
        <li><a href="<?php echo home_url(); ?>"><?php echo __( 'Home', 'inventor' ); ?></a></li>
        <li><a href="<?php echo home_url(); ?>"><?php echo strip_tags( html_entity_decode ( get_bloginfo( 'name' ) ) ); ?></a></li>
    <?php elseif ( is_home() ) : ?>
        <li><a href="<?php echo home_url(); ?>"><?php echo __( 'Home', 'inventor' ); ?></a></li>
        <li><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></li>
    <?php elseif ( ! is_home() ) : ?>
        <li><a href="<?php echo home_url(); ?>"><?php echo __( 'Home', 'inventor' ); ?></a></li>

        <?php if ( is_archive() && is_tax() ) : ?>
            <?php if ( is_tax() ) : ?>
			    <?php if ( is_tax( Inventor_Taxonomies::get_listing_taxonomies() ) ) : ?>
				    <li><a href="<?php echo get_post_type_archive_link( 'listing' ); ?>"><?php echo __( 'Listings', 'inventor' ); ?></a></li>
			    <?php endif; ?>

                <?php
                global $wp_query;
                $tax = $wp_query->get_queried_object();
                $term = get_term_by( 'slug', $tax->slug, $tax->taxonomy );
                $ancestors = get_ancestors( $term->term_id, $tax->taxonomy );
                ?>

                <?php if ( is_array( $ancestors ) ) : ?>
                    <?php foreach ( array_reverse( $ancestors ) as $ancestor ) : ?>
                        <li>
                            <?php $term = get_term( $ancestor, $tax->taxonomy ); ?>
                            <a href="<?php echo get_term_link( $term->term_id, $tax->taxonomy ); ?>"><?php echo esc_attr( $term->name ); ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>

                <li><?php echo single_cat_title(); ?></li>
            <?php else : ?>
                <li><?php echo single_cat_title(); ?></li>
            <?php endif; ?>
        <?php elseif ( is_category() ) : ?>
            <li>
                <a href="<?php echo get_post_type_archive_link( get_post_type() ); ?>">
                    <?php echo get_post_type_object( get_post_type() )->labels->name; ?>
                </a>
            </li>

            <li><?php single_cat_title(); ?></li>
        <?php elseif ( is_archive() ) : ?>
		    <?php if ( class_exists( 'Inventor_Post_Types' ) ) : ?>
			    <?php if ( is_post_type_archive( Inventor_Post_Types::get_listing_post_types( true ) ) ) : ?>
				    <li><a href="<?php echo get_post_type_archive_link( 'listing' ); ?>"><?php echo __( 'Listings', 'inventor' ); ?></a></li>

				    <?php if ( ! is_post_type_archive( 'listing' ) ) : ?>
				        <li><?php post_type_archive_title(); ?></li>
				    <?php endif; ?>
			    <?php else : ?>
				    <li><?php post_type_archive_title(); ?></li>
			    <?php endif; ?>
	        <?php else : ?>
	            <li><?php post_type_archive_title(); ?></li>
	        <?php endif; ?>
        <?php endif; ?>

        <?php if ( is_category() || is_single() ) : ?>
            <?php if ( is_singular( Inventor_Post_Types::get_listing_post_types() ) ) : ?>
                <li>                
                    <?php $obj = get_post_type_object( 'listing' ); ?>

                    <a href="<?php echo get_post_type_archive_link( 'listing' ); ?>">
                        <?php echo esc_attr( $obj->labels->name ); ?>
                    </a>
                </li>

                <li>                
                    <?php $obj = get_post_type_object( get_post_type() ); ?>

                    <a href="<?php echo get_post_type_archive_link( get_post_type() ); ?>">
                        <?php echo esc_attr( $obj->labels->name ); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( is_single() ) : ?>
                <li><?php the_title(); ?></li>
            <?php endif; ?>
        <?php elseif ( is_404() ) : ?>
            <li><?php echo __( 'Page not found', 'inventor' ); ?></li>
        <?php elseif ( is_page() ) :   ?>
            <li><?php the_title(); ?></li>
        <?php endif; ?>
    <?php elseif ( is_tag() ) : ?>
        <li><?php single_tag_title() ?></li>
    <?php elseif ( is_day() ) : ?>
        <li><?php echo __( 'Archive for', 'inventor' ); ?>  <?php the_time( 'F jS, Y' ); ?></li>
    <?php elseif ( is_month() ) :   ?>
        <li><?php echo __( 'Archive for', 'inventor' ); ?>  <?php the_time( 'F, Y' ); ?></li>
    <?php elseif ( is_year() ) : ?>
        <li><?php echo __( 'Archive for', 'inventor' ); ?>  <?php the_time( 'Y' ); ?></li>
    <?php elseif ( is_author() ) :   ?>
        <li><?php echo __( 'Author Archive', 'inventor' ); ?></li>
    <?php elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) : ?>
        <li><?php echo __( 'Blog Archives', 'inventor' ); ?></li>
    <?php elseif ( is_search() ) : ?>
        <li><?php echo __( 'Search Results', 'inventor' ); ?></li>
    <?php endif; ?>
</ol>