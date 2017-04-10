<?php $messages = Inventor_Utilities::get_messages(); ?>

<?php if ( ! empty( $messages ) && is_array( $messages ) ) : ?>
    <div class="alerts">
        <?php foreach ( $messages as $message ) : ?>
            <div class="alert-primary alert alert-dismissible alert-<?php echo esc_attr( $message[0] ); ?>">
                <div class="alert-inner">
                    <div class="container">
                        <?php echo wp_kses( $message[1], wp_kses_allowed_html( 'post' ) ); ?>

                        <button type="button" class="close" data-dismiss="alert"><i class="fa fa-close"></i></button>
                    </div>
                </div><!-- /.alert-inner -->
            </div><!-- /.alert -->
        <?php endforeach; ?>
    </div><!-- /.alerts -->

    <script>Cookies.remove('messages');</script>
<?php endif; ?>
