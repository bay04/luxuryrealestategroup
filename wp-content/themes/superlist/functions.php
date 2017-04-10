<?php
/**
 * Superlist functions and definitions
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */

/**
 * Constants
 */
define( 'VERSION', '2.8.0' );
define( 'POST_EXCERPT_LENGTH', 40 );
define( 'EXCERPT_LENGTH', 20 );

/**
 * Libraries
 */
require_once get_template_directory() . '/assets/libraries/class-tgm-plugin-activation.php';

/**
 * Widgets
 */
require_once get_template_directory() . '/widgets/widget-call-to-action.php';
require_once get_template_directory() . '/widgets/widget-recent-posts.php';
require_once get_template_directory() . '/widgets/widget-simple-map.php';
require_once get_template_directory() . '/widgets/widget-video-cover.php';

/**
 * Body classes
 *
 * @filter body_class
 * @param array $body_class Body classes.
 * @return array
 */
function superlist_body_classes( $body_class ) {
	$body_class[] = get_theme_mod( 'superlist_general_header', 'header-sticky' );
	$body_class[] = get_theme_mod( 'superlist_general_layout', 'layout-wide' );
	$body_class[] = get_theme_mod( 'superlist_general_submenu', 'submenu-dark' );

	if ( ! is_active_sidebar( 'header-topbar-left' ) && ! is_active_sidebar( 'header-topbar-right' ) ) {
		$body_class[] = 'header-empty-topbar';
	}

	return $body_class;
}
add_filter( 'body_class', 'superlist_body_classes' );

/**
 * Widgets Init
 *
 * @action widgets_init
 * @return void
 */
function superlist_widgets_init() {
	register_widget( 'Superlist_Widget_Call_To_Action' );
	register_widget( 'Superlist_Widget_Video_Cover' );
	register_widget( 'Superlist_Widget_Simple_Map' );
}
add_action( 'widgets_init', 'superlist_widgets_init' );

/**
 * Enqueue scripts & styles
 *
 * @action wp_enqueue_scripts
 * @return void
 */
function superlist_enqueue_files() {
	// styles
	wp_enqueue_style( 'roboto', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700&subset=latin,latin-ext' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/libraries/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'superlist-font', get_template_directory_uri() . '/assets/libraries/superlist-font/style.css' );
	wp_enqueue_style( 'colorbox', get_template_directory_uri() . '/assets/libraries/colorbox/example1/colorbox.css' );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl.carousel/owl.carousel.css' );
	wp_enqueue_style( 'bootstrap-select', get_template_directory_uri() . '/assets/libraries/bootstrap-select/bootstrap-select.min.css' );

	$style = get_theme_mod( 'superlist_general_style', 'superlist-mint.css' );
	wp_enqueue_style( 'superlist', get_template_directory_uri() . '/assets/css/' . $style, array(), '20170131' );
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', '20170131' );

	// scripts
	wp_enqueue_script( 'bootstrap-select', get_template_directory_uri() . '/assets/libraries/bootstrap-select/bootstrap-select.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-dropdown', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/javascripts/bootstrap/dropdown.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-collapse', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/javascripts/bootstrap/collapse.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-tooltip', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/javascripts/bootstrap/tooltip.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-alert', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/javascripts/bootstrap/alert.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-affix', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/javascripts/bootstrap/affix.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-tab', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/javascripts/bootstrap/tab.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-transition', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/javascripts/bootstrap/transition.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootstrap-scrollspy', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/javascripts/bootstrap/scrollspy.js', array( 'jquery' ) );
	wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/assets/libraries/colorbox/jquery.colorbox-min.js', array( 'jquery' ) );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl.carousel/owl.carousel.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'scrollto', get_template_directory_uri() . '/assets/libraries/scrollto/jquery.scrollTo.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'vimeo-player', 'https://player.vimeo.com/api/player.js' );
    wp_enqueue_script( 'video-provider-youtube', get_template_directory_uri() . '/assets/js/video-providers/youtube.js', array( 'jquery' ));
//    wp_enqueue_script( 'video-provider-vimeo', get_template_directory_uri() . '/assets/js/video-providers/vimeo.js', array( 'jquery' ));
    wp_enqueue_script( 'superlist', get_template_directory_uri() . '/assets/js/superlist.js', array( 'jquery' ), '20161201' );
}

