///**
// * Youtube banner video
// */
//
//function youtubeBannerVideo(videoUrl, playerId) {
//    var videoId = YouTubeGetID(videoUrl);
//
//    // 2. This code loads the IFrame Player API code asynchronously.
//    var tag = document.createElement('script');
//    tag.src = "https://www.youtube.com/iframe_api";
//    var firstScriptTag = document.getElementsByTagName('script')[0];
//    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
//
//    // 3. This function creates an <iframe> (and YouTube player)
//    //    after the API code downloads.
//    var player;
//
//    function onYouTubeIframeAPIReady() {
//        player = new YT.Player(playerId, {
//            height: '1400',
//            width: '2000',
//            videoId: videoId,
//            playerVars: {
//                'autoplay': 1,
//                'controls': 0,
//                'rel': 0,
//                'showinfo': 0
//            },
//            events: {
//                'onReady': onPlayerReady
//            }
//        });
//    }
//}
//
//// 4. The API will call this function when the video player is ready.
//function onPlayerReady(event) {
//    player.mute();
//    player.loadPlaylist(videoId);
//    player.setLoop(true);
//    event.target.playVideo();
//}
//
///**
// * Get YouTube ID from various YouTube URL
// * @author: takien
// * @url: http://takien.com
// * For PHP YouTube parser, go here http://takien.com/864
// */
//
//function YouTubeGetID(url){
//    var ID = '';
//    url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
//    if(url[2] !== undefined) {
//        ID = url[2].split(/[^0-9a-z_\-]/i);
//        ID = ID[0];
//    }
//    else {
//        ID = url;
//    }
//    return ID;
//}