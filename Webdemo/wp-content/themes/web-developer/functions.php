<?php
/**
 * Web Developer functions and definitions
 *
 * @package Web Developer
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! function_exists( 'web_developer_setup' ) ) : 
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function web_developer_setup() {
	global $content_width;   
	if ( ! isset( $content_width ) )
		$content_width = 680; 

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles');
	add_theme_support( 'align-wide' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );	
	add_theme_support( 'custom-header', array( 
		'default-text-color' => false,
		'header-text' => false,
	) );
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 100,
		'flex-height' => true,
	) );	
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'web-developer' ),
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	add_editor_style( 'editor-style.css' );
} 
endif; // web_developer_setup
add_action( 'after_setup_theme', 'web_developer_setup' );

function web_developer_widgets_init() {
	register_sidebar( array( 
		'name'          => __( 'Blog Sidebar', 'web-developer' ),
		'description'   => __( 'Appears on blog page sidebar', 'web-developer' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'web-developer' ),
		'description'   => __( 'Appears on footer', 'web-developer' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-1 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'web-developer' ),
		'description'   => __( 'Appears on footer', 'web-developer' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-2 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 3', 'web-developer' ),
		'description'   => __( 'Appears on footer', 'web-developer' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-3 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 4', 'web-developer' ),
		'description'   => __( 'Appears on footer', 'web-developer' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-4 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'web_developer_widgets_init' );

function web_developer_scripts() {
	wp_enqueue_style( 'bootstrap-css', esc_url(get_template_directory_uri())."/css/bootstrap.css" );
	wp_enqueue_style( 'web-developer-basic-style', get_stylesheet_uri() );
	wp_style_add_data('web-developer-basic-style', 'rtl', 'replace');
	wp_enqueue_style( 'web-developer-responsive', esc_url(get_template_directory_uri())."/css/responsive.css" );
	wp_enqueue_style( 'web-developer-default', esc_url(get_template_directory_uri())."/css/default.css" );
	wp_enqueue_style( 'font-awesome-css', esc_url(get_template_directory_uri())."/css/fontawesome-all.css" );
	wp_enqueue_style( 'owl.carousel-css', esc_url(get_template_directory_uri())."/css/owl.carousel.css" );
	
	wp_enqueue_script( 'owl.carousel-js', esc_url(get_template_directory_uri()). '/js/owl.carousel.js', array('jquery') );
	wp_enqueue_script( 'bootstrap-js', esc_url(get_template_directory_uri()). '/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'web-developer-theme', esc_url(get_template_directory_uri()) . '/js/theme.js' );
	wp_enqueue_script( 'jquery.superfish', esc_url(get_template_directory_uri()) . '/js/jquery.superfish.js' );	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );

	require get_parent_theme_file_path( '/inc/color-scheme/custom-color-control.php' );
	wp_add_inline_style( 'web-developer-basic-style',$web_developer_color_scheme_css );

	$headings_font = esc_html(get_theme_mod('web_developer_headings_fonts'));
	$body_font = esc_html(get_theme_mod('web_developer_body_fonts'));

	if( $headings_font ) {
		wp_enqueue_style( 'web-developer-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );
	} else {
		wp_enqueue_style( 'web-developer-poppins', '//fonts.googleapis.com/css?family=Poppins:0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900');
	}
	if( $body_font ) {
		wp_enqueue_style( 'web-developer-poppins', '//fonts.googleapis.com/css?family='. $body_font );
	} else {
		wp_enqueue_style( 'web-developer-source-body', '//fonts.googleapis.com/css?family=Poppins:0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900');
	}
}
add_action( 'wp_enqueue_scripts', 'web_developer_scripts' );

if ( ! defined( 'WEB_DEVELOPER_THEME_PAGE' ) ) {
define('WEB_DEVELOPER_THEME_PAGE',__('https://www.theclassictemplates.com/themes/','web-developer'));
}
if ( ! defined( 'WEB_DEVELOPER_SUPPORT' ) ) {
define('WEB_DEVELOPER_SUPPORT',__('https://wordpress.org/support/theme/web-developer','web-developer'));
}
if ( ! defined( 'WEB_DEVELOPER_REVIEW' ) ) {
define('WEB_DEVELOPER_REVIEW',__('https://wordpress.org/support/theme/web-developer/reviews/#new-post','web-developer'));
}
if ( ! defined( 'WEB_DEVELOPER_PRO_DEMO' ) ) {
define('WEB_DEVELOPER_PRO_DEMO',__('https://www.theclassictemplates.com/demo/web-developer/','web-developer'));
}
if ( ! defined( 'WEB_DEVELOPER_PREMIUM_PAGE' ) ) {
define('WEB_DEVELOPER_PREMIUM_PAGE',__('https://www.theclassictemplates.com/wp-themes/web-developer-wordpress-theme/','web-developer'));
}
if ( ! defined( 'WEB_DEVELOPER_THEME_DOCUMENTATION' ) ) {
define('WEB_DEVELOPER_THEME_DOCUMENTATION',__('https://theclassictemplates.com/documentation/web-developer/','web-developer'));
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Google Fonts
 */
require get_template_directory() . '/inc/gfonts.php';

/**
 * Theme Info Page.
 */
require get_template_directory() . '/inc/addon.php';

/**
 * Customizer additions.
 */
require get_parent_theme_file_path() . '/inc/upgrade-to-pro.php';

if ( ! function_exists( 'web_developer_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
function web_developer_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

function web_developer_sanitize_number_absint( $number, $setting ) {
  // Ensure $number is an absolute integer (whole number, zero or greater).
  $number = absint( $number );

  // If the input is an absolute integer, return it; otherwise, return the default
  return ( $number ? $number : $setting->default );
}