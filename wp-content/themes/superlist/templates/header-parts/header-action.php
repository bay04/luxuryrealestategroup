<?php if ( get_theme_mod( 'superlist_general_action' ) ) : ?>
    <div class="header-action">
        <a href="<?php echo esc_attr( get_permalink( get_theme_mod( 'superlist_general_action' ) ) ); ?>" class="header-action-inner" title="<?php echo esc_attr( get_theme_mod( 'superlist_general_action_text' ) ); ?>" data-toggle="tooltip" data-placement="left">
            <i class="fa fa-plus"></i>

            <span>
                <?php echo esc_attr( get_theme_mod( 'superlist_general_action_text' ) ); ?>
            </span>
        </a><!-- /.header-action-inner -->
    </div><!-- /.header-action -->
<?php endif; ?>