<a href="#" class="share-listing">
    <i class="fa fa-share-alt"></i>
    <span><?php echo __( 'Share', 'inventor' ); ?></span>
</a>

<div class="modal-inner">
    <h2><?php echo __( 'Share', 'inventor' ); ?> "<?php the_title(); ?>"</h2>

    <ul>
        <li>
            <a class="mail" href="mailto:?subject=<?php echo urlencode( get_the_title() ); ?>&amp;body=<?php the_permalink(); ?>">
                <i class="fa fa-envelope"></i>
            </a>
        </li>

        <li>
            <a class="facebook" href="https://www.facebook.com/share.php?u=<?php the_permalink(); ?>&amp;title=<?php echo str_replace(' ', '%20', get_the_title()); ?>#sthash.BUkY1jCE.dpuf"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <i class="fa fa-facebook"></i>
            </a>
        </li>

        <li>
            <a class="google-plus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <i class="fa fa-google"></i>
            </a>
        </li>

        <li>
            <a class="twitter" href="https://twitter.com/home?status=<?php echo str_replace( ' ', '%20', get_the_title()); ?>+<?php the_permalink(); ?>#sthash.BUkY1jCE.dpuf"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <i class="fa fa-twitter"></i>
            </a>
        </li>
    </ul>
</div><!-- /.modal-inner -->