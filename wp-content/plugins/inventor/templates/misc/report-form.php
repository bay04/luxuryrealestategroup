<?php if ( empty( $listing ) ): ?>
    <div class="alert alert-warning">
        <?php echo __( 'You have to specify listing!', 'inventor' ) ?>
    </div>
<?php else: ?>
    <h3><?php echo sprintf( __( "What's wrong with %s?", 'inventor' ), get_the_title( $listing ) ); ?></h3>

    <form method="post" action="<?php echo get_the_permalink( $listing ) ?>">
        <input type="hidden" name="listing_id" value="<?php echo $listing->ID; ?>">

        <div class="form-group">
            <div class="radio">
                <label for="spam">
                    <input type="radio" name="reason" id="spam" required value="<?php echo __( 'It is spam', 'inventor' ); ?>">
                    <?php echo __( 'It is spam', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->

            <div class="radio">
                <label for="nudity">
                    <input type="radio" name="reason" id="nudity" required value="<?php echo __( 'It is nudity or pornography', 'inventor' ); ?>">
                    <?php echo __( 'It is nudity or pornography', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->

            <div class="radio">
                <label for="humiliation">
                    <input type="radio" name="reason" id="humiliation" required value="<?php echo __( 'It humiliates somebody', 'inventor' ); ?>">
                    <?php echo __( 'It humiliates somebody', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->

            <div class="radio">
                <label for="inappropriate">
                    <input type="radio" name="reason" id="inappropriate" required value="<?php echo __( 'It is inappropriate', 'inventor' ); ?>">
                    <?php echo __( 'It is inappropriate', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->

            <div class="radio">
                <label for="attack">
                    <input type="radio" name="reason" id="attack" required value="<?php echo __( 'It insults or attacks someone based on their religion, ethnicity or sexual orientation', 'inventor' ); ?>">
                    <?php echo __( 'It insults or attacks someone based on their religion, ethnicity or sexual orientation', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->            

            <div class="radio">
                <label for="violence">
                    <input type="radio" name="reason" id="violence" required value="<?php echo __( 'It advocates violence or harm to a person or animal', 'inventor' ); ?>">
                    <?php echo __( 'It advocates violence or harm to a person or animal', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->

            <div class="radio">
                <label for="harming">
                    <input type="radio" name="reason" id="harming" required value="<?php echo __( 'It displays someone harming themself or planning to harm themself', 'inventor' ); ?>">
                    <?php echo __( 'It displays someone harming themself or planning to harm themself', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->

            <div class="radio">
                <label for="drugs">
                    <input type="radio" name="reason" id="drugs" required value="<?php echo __( 'It describes buying or selling drugs, guns or regulated products', 'inventor' ); ?>">
                    <?php echo __( 'It describes buying or selling drugs, guns or regulated products', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->


            <div class="radio">
                <label for="unauthorized">
                    <input type="radio" name="reason" id="unauthorized" required value="<?php echo __( 'It is an unauthorized use of my intellectual property', 'inventor' ); ?>">
                    <?php echo __( 'It is an unauthorized use of my intellectual property', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->

            <div class="radio">
                <label for="something_else">
                    <input type="radio" name="reason" id="something_else" required value="<?php echo __( 'Something else', 'inventor' ); ?>">
                    <?php echo __( 'Something else', 'inventor' ); ?>
                </label>
            </div><!-- /.radio -->
        </div><!-- /.form-group -->

        <div class="form-group">
            <textarea class="form-control" name="message" placeholder="<?php echo __( 'Other reason or additional information', 'inventor' ); ?>" rows="4"></textarea>
        </div><!-- /.form-group -->

        <h3><?php echo __( 'Your Contact Information', 'inventor' ); ?></h3>

        <div class="row">
            <div class="form-group col-md-6">
                <input class="form-control" name="name" type="text" placeholder="<?php echo __( 'Name', 'inventor' ); ?>" required="required">
            </div><!-- /.form-group -->

            <div class="form-group col-md-6">
                <input class="form-control" name="email" type="email" placeholder="<?php echo __( 'E-mail', 'inventor' ); ?>" required="required">
            </div><!-- /.form-group -->
        </div><!-- /.row -->

        <?php if ( class_exists( 'Inventor_Recaptcha' ) ) : ?>
            <?php if ( Inventor_Recaptcha_Logic::is_recaptcha_enabled() ) : ?>
                <div id="recaptcha-<?php echo esc_attr( get_the_ID() ); ?>" class="g-recaptcha" data-sitekey="<?php echo get_theme_mod( 'inventor_recaptcha_site_key' ); ?>"></div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="button-wrapper">
            <button type="submit" class="btn btn-primary" name="report_form"><?php echo __( 'Submit to review', 'inventor' ); ?></button>
        </div><!-- /.button-wrapper -->
    </form>
<?php endif; ?>