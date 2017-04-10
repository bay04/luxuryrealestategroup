<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * The template for displaying dashboard
 *
 * Template name: Infinite Scroll (Test)
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

get_header(); ?>


<?php 
if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
	$paged = get_query_var('page');
} else {
	$paged = 1;
}

query_posts( array( 'post_type' => 'property', 'paged' => $paged, 'posts_per_page' => 2 ) );
if ( have_posts() ) : $count = 0; ?>

<div class="row">
    <div class="col-sm-12">

        <div id="primary">

           <h2 class="home_listings_title">Freshly Listed</h2> 
           
            <div class="listings-row home_listings_row">

        		<?php while ( have_posts() ) : the_post(); $count++; ?>
                    <div class="listing-container listing-row">
                        
                            <div class="home_listing_author">
                                <?php $id = get_the_author_meta( 'ID' ); ?>
                                <?php $image = Inventor_Post_Type_User::get_user_image( $id ); ?>
                                <?php $name = Inventor_Post_Type_User::get_full_name( $id ); ?>
                                
                                <div class="listing-author">
                                    <?php if ( ! empty( $image ) ) : ?>
                                        <a href="<?php echo get_author_posts_url( $id ); ?>" class="listing-author-image">
                                            <img src="<?php echo esc_attr( $image ); ?>" alt="">
                                        </a><!-- /.listing-author-image -->
                                    <?php endif; ?>

                                    <?php if ( ! empty( $name ) ) : ?>
                                        <div class="listing-author-name">
                                            <a href="<?php echo get_author_posts_url( $id ); ?>">
                                                <?php echo esc_attr( $name ) ; ?>
                                            </a>
                                        </div><!-- /.listing-author-name -->
                                    <?php endif; ?>
                                </div><!-- /.listing-author -->

                            </div><!-- /.home_listing_author -->

                            <div style="clear:both; float: none"></div>                            

                            <div class="home_listing_image">
                                 <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail(); ?>
                                 </a> 
                            </div><!-- /.home_listing_image -->


                            <div class="home_listing_info">
                            <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a> 
                                <?php $attributes = Inventor_Post_Types::get_attributes(); ?>

                                <?php if ( ! empty( $attributes ) && is_array( $attributes ) && count( $attributes ) > 0 ) : ?>
                                    <div class="listing-detail-section" id="listing-detail-section-attributes">
                                        <h2 class="page-header"><?php echo $section_title; ?></h2>

                                        <div class="listing-detail-attributes">
                                            <ul>
                                                <?php foreach( $attributes as $key => $attribute ) : ?>
                                                    <li class="<?php echo esc_attr( $key ); ?>">
                                                        <strong class="key"><?php echo wp_kses( $attribute['name'], wp_kses_allowed_html( 'post' ) ); ?></strong>
                                                        <span class="value"><?php echo wp_kses( $attribute['value'], wp_kses_allowed_html( 'post' ) ); ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div><!-- /.listing-detail-attributes -->
                                    </div><!-- /.listing-detail-section -->
                                <?php endif; ?>
                             </div><!-- /.home_listing_info -->                                         
                        
                    </div><!-- /.listing-container -->
           		<?php endwhile; else: ?>

           			<div class="post">
					 	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
					 </div><!-- /.post -->
					 
				<?php endif; ?>

            </div><!-- /.listings-row -->           				 

            <?php do_action( 'inventor_after_listing_archive' ); ?>
                
            <?php the_posts_pagination( array(
                'prev_text'             => __( 'Previous', 'inventor' ),
                'next_text'             => __( 'Next', 'inventor' ),
                'mid_size'              => 2,
                ) ); ?>
            
        </div><!-- /#primary -->

    </div><!-- /.col-* -->
   
</div><!-- /.row -->

<?php wp_reset_query(); ?>

<?php get_footer(); ?>
