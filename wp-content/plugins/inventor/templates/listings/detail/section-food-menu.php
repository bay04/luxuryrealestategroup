<?php $groups = Inventor_Post_Type_Food::get_menu_groups(); ?>

<?php if ( ! empty( $groups ) ) : ?>
    <div class="listing-detail-section" id="listing-detail-section-meals-and-drinks">
        <h2 class="page-header"><?php echo $section_title; ?></h2>

        <div class="listing-detail-food-wrapper">
            <?php if ( ! empty( $groups['daily_menu'] ) && is_array( $groups['daily_menu'] ) && count( $groups['daily_menu'] ) > 0 ) : ?>
                <h3 class="listing-detail-section-subtitle"><span><?php echo esc_attr__( 'Daily Menu', 'inventor' ); ?></span></h3>

                <div class="listing-detail-food-inner">
                    <?php foreach( $groups['daily_menu'] as $meal ) : ?>
                        <?php echo Inventor_Template_Loader::load( 'post-types/food/menu-item', array(
                            'meal' => $meal,
                        ) ); ?>
                    <?php endforeach ?>
                </div><!-- /.listing-detail-food-inner -->
            <?php endif; ?>

            <?php $last_section = false; ?>

            <?php if ( ! empty( $groups['menu'] ) && is_array( $groups['menu'] ) && count( $groups['menu'] ) > 0 ) : ?>
                <div class="listing-detail-food-inner">
                    <?php foreach( $groups['menu'] as $meal ) : ?>
                        <?php $meal_section = empty( $meal['listing_food_menu_section_name'] ) ? esc_attr__( 'Menu', 'inventor' ) : $meal['listing_food_menu_section_name']; ?>

                        <?php if ( $last_section != $meal_section ): ?>
                            <?php $last_section = $meal_section; ?>
                            <h3 class="listing-detail-section-subtitle"><span><?php echo $last_section; ?></span></h3>
                        <?php endif; ?>

                        <?php echo Inventor_Template_Loader::load( 'post-types/food/menu-item', array(
                            'meal' => $meal,
                        ) ); ?>
                    <?php endforeach ?>
                </div><!-- /.listing-detail-food-inner -->
            <?php endif; ?>
        </div><!-- /.listing-detail-food-wrapper  -->
    </div><!-- /.listing-detail-section -->
<?php endif; ?>