add_action( 'wp_enqueue_scripts', 'superlist_enqueue_files', 9 );


/**
 * Enqueue scripts & styles for backend
 *
 * @action admin_enqueue_scripts
 * @return void
 */
function superlist_enqueue_files_backend() {
	// styles
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/libraries/font-awesome/css/font-awesome.min.css' );
}

add_action( 'admin_enqueue_scripts', 'superlist_enqueue_files_backend' );

/**
 * Register navigations
 *
 * @action init
 * @return void
 */
function superlist_menus() {
	register_nav_menu( 'main', __( 'Main', 'superlist' ) );
}
add_action( 'init', 'superlist_menus' );

/**
 * Custom widget areas
 *
 * @action widgets_init
 * @return void
 */
function superlist_sidebars() {
	register_sidebar( array( 'name' => __( 'Primary', 'superlist' ), 'id' => 'sidebar-1', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Dashboard Sidebar', 'superlist' ), 'id' => 'dashboard', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Header Topbar Left', 'superlist' ), 'id' => 'header-topbar-left', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Header Topbar Right', 'superlist' ), 'id' => 'header-topbar-right', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Header', 'superlist' ), 'id' => 'header', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Top Fullwidth', 'superlist' ), 'id' => 'top-fullwidth', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Top', 'superlist' ), 'id' => 'top', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Content Top', 'superlist' ), 'id' => 'content-top', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Content Bottom', 'superlist' ), 'id' => 'content-bottom', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Bottom', 'superlist' ), 'id' => 'bottom', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Footer Top First', 'superlist' ), 'id' => 'footer-top-first', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Footer Top Second', 'superlist' ), 'id' => 'footer-top-second', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Footer Top Third', 'superlist' ), 'id' => 'footer-top-third', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Footer Top Fourth', 'superlist' ), 'id' => 'footer-top-fourth', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Footer First', 'superlist' ), 'id' => 'footer-first', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Footer Second', 'superlist' ), 'id' => 'footer-second', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Footer Bottom First', 'superlist' ), 'id' => 'footer-bottom-first', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
	register_sidebar( array( 'name' => __( 'Footer Bottom Second', 'superlist' ), 'id' => 'footer-bottom-second', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>' ) );
}
add_action( 'widgets_init', 'superlist_sidebars' );


/**
 * Sets Unlimited package to the admin
 *
 * @action after_setup_theme
 * @return void
 */
add_action( 'update_option', 'superlist_after_one_click_installation', 10, 3 );
function superlist_after_one_click_installation( $option, $old_value, $value ) {
	$option_prefix = 'one_click_process_step_';
//	$is_one_click_option = (substr( $option, 0, strlen( $option_prefix ) ) === $option_prefix );
	$is_one_click_option = $option == 'page_on_front';

	$admin_package_set = get_option( 'one_click_process_step_set_admin_package', False );

	if ( ! $admin_package_set && class_exists( 'One_Click_Launcher' ) && class_exists( 'Inventor_Packages' ) ) {
		$missing_steps = One_Click_Launcher::is_missing( true );
		$finishing = $value == true && $missing_steps == 1;

		if ( $is_one_click_option && $finishing ) {
			$user_id = 1;
			$package_id = 564;
			Inventor_Packages_Logic::set_package_for_user( $user_id, $package_id );
			update_option( 'one_click_process_step_set_admin_package', True );
		}
	}
}

/**
 * Additional after theme setup functions
 *
 * @action after_setup_theme
 * @return void
 */
function superlist_after_theme_setup() {
	load_theme_textdomain( 'superlist', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-header', array() );
	add_theme_support( 'custom-background' );
	add_theme_support( 'menus' );
	add_theme_support( 'title-tag' );

	$listing_types = get_theme_support( 'inventor-listing-types' );
	if ( empty( $listing_types ) ) {
		add_theme_support( 'inventor-listing-types', array(
			'business',
			'car',
			'coupon',
			'dating',
			'education',
			'event',
			'food',
			'hotel',
			'job',
			'pet',
			'property',
			'resume',
			'shopping',
			'travel',
		) );
	}

	add_filter( 'widget_text', 'do_shortcode' );
	add_filter( 'widget_title', 'html_widget_title' );

	if ( ! isset( $content_width ) ) {
		$content_width = 1170;
	}
}
add_action( 'after_setup_theme', 'superlist_after_theme_setup' );


function html_widget_title( $title ) {
	//HTML tag opening/closing brackets
	$title = str_replace( '[', '<', $title );
	$title = str_replace( '[/', '</', $title );
	// bold -- changed from 's' to 'strong' because of strikethrough code
	$title = str_replace( 'strong]', 'strong>', $title );
	$title = str_replace( 'b]', 'b>', $title );
	// italic
	$title = str_replace( 'em]', 'em>', $title );
	$title = str_replace( 'i]', 'i>', $title );
	// underline
	// $title = str_replace( 'u]', 'u>', $title ); // could use this, but it is deprecated so use the following instead
	$title = str_replace( 'u]', '<span style="text-decoration:underline;">', $title );
	$title = str_replace( '/u]', '</span>', $title );
	// superscript
	$title = str_replace( 'sup]', 'sup>', $title );
	// subscript
	$title = str_replace( 'sub]', 'sub>', $title );
	// del
	$title = str_replace( 'del]', 'del>', $title ); // del is like strike except it is not deprecated, but strike has wider browser support -- you might want to replace the following 'strike' section to replace all with 'del' instead
	// strikethrough or <s></s>
	$title = str_replace( 'strike]', 'strike>', $title );
	$title = str_replace( 's]', 'strike>', $title ); // <s></s> was deprecated earlier than so we will convert it
	$title = str_replace( 'strikethrough]', 'strike>', $title ); // just in case you forget that it is 'strike', not 'strikethrough'
	// tt
	$title = str_replace( 'tt]', 'tt>', $title ); // Will not look different in some themes, like Twenty Eleven -- FYI: http://reference.sitepoint.com/html/tt
	// marquee
	$title = str_replace( 'marquee]', 'marquee>', $title );
	// blink
	$title = str_replace( 'blink]', 'blink>', $title ); // only Firefox and Opera support this tag

	return $title;
}


/**
 * Shares
 *
 * @action inventor_listing_actions
 * @return void
 */
function superlist_render_share_button() {
	if ( class_exists( 'Inventor' ) ) {
		include Inventor_Template_Loader::locate( 'misc/share' );
	}
}
add_action( 'superlist_after_listing_banner', 'superlist_render_share_button', 0 );
add_action( 'inventor_listing_actions', 'superlist_render_share_button', 0 );


/**
 * Detail
 *
 * @action inventor_listing_actions
 * @return void
 */
function superlist_render_detail_button() {
	if ( class_exists( 'Inventor' ) ) {
		echo '<a href="' . get_the_permalink() .'" class="fa fa-eye"></a>';
	}
}
//add_action( 'inventor_listing_actions', 'superlist_render_detail_button', 0 );


/**
 * Favorites
 *
 * @param int $listing_id Listing ID.
 * @action superlist_after_listing_banner
 * @return void
 */
if ( class_exists( 'Inventor_Favorites' ) ) {
	add_action( 'superlist_after_listing_banner', array( 'Inventor_Favorites_Logic', 'render_favorite_button' ), 1, 1 );
}

/**
 * Jobs
 *
 * @param int $listing_id Listing ID.
 * @action superlist_after_listing_banner
 * @return void
 */
if ( class_exists( 'Inventor_Jobs' ) ) {
	add_action( 'superlist_after_listing_banner', array( 'Inventor_Jobs_Logic', 'render_apply_button' ), 1, 1 );
}

/**
 * Compare
 *
 * @param int $listing_id Listing ID.
 * @action superlist_after_listing_banner
 * @return void
 */
if ( class_exists( 'Inventor_Compare' ) ) {
	add_action( 'superlist_after_listing_banner', array( 'Inventor_Compare_Logic', 'render_compare_button' ), 1, 1 );
}

/**
 * Reviews
 *
 * @param int $listing_id Listing ID.
 * @action superlist_after_listing_banner
 * @return void
 */
if ( class_exists( 'Inventor_Reviews' ) ) {
	add_action( 'superlist_after_listing_banner', array( 'Inventor_Reviews_Logic', 'render_listing_rating' ), -1, 1 );
}

/**
 * Reviews
 *
 * @param string $label
 * @param int $listing_id
 * @param string $display
 * @action inventor_listing_bottom_title
 * @return string
 */
function superlist_render_total_rating( $label, $listing_id, $display ) {
	if ( class_exists( 'Inventor_Reviews' ) && $display == 'column' ) {
		return Inventor_Template_Loader::load( 'review-listing-rating', array( 'listing_id' => $listing_id, 'display' => null ), $plugin_dir = INVENTOR_REVIEWS_DIR );
	}
	return '';
}
add_action( 'inventor_listing_bottom_title', 'superlist_render_total_rating', -1, 3 );


/**
 * Print
 *
 * @action superlist_after_listing_banner
 * @return void
 */
function superlist_render_print_button() {
	if ( class_exists( 'Inventor' ) ) {
		if ( get_theme_mod( 'superlist_general_show_print_listing_button', null ) == '1' ) {
			include Inventor_Template_Loader::locate( 'misc/print-button' );
		}
	}
}
add_action( 'superlist_after_listing_banner', 'superlist_render_print_button', 100 );

/**
 * Custom excerpt length
 *
 * @param int $length String length.
 * @filter excerpt_length
 * @return int
 */
function superlist_excerpt_length( $length ) {
	global $post;

	if ( $post->post_type == 'post' ) {
		return POST_EXCERPT_LENGTH;
	} else {
		return EXCERPT_LENGTH;
	}
}
add_filter( 'excerpt_length', 'superlist_excerpt_length' );

/**
 * Custom read more
 *
 * @param string $more Read more string.
 * @filter excerpt_more
 * @return string
 */
function superlist_excerpt_more( $more ) {
		return '&hellip;';
}
add_filter( 'excerpt_more', 'superlist_excerpt_more' );

/**
 * Disable admin's bar top margin
 *
 * @action get_header
 * @return void
 */
function superlist_disable_admin_bar_top_margin() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'get_header', 'superlist_disable_admin_bar_top_margin' );

/**
 * Custom class for parent menu
 *
 * @param array $items Menu items.
 * @action wp_nav_menu_objects
 * @return array
 */
function superlist_menu_class( $items ) {
	$parents = array();

	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}

	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'has-children';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'superlist_menu_class' );

