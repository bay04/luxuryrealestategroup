<div id="video-banner" class="detail-banner" data-background-image="<?php echo esc_attr( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>">
    <?php $player_id = "listing-banner-player"; ?>
    <?php $banner_video = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_video', true ) ?>
    <?php $banner_video_embed = get_post_meta( get_the_ID(), INVENTOR_LISTING_PREFIX . 'banner_video_embed', true ) ?>

    <?php echo wp_oembed_get( $banner_video_embed, array( 'width'=> 4000 ) ); ?>

    <?php if ( ! empty( $banner_video ) ): ?>
        <video autoplay muted loop
            <source src="<?php echo esc_attr( $banner_video ); ?>" type="video/mp4">
            <div class="alert alert-danger"><?php esc_attr__( 'Your browser does not support the video html tag.', 'superlist' ); ?></div>
        </video>
    <?php endif; ?>

    <?php get_template_part( 'templates/content-listing-banner-info' ); ?>
</div><!-- /.detail-banner -->

<script>
    var videoUrl = "<?php echo $banner_video_embed; ?>";

    /* Youtube */
    if (videoUrl.indexOf('youtube.com') > -1) {
        jQuery('#video-banner iframe').attr('id', function() {
            return 'video-iframe'
        });
        jQuery('#video-banner iframe').attr('src', function() {
            return this.src + '?feature=oembed&enablejsapi=1&rel=0&iv_load_policy=3&showinfo=0&vq=hd1080&autoplay=1&controls=0&loop=0&muted=1&playlist=' + YouTubeGetID(videoUrl)
        });

        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('video-iframe', {
                events: {
                    'onReady': onPlayerReady
                }
            });
        }

        function onPlayerReady(event) {
            player.mute();
            player.playVideo();
        }

    /* Vimeo */
    } else if (videoUrl.indexOf('vimeo.com') > -1) {
        jQuery('#video-banner iframe').attr('src', function() {
            return this.src + '?title=0&byline=0&badge=0&color=ffffff'
        });

        var iframe = document.querySelector('#video-banner > iframe');
        var player = new Vimeo.Player(iframe);

        player.setVolume(0);
        player.setLoop(true);
        player.disableTextTrack();
        player.play();
    }

    function YouTubeGetID(url){
        var ID = '';
        url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
        if(url[2] !== undefined) {
            ID = url[2].split(/[^0-9a-z_\-]/i);
            ID = ID[0];
        }
        else {
            ID = url;
        }
        return ID;
    }
</script>