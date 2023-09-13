<?php
/**
 * Web Development Company functions and definitions
 *
 * @package Web Development Company
 */

if ( ! function_exists( 'web_development_company_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function web_development_company_setup() {
	global $web_development_company_content_width;
	if ( ! isset( $web_development_company_content_width ) )
		$web_development_company_content_width = 680;

	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'wp-block-styles');
	add_theme_support( 'align-wide' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 100,
		'flex-height' => true,
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
add_action( 'after_setup_theme', 'web_development_company_setup' );

function web_development_company_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'web-development-company' ),
		'description'   => __( 'Appears on blog page sidebar', 'web-development-company' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'web-development-company' ),
		'description'   => __( 'Appears on footer', 'web-development-company' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-1 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'web-development-company' ),
		'description'   => __( 'Appears on footer', 'web-development-company' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-2 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget 3', 'web-development-company' ),
		'description'   => __( 'Appears on footer', 'web-development-company' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-3 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget 4', 'web-development-company' ),
		'description'   => __( 'Appears on footer', 'web-development-company' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-4 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'web_development_company_widgets_init' );

add_action( 'wp_enqueue_scripts', 'web_development_company_enqueue_styles' );

function web_development_company_enqueue_styles() {
    $parenthandle = 'web-development-company-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $web_development_company_color_scheme_css = get_theme_mod('web_development_company_color_scheme_css');
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, esc_url(get_template_directory_uri()) . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'web-development-company-child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );

    require get_parent_theme_file_path( '/inc/color-scheme/custom-color-control.php' );
	wp_add_inline_style( 'web-development-company-style',$web_developer_color_scheme_css );
	require get_theme_file_path( '/inc/color-scheme/custom-color-control.php' );
	wp_add_inline_style( 'web-development-company-style',$web_development_company_color_scheme_css);

}

// customizer css
function web_development_company_enqueue_customizer_css() {
    wp_enqueue_style( 'web_development_company-customizer-css', get_stylesheet_directory_uri() . '/css/customize-controls.css' );
}
add_action( 'customize_controls_print_styles', 'web_development_company_enqueue_customizer_css' );

function web_development_company_scripts() {

	wp_enqueue_style( 'web-development-company-responsive', esc_url(get_theme_file_uri())."/css/responsive.css" );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$headings_font = esc_html(get_theme_mod('web-development-company_headings_fonts'));
	$body_font = esc_html(get_theme_mod('web-development-company_body_fonts'));

	if( $headings_font ) {
		wp_enqueue_style( 'web-development-company-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );
	} else {
		wp_enqueue_style( 'web-development-company-poppins', '//fonts.googleapis.com/css?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800');
	}
	if( $body_font ) {
		wp_enqueue_style( 'web-development-company-poppins', '//fonts.googleapis.com/css?family='. $body_font );
	} else {
		wp_enqueue_style( 'web-development-company-source-body', '//fonts.googleapis.com/css?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800');
	}
}
add_action( 'wp_enqueue_scripts', 'web_development_company_scripts' );

add_action( 'customize_register', 'web_development_company_customize_register', 11 );

function web_development_company_customize_register() {
	global $wp_customize;

	$wp_customize->remove_setting( 'web_developer_main_text' );
	$wp_customize->remove_control( 'web_developer_main_text' );
	$wp_customize->remove_setting( 'web_developer_main_title' );
	$wp_customize->remove_control( 'web_developer_main_title' );
	$wp_customize->remove_setting( 'web_developerservicemaintext_color' );
	$wp_customize->remove_control( 'web_developerservicemaintext_color' );
	$wp_customize->remove_setting( 'web_developerservicemaintitle_color' );
	$wp_customize->remove_control( 'web_developerservicemaintitle_color' );

	$wp_customize->remove_setting( 'web_developerfootercopytext_color' );
	$wp_customize->remove_control( 'web_developerfootercopytext_color' );
	$wp_customize->remove_setting( 'web_developerfootercopytexthover_color' );
	$wp_customize->remove_control( 'web_developerfootercopytexthover_color' );

	$wp_customize->remove_setting( 'web_developerbuttonbg_color' );
	$wp_customize->remove_control( 'web_developerbuttonbg_color' );
	$wp_customize->remove_setting( 'web_developerbuttonbghover_color' );
	$wp_customize->remove_control( 'web_developerbuttonbghover_color' );
	$wp_customize->remove_setting( 'web_developerboxopacity_color' );
	$wp_customize->remove_control( 'web_developerboxopacity_color' );
	$wp_customize->remove_section( 'upgrade_premium' );

	// upgrade to pro
	$wp_customize->add_setting(
		'pro_info_buttons',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'web_development_company_sanitize_text',
		)
	);
	$wp_customize->add_control(
		new Web_Development_Company_Pro_Button_Customize_Control(
			$wp_customize,
			'pro_info_buttons',
			array(
				'section' => 'web_upgrade_premium',
			)
		)
	);
	
}

function web_development_company_remove_my_action() {
    remove_action( 'admin_menu','web_developer_theme_info_menu_link' );
    remove_action( 'after_switch_theme','web_developer_options' );
}
add_action( 'init', 'web_development_company_remove_my_action');


/*-- Custom metafield --*/
function web_development_company_custom_price() {
    add_meta_box( 'bn_meta', __( 'Web Development Company Meta Fields', 'web-development-company' ), 'web_development_company_render_custom_icon_meta_field', 'post', 'normal', 'high' );
}
if (is_admin()){
    add_action('admin_menu', 'web_development_company_custom_price');
}

function web_development_company_render_custom_icon_meta_field($post) {
    wp_nonce_field(basename(__FILE__), 'web_development_company_custom_icon_meta_nonce');
    $custom_icon_value = get_post_meta($post->ID, 'web_development_company_custom_icon', true);
    ?>

    <label for="web_development_company_custom_icon_field">Icon Class:</label>
    <input type="text" name="web_development_company_custom_icon_field" id="web_development_company_custom_icon_field" value="<?php echo esc_attr($custom_icon_value); ?>" />
    <p>Example: fas fa-globe</p>

    <?php if (!empty($custom_icon_value)) : ?>
        <div class="custom-icon-preview">
            <i class="<?php echo esc_attr($custom_icon_value); ?>"></i>
        </div>
    <?php endif; ?>

    <?php
}

function web_development_company_save_custom_icon_meta($post_id) {
    if (!isset($_POST['web_development_company_custom_icon_meta_nonce']) || !wp_verify_nonce($_POST['web_development_company_custom_icon_meta_nonce'], basename(__FILE__))) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['web_development_company_custom_icon_field'])) {
        update_post_meta($post_id, 'web_development_company_custom_icon', sanitize_text_field($_POST['web_development_company_custom_icon_field']));
    }
}
add_action('save_post', 'web_development_company_save_custom_icon_meta');


// upgrade to pro
function web_development_company_upgrade_pro_options( $wp_customize ) {

	$wp_customize->add_section(
		'web_upgrade_premium',
		array(
			'title'    => __( 'About Web Development Company', 'web-development-company' ),
			'priority' => 1,
		)
	);

	class Web_Development_Company_Pro_Button_Customize_Control extends WP_Customize_Control {
		public $type = 'upgrade_premium';

		function render_content() {
			?>
			<div class="pro_info">
				<ul>
					<li><a class="upgrade-to-pro" href="<?php echo esc_url( WEB_DEVELOPMENT_COMPANY_PREMIUM_PAGE ); ?>" target="_blank"><i class="dashicons dashicons-cart"></i><?php esc_html_e( 'Upgrade Pro', 'web-development-company' ); ?> </a></li>
				</ul>
			</div>
			<?php
		}
	}

	}
add_action( 'customize_register', 'web_development_company_upgrade_pro_options' );

if ( ! defined( 'WEB_DEVELOPMENT_COMPANY_PREMIUM_PAGE' ) ) {
define('WEB_DEVELOPMENT_COMPANY_PREMIUM_PAGE',__('https://www.theclassictemplates.com/wp-themes/web-wordpress-theme/','web-development-company'));
}