/**
 * Customizations
 *
 * @param StdClass $wp_customize WP_Customize object.
 * @action customize_register
 * @return void
 */
function superlist_customizations( $wp_customize ) {
	$wp_customize->add_section( 'superlist_general', array( 'title' => __( 'Superlist General', 'superlist' ), 'priority' => 0 ) );

	// Logo
	$wp_customize->add_setting( 'superlist_logo', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_logo', array(
		'label'         => __( 'Logo', 'superlist' ),
		'section'       => 'title_tagline',
		'settings'      => 'superlist_logo',
		'description'   => __( 'Logo displayed in header.', 'superlist' ),
		'priority'      => 40,
	) ) );

	// Customizer
	$wp_customize->add_setting( 'superlist_general_customizer', array(
		'default'           => false,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_customizer', array(
		'label'             => __( 'Customizer', 'superlist' ),
		'section'           => 'superlist_general',
		'settings'          => 'superlist_general_customizer',
		'type'              => 'checkbox',
	) );

	// Style
	$wp_customize->add_setting( 'superlist_general_style', array(
		'default'           => 'superlist-mint.css',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_style', array(
		'label'             => __( 'Style', 'superlist' ),
		'section'           => 'superlist_general',
		'settings'          => 'superlist_general_style',
		'type'              => 'select',
		'choices'           => array(
			'superlist-blue-light.css'  => __( 'Blue Light', 'superlist' ),
			'superlist-blue.css'        => __( 'Blue', 'superlist' ),
			'superlist-blue-dark.css'   => __( 'Blue dark', 'superlist' ),
			'superlist-blue-gray.css'   => __( 'Blue gray', 'superlist' ),
			'superlist-brown.css'       => __( 'Brown', 'superlist' ),
			'superlist-green.css'       => __( 'Green', 'superlist' ),
			'superlist-green-dark.css'  => __( 'Green dark', 'superlist' ),
			'superlist-lime.css'        => __( 'Lime', 'superlist' ),
			'superlist-magenta.css'     => __( 'Magenta', 'superlist' ),
			'superlist-orange.css'      => __( 'Orange', 'superlist' ),
			'superlist-pink.css'        => __( 'Pink', 'superlist' ),
			'superlist-purple.css'      => __( 'Purple', 'superlist' ),
			'superlist-purple-dark.css' => __( 'Purple Dark', 'superlist' ),
			'superlist-mint.css'        => __( 'Mint', 'superlist' ),
			'superlist-red.css'         => __( 'Red', 'superlist' ),
			'superlist-turquoise.css'   => __( 'Turquoise', 'superlist' ),
		),
        'description'       => __( 'Check the documentation to learn how to compile custom color.', 'superlist' ),
	) );

	// Layout
	$wp_customize->add_setting( 'superlist_general_layout', array(
		'default'           => 'layout-wide',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_layout', array(
		'label'             => __( 'Layout', 'superlist' ),
		'section'           => 'superlist_general',
		'settings'          => 'superlist_general_layout',
		'type'              => 'select',
		'choices'           => array(
			'layout-wide'   => __( 'Wide', 'superlist' ),
			'layout-boxed'  => __( 'Boxed', 'superlist' ),
		),
	) );

	// Header Position
	$wp_customize->add_setting( 'superlist_general_header', array(
		'default'           => 'header-sticky',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_header', array(
		'label'             => __( 'Header position', 'superlist' ),
		'section'           => 'superlist_general',
		'settings'          => 'superlist_general_header',
		'type'              => 'select',
		'choices'           => array(
			'header-sticky' => __( 'Sticky', 'superlist' ),
			'header-fixed'  => __( 'Fixed', 'superlist' ),
		),
	) );

	// Header Type
	$wp_customize->add_setting( 'superlist_general_header_type', array(
		'default'           => 'header-regular',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_header_type', array(
		'label'             => __( 'Header Type', 'superlist' ),
		'section'           => 'superlist_general',
		'settings'          => 'superlist_general_header_type',
		'type'              => 'select',
		'choices'           => array(
			'header-regular' 	=> __( 'Regular', 'superlist' ),
			'header-complex'  	=> __( 'Complex', 'superlist' ),
		),
	) );

	// Submenu
	$wp_customize->add_setting( 'superlist_general_submenu', array(
		'default'           => 'submenu-dark',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_submenu', array(
		'label'             => __( 'Submenu', 'superlist' ),
		'section'           => 'superlist_general',
		'settings'          => 'superlist_general_submenu',
		'type'              => 'select',
		'choices'           => array(
			'submenu-dark'  => __( 'Dark', 'superlist' ),
			'submenu-light' => __( 'Light', 'superlist' ),
		),
	) );

	// Blog display
	$wp_customize->add_setting( 'superlist_general_blog_display', array(
		'default'           => 'row',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_blog_display', array(
		'label'             => __( 'Blog display', 'superlist' ),
		'section'           => 'superlist_general',
		'settings'          => 'superlist_general_blog_display',
		'type'              => 'select',
		'choices'           => array(
			'row'   	=> __( 'Row', 'superlist' ),
			'masonry'  	=> __( 'Masonry', 'superlist' ),
		),
	) );

	// Action text
	$wp_customize->add_setting( 'superlist_general_action_text', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_action_text', array(
		'label'             => __( 'Action Button Text', 'superlist' ),
		'section'           => 'superlist_general',
		'settings'          => 'superlist_general_action_text',
		'description'       => __( 'Text is displayed when button is hovered.', 'superlist' ),
	) );

	// Action page
	$wp_customize->add_setting( 'superlist_general_action', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'superlist_general_action', array(
		'label'         => __( 'Action Button Page', 'superlist' ),
		'type'          => 'select',
		'section'       => 'superlist_general',
		'settings'      => 'superlist_general_action',
		'choices'       => superlist_get_pages(),
		'description'   => __( 'Page where the action button will point to.', 'superlist' ),
	) );

	// Show print button in listing detail
	$wp_customize->add_setting( 'superlist_general_show_print_listing_button', array(
		'default'           => false,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'superlist_general_show_print_listing_button', array(
		'type'      => 'checkbox',
		'label'     => __( 'Show print button in listing detail', 'superlist' ),
		'section'   => 'superlist_general',
		'settings'  => 'superlist_general_show_print_listing_button',
	) );
}
add_action( 'customize_register', 'superlist_customizations' );

