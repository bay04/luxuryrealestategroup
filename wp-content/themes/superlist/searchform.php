<?php
/**
 * The template for displaying search form
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

?>

<?php $query = ! empty( $_GET['s'] ) ? esc_attr( $_GET['s'] ) : ''; // Input var okay; sanitization okay. ?>

<form method="get" class="form-search site-search" action="<?php echo esc_attr( site_url() ); ?>">
	<div class="input-group">
		<input class="search-query form-control" placeholder="<?php echo esc_attr__( 'Search ...', 'superlist' ); ?>" type="text" name="s" id="s" value="<?php echo esc_attr( $query ); ?>">

         <span class="input-group-btn">
            <button type="submit"><i class="fa fa-search"></i></button>
         </span><!-- /.input-group-btn -->
	</div><!-- /.input-group -->
</form><!-- /.site-search -->
