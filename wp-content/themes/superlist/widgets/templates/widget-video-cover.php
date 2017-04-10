<?php
/**
 * Widget template
 *
 * @package Superlist
 * @subpackage Widgets/Templates
 */

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
$height = ! empty( $instance['height'] ) ? $instance['height'] : '';
$poster = ! empty( $instance['poster'] ) ? $instance['poster'] : '';
$overlay_opacity = ! empty( $instance['overlay_opacity'] ) ? $instance['overlay_opacity'] : '0.4';
$video_mp4 = ! empty( $instance['video_mp4'] ) ? $instance['video_mp4'] : '';
$video_ogg = ! empty( $instance['video_ogg'] ) ? $instance['video_ogg'] : '';
$video_embed = ! empty( $instance['video_embed'] ) ? $instance['video_embed'] : '';

$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$sort = ! empty( $instance['sort'] ) ? $instance['sort'] : '';
?>


<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php $player_id = "listing-banner-player"; ?>

<div id="video-outer-wrap" class="video-cover" style="<?php if ( ! empty( $poster ) ) : ?>background-image: url('<?php echo esc_attr( $poster )?>');<?php endif; ?><?php if ( ! empty( $height ) ) : ?>height: <?php echo esc_attr( $height ); ?><?php endif; ?>">
	<div id="video-wrap">

        <?php if ( ! empty( $video_embed ) ) : ?>
            <div id="video-cover" class="embed-video">
                <?php echo wp_oembed_get( $video_embed, array('width'=>4000) ); ?>
            </div>
        <?php elseif ( ! empty( $video_mp4 ) || ! empty( $video_ogg ) ) : ?>
            <video id="video-cover" preload="metadata" autoplay muted loop>
                <?php if ( ! empty( $video_mp4 ) ) : ?>
                    <source src="<?php echo esc_attr( $video_mp4 ); ?>" type="video/mp4">
                <?php endif; ?>

                <?php if ( ! empty( $video_ogg ) ) : ?>
                    <source src="<?php echo esc_attr( $video_ogg ); ?>" type="video/ogg">
                <?php endif; ?>

                <iframe width="560" height="315" src="https://www.youtube.com/embed/ngIOM_limyA" frameborder="0" allowfullscreen></iframe>

            </video><!-- /#video-cover -->
        <?php endif; ?>

	</div><!-- /#video-wrap -->

	<div class="video-wrapper-overlay" <?php if ( ! empty( $overlay_opacity ) ) : ?>style="opacity: <?php echo esc_attr( $overlay_opacity );?>"<?php endif; ?>></div><!-- /.video-wrapper-overlay -->
</div><!-- /#video-outer-cover -->

<?php if ( ! empty( $title ) || ! empty( $subtitle ) ) : ?>
	<div class="video-cover-title">
		<?php if ( ! empty( $title ) ) : ?>
			<h1><?php echo esc_attr( $title ); ?></h1>
		<?php endif; ?>

		<?php if ( ! empty( $subtitle ) ) :?>
			<h2><?php echo esc_attr( $subtitle ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $instance['filter'] ) ) : ?>
			<div class="video-cover-filter">
				<?php include Inventor_Template_Loader::locate( 'widgets/filter-form' ); ?>
			</div><!-- /.row -->
		<?php endif; ?>
	</div><!-- /.video-cover-title -->
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<script>
    var videoUrl = "<?php echo esc_attr( $video_embed ); ?>";

    /* Youtube */
    if (videoUrl.indexOf('youtube.com') > -1) {
        console.log('provider: YouTube');
        jQuery('#video-cover iframe').attr('id', function() {
            return 'video-iframe'
        });
        jQuery('#video-cover iframe').attr('src', function() {
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
        console.log('provider: Vimeo');
        jQuery('#video-cover iframe').attr('src', function() {
            return this.src + '?title=0&byline=0&badge=0&color=ffffff'
        });

        var iframe = document.querySelector('#video-cover > iframe');
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