/**
 * Comments template
 *
 * @param string $comment Comment message.
 * @param array  $args Arguments.
 * @param int    $depth Depth.
 * @return void
 */
function superlist_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );
	include 'templates/misc/comment.php';
}

/**
 * Get pages list
 *
 * @return array
 */
function superlist_get_pages() {
	$pages = array();
	$pages[] = __( 'Not set', 'superlist' );

	foreach ( get_pages() as $page ) {
		$pages[ $page->ID ] = $page->post_title;
	}

	return $pages;
}

/**
 * Register plugins
 *
 * @action tgmpa_register
 * @return void
 */
function superlist_register_required_plugins() {
	$plugins = array(
		array(
			'name'      			=> 'CMB2',
			'slug'      			=> 'cmb2',
			'is_automatic'          => true,
			'required'  			=> true,
			'version'				=> '2.2.2.1'
		),
		array(
			'name'      			=> 'Widget Logic',
			'slug'      			=> 'widget-logic',
			'is_automatic'          => true,
			'required'  			=> false,
		),
		array(
			'name'      			=> 'Wordpress Importer',
			'slug'      			=> 'wordpress-importer',
			'required'  			=> true,
		),
		array(
			'name'                  => 'Contact Form 7',
			'slug'                  => 'contact-form-7',
			'required'              => false,
			'is_automatic'          => true,
		),
//	    array(
//		    'name'      			=> 'WordPress Social Login',
//		    'slug'      			=> 'wordpress-social-login',
//		    'required'  			=> false,
//	    ),
		array(
			'name'                  => 'One Click',
			'slug'                  => 'one-click',
			'source'                => superlist_get_plugin_package( 'one-click' ),
			'required'              => false,
			'force_deactivation'    => false,
			'is_automatic'          => true,
			'version'               => superlist_get_plugin_version( 'one-click' ),
		)
	);

	$inventor_plugins = array(
		'inventor'					=> 'Inventor',
		'inventor-bookings'			=> 'Inventor Bookings',
		'inventor-boxes'			=> 'Inventor Boxes',
		'inventor-claims'			=> 'Inventor Claims',
		'inventor-compare'			=> 'Inventor Compare',
		'inventor-coupons'			=> 'Inventor Coupons',
		'inventor-currencies'		=> 'Inventor Currencies',
		'inventor-faq'				=> 'Inventor FAQ',
		'inventor-favorites'		=> 'Inventor Favorites',
		'inventor-fields'			=> 'Inventor Fields',
		'inventor-google-map'		=> 'Inventor Google Map',
		'inventor-google-places'	=> 'Inventor Google Places',
		'inventor-invoices'			=> 'Inventor Invoices',
		'inventor-jobs'				=> 'Inventor Jobs',
		'inventor-listing-slider'	=> 'Inventor Listing Slider',
		'inventor-mail-templates'	=> 'Inventor Mail Templates',
		'inventor-notifications'	=> 'Inventor Notifications',
		'inventor-packages'			=> 'Inventor Packages',
		'inventor-partners'			=> 'Inventor Partners',
		'inventor-paypal'			=> 'Inventor PayPal',
		'inventor-pricing'			=> 'Inventor Pricing',
		'inventor-properties'		=> 'Inventor Properties',
		'inventor-recaptcha'		=> 'Inventor reCAPTCHA',
		'inventor-reviews'			=> 'Inventor Reviews',
		'inventor-shop'				=> 'Inventor Shop',
		'inventor-statistics'		=> 'Inventor Statistics',
//		'inventor-stripe'			=> 'Inventor Stripe',
		'inventor-submission'		=> 'Inventor Submission',
		'inventor-testimonials'		=> 'Inventor Testimonials',
		'inventor-ui-kit'			=> 'Inventor UI Kit',
		'inventor-watchdogs'		=> 'Inventor Watchdogs',
	);

	foreach ( $inventor_plugins as $slug => $name ) {
		$inventor_plugin = array(
			'name'                  => $name,
			'slug'                  => $slug,
			'source'                => superlist_get_plugin_package( $slug ),
			'required'              => $slug == 'inventor',
			'force_activation'    	=> $slug == 'inventor',
			'force_deactivation'    => false,
			'is_automatic'          => true,
			'external_url'			=> 'http://inventorwp.com/plugins/'. $slug .'/',
			'version'               => superlist_get_plugin_version( $slug ),
		);

		array_push( $plugins, $inventor_plugin );
	}

	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'superlist_register_required_plugins' );

/**
 * Gets plugins version
 *
 * @param string $plugin_slug
 * @return string
 */
function superlist_get_plugin_version( $plugin_slug ) {
	$filename = superlist_get_plugin_package( $plugin_slug );
	$parts = explode( '/', $filename );
	$filename = $parts[ count( $parts ) - 1 ];

	// Remove ZIP
	$name = substr( $filename, 0, -4 );

	// Get last string path after "-"
	$parts = explode( '-', $name );
	$version = $parts[ count( $parts ) - 1 ];

	// If the last part can be exploded by dot and have 3 items in array
	if ( 3 === count( explode( '.', $version ) ) ) {
		return $version;
	}

	return '0.1.0';
}

/**
 * Gets plugins package filepath
 *
 * @param string $plugin_slug
 * @return string
 */
function superlist_get_plugin_package( $plugin_slug ) {
	$prefix = get_template_directory() . '/plugins/';
	$files = glob( $prefix . '*.zip' );

	foreach ( $files as $file ) {
		$parts = explode( '/', $file );
		$filename = $parts[ count( $parts ) - 1];

		if ( substr( $filename, 0, strlen( $plugin_slug ) ) === $plugin_slug ) {
			return $prefix . $filename;
		}
	}
	return $prefix . $plugin_slug . '.zip';
}

/**
 * Posts pagination
 *
 * @return void
 */
function superlist_pagination() {
	the_posts_pagination( array(
		'prev_text'             => __( 'Previous', 'superlist' ),
		'next_text'             => __( 'Next', 'superlist' ),
		'mid_size'              => 2,
	) );
}

/**
 * Remove 'Archives:' from post type archive title
 *
 * @filter get_the_archive_title
 * @param string $title Archive title.
 * @return string|void
 */
function superlist_get_the_archive_title( $title ) {
	if ( is_post_type_archive() ) {
		return post_type_archive_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'superlist_get_the_archive_title' );

/**
 * Custom total rating attrs
 *
 * @param $listing_id
 * @return string
 */
function superlist_review_rating_total_attrs( $listing_id ) {
	echo 'data-fontawesome data-starOn="fa fa-star" data-starHalf="fa fa-star-half-o" data-starOff="fa fa-star-o"';
}
add_action( 'inventor_review_rating_total_attrs', 'superlist_review_rating_total_attrs', 10, 1 );