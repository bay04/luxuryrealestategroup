<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$receive_admin = ! empty( $instance['receive_admin'] ) ? $instance['receive_admin'] : '';
$receive_author = ! empty( $instance['receive_author'] ) ? $instance['receive_author'] : '';
$receive_listing_email = ! empty( $instance['receive_listing_email'] ) ? $instance['receive_listing_email'] : '';
$show_name = empty( $instance['show_name'] ) ? '' : 'on';
$show_email = empty( $instance['show_email'] ) ? '' : 'on';
$show_phone = empty( $instance['show_phone'] ) ? '' : 'on';
$show_subject = empty( $instance['show_subject'] ) ? '' : 'on';
$show_date = empty( $instance['show_date'] ) ? '' : 'on';
$show_message = empty( $instance['show_message'] ) ? '' : 'on';
$show_recaptcha = empty( $instance['show_recaptcha'] ) || ! class_exists( 'Inventor_Recaptcha' ) ? '' : 'on';
?>

<!-- TITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo __( 'Title', 'inventor' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $title ); ?>">
</p>


<p><strong><?php echo __( 'Form fields', 'inventor' ); ?></strong></p>

<p>
	<!-- NAME  -->
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $show_name ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'show_name' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'show_name' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'show_name' ) ); ?>">
		<?php echo __( 'Name', 'inventor' ); ?>
	</label>

	<br>

	<!-- EMAIL -->
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $show_email ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'show_email' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'show_email' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'show_email' ) ); ?>">
		<?php echo __( 'E-mail', 'inventor' ); ?>
	</label>

	<br>

	<!-- PHONE -->
	<input  type="checkbox"
			class="checkbox"
		<?php echo ! empty( $show_phone ) ? 'checked="checked"' : ''; ?>
			id="<?php echo esc_attr( $this->get_field_id( 'show_phone' ) ); ?>"
			name="<?php echo esc_attr( $this->get_field_name( 'show_phone' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'show_phone' ) ); ?>">
		<?php echo __( 'Phone', 'inventor' ); ?>
	</label>

	<br>

	<!-- SUBJECT -->
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $show_subject ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'show_subject' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'show_subject' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'show_subject' ) ); ?>">
		<?php echo __( 'Subject', 'inventor' ); ?>
	</label>

	<br>

	<!-- DATE -->
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $show_date ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>">
		<?php echo __( 'Date', 'inventor' ); ?>
	</label>

	<br>

	<!-- MESSAGE -->
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $show_message ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'show_message' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'show_message' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'show_message' ) ); ?>">
		<?php echo __( 'Message', 'inventor' ); ?>
	</label>

	<br>

	<?php if ( class_exists( 'Inventor_Recaptcha' ) ): ?>
		<!-- RECAPTCHA -->
		<input  type="checkbox"
				class="checkbox"
			<?php echo ! empty( $show_recaptcha ) ? 'checked="checked"' : ''; ?>
				id="<?php echo esc_attr( $this->get_field_id( 'show_recaptcha' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'show_recaptcha' ) ); ?>">

		<label for="<?php echo esc_attr( $this->get_field_id( 'show_recaptcha' ) ); ?>">
			<?php echo 'reCAPTCHA'; ?>
		</label>
	<?php endif; ?>
</p>

<p>
	<!-- RECEIVE ADMIN -->
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $receive_admin ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'receive_admin' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'receive_admin' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'receive_admin' ) ); ?>">
		<?php echo __( 'Site admin', 'inventor' ); ?>
	</label>

	<br>

	<!-- RECEIVE AUTHOR -->
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $receive_author ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'receive_author' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'receive_author' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'receive_author' ) ); ?>">
		<?php echo __( 'Listing author', 'inventor' ); ?>
	</label>

	<br>

	<!-- RECEIVE LISTING EMAIL -->
	<input  type="checkbox"
	        class="checkbox"
		<?php echo ! empty( $receive_listing_email ) ? 'checked="checked"' : ''; ?>
		    id="<?php echo esc_attr( $this->get_field_id( 'receive_listing_email' ) ); ?>"
		    name="<?php echo esc_attr( $this->get_field_name( 'receive_listing_email' ) ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'receive_listing_email' ) ); ?>">
		<?php echo __( 'Listing email', 'inventor' ); ?>
	</label>

	<br>

	<small><?php echo __( 'If none selected, post author will receive an email by default.', 'inventor' ); ?></small>
</p>
