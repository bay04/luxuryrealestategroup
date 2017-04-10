<?php $favorites_page_id = get_theme_mod( 'inventor_favorites_page', null ); ?>

<form method="post" <?php if ( ! empty( $favorites_page_id ) ) : ?>action="<?php echo get_the_permalink( $favorites_page_id ) ?>"<?php endif; ?>>

    <div class="row">
        <div class="form-group col-md-4">
            <input class="form-control" name="collection_title" type="text" placeholder="<?php echo __( 'Title', 'inventor-favorites' ); ?>" required="required">
        </div><!-- /.form-group -->
    </div><!-- /.row -->

    <?php if ( class_exists( 'Inventor_Recaptcha' ) ) : ?>
        <?php if ( Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) : ?>
            <div id="recaptcha-<?php echo esc_attr( get_the_ID() ); ?>" class="g-recaptcha" data-sitekey="<?php echo get_theme_mod( 'inventor_recaptcha_site_key' ); ?>"></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="button-wrapper">
        <button type="submit" class="btn btn-primary" name="collection_form"><?php echo __( 'Submit', 'inventor-favorites' ); ?></button>
    </div><!-- /.button-wrapper -->
</form>