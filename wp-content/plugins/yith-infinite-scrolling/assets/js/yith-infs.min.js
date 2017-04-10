/**
 * yith-scroll.js
 *
 * @author Your Inspiration Themes
 * @package YITH Infinite Scrolling
 * @version 1.0.0
 */

jQuery(document).ready(function(a){"use strict";if("undefined"!=typeof yith_infs){var b={nextSelector:yith_infs.nextSelector,navSelector:yith_infs.navSelector,itemSelector:yith_infs.itemSelector,contentSelector:yith_infs.contentSelector,loader:'<img src="'+yith_infs.loader+'">',is_shop:yith_infs.shop};a(yith_infs.contentSelector).yit_infinitescroll(b),a(document).on("yith-wcan-ajax-filtered",function(){a(window).unbind("yith_infs_start"),a(yith_infs.contentSelector).yit_infinitescroll(b)})}});