<?php if ( empty( $listing ) ): ?>
    <div class="alert alert-warning">
        <?php echo __( 'You have to specify listing!', 'inventor-submission' ) ?>
    </div>
<?php else: ?>
    <h3><?php echo sprintf( __( "Are you sure you want to delete %s?", 'inventor-submission' ), get_the_title( $listing ) ); ?></h3>

    <?php $submission_list_page = get_theme_mod( 'inventor_submission_list_page', false ); ?>
    <?php $action = empty( $submission_list_page ) ? get_home_url() : get_permalink( $submission_list_page ); ?>

    <form method="post" action="<?php echo $action ?>">
        <input type="hidden" name="listing_id" value="<?php echo $listing->ID; ?>">

        <div class="button-wrapper">
            <button type="submit" class="btn btn-danger" name="remove_listing_form"><?php echo __( 'Delete', 'inventor-submission' ); ?></button>
        </div><!-- /.button-wrapper -->
    </form>
<?php endif; ?>