<div class="row">
    <?php $index = 0; ?>
    <?php foreach ( $content as $box ) : ?>
        <div class="<?php if ( 4 == count( $content ) ) : ?>col-sm-12 col-lg-3 col-md-6<?php elseif ( 3 == count( $content ) ) : ?>col-sm-12 col-md-4<?php elseif ( 2 == count( $content ) ) : ?>col-sm-12 col-md-6<?php elseif ( 1 == count( $content ) ) : ?>col-sm-12<?php endif; ?>">
            <?php
            echo Inventor_Template_Loader::load(
                'widgets/boxes-box',
                array(
                    'index' => $index,
                    'box' => $box,
                ),
                INVENTOR_BOXES_DIR
            );
            ?>
        </div><!-- /.col-* -->
        <?php $index++; ?>
    <?php endforeach; ?>
</div><!-- /.row -->