<?php
/*
 * @package Web Developer
 */

function web_developer_admin_enqueue_scripts() {
	wp_enqueue_style( 'web-developer-admin-style', esc_url( get_template_directory_uri() ).'/css/addon.css' );
}
add_action( 'admin_enqueue_scripts', 'web_developer_admin_enqueue_scripts' );

add_action('after_switch_theme', 'web_developer_options');

function web_developer_options () {
	global $pagenow;
	if( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) && current_user_can( 'manage_options' ) ) {
		wp_redirect( admin_url( 'themes.php?page=web-developer' ) );
		exit;
	}
}

// Footer Link
define('WEB_DEVELOPER_FOOTER_LINK',__('https://www.theclassictemplates.com/themes/free-web-developer-wordpress-theme/','web-developer'));

function web_developer_theme_info_menu_link() {

	$theme = wp_get_theme();
	add_theme_page(
		sprintf( esc_html__( 'Welcome to %1$s %2$s', 'web-developer' ), $theme->display( 'Name' ), $theme->display( 'Version' ) ),
		esc_html__( 'Theme Info', 'web-developer' ),'edit_theme_options','web-developer','web_developer_theme_info_page'
	);
}
add_action( 'admin_menu', 'web_developer_theme_info_menu_link' );

function web_developer_theme_info_page() {

	$theme = wp_get_theme();
	?>
<div class="wrap theme-info-wrap">
	<h1><?php printf( esc_html__( 'Welcome to %1$s %2$s', 'web-developer' ), esc_html($theme->display( 'Name', 'web-developer'  )),esc_html($theme->display( 'Version', 'web-developer' ))); ?>
	</h1>
	<p class="theme-description">
	<?php esc_html_e( 'Do you want to configure this theme? Look no further, our easy-to-follow theme documentation will walk you through it.', 'web-developer' ); ?>
	</p>
	<hr>
	<div class="important-links clearfix">
		<p><strong><?php esc_html_e( 'Theme Links', 'web-developer' ); ?>:</strong>
			<a href="<?php echo esc_url( WEB_DEVELOPER_THEME_PAGE ); ?>" target="_blank"><?php esc_html_e( 'Theme Page', 'web-developer' ); ?></a>
			<a href="<?php echo esc_url( WEB_DEVELOPER_SUPPORT ); ?>" target="_blank"><?php esc_html_e( 'Contact Us', 'web-developer' ); ?></a>
			<a href="<?php echo esc_url( WEB_DEVELOPER_REVIEW ); ?>" target="_blank"><?php esc_html_e( 'Rate This Theme', 'web-developer' ); ?></a>
			<a href="<?php echo esc_url( WEB_DEVELOPER_PRO_DEMO ); ?>" target="_blank"><?php esc_html_e( 'Premium Demo', 'web-developer' ); ?></a>
			<a href="<?php echo esc_url( WEB_DEVELOPER_PREMIUM_PAGE ); ?>" target="_blank"><?php esc_html_e( 'Go To Premium', 'web-developer' ); ?></a>
		</p>
	</div>
	<hr>
	<div id="getting-started">
		<h3><?php printf( esc_html__( 'Getting started with %s', 'web-developer' ), 
		esc_html($theme->display( 'Name', 'web-developer' ))); ?></h3>
		<div class="columns-wrapper clearfix">
			<div class="column column-half clearfix">
				<div class="section">
					<h4><?php esc_html_e( 'Theme Description', 'web-developer' ); ?></h4>
					<div class="theme-description-1"><?php echo esc_html($theme->display( 'Description' )); ?></div>
				</div>
			</div>
			<div class="column column-half clearfix">
				<img src="<?php echo esc_url( $theme->get_screenshot() ); ?>" alt="" />
				<div class="section">
					<h4><?php esc_html_e( 'Theme Options', 'web-developer' ); ?></h4>
					<p class="about">
					<?php printf( esc_html__( '%s makes use of the Customizer for all theme settings. Click on "Customize Theme" to open the Customizer now.', 'web-developer' ),esc_html($theme->display( 'Name', 'web-developer' ))); ?></p>
					<p>
					<a href="<?php echo esc_attr(wp_customize_url()); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Customize Theme', 'web-developer' ); ?></a>
					<a href="<?php echo esc_url( WEB_DEVELOPER_PREMIUM_PAGE ); ?>" target="_blank" class="button button-secondary premium-btn"><?php esc_html_e( 'Checkout Premium', 'web-developer' ); ?></a></p>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div id="theme-author">
	  <p><?php
		printf( esc_html__( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'web-developer' ),
			esc_html($theme->display( 'Name', 'web-developer' )),
			'<a target="_blank" href="' . esc_url( 'https://www.theclassictemplates.com/', 'web-developer' ) . '">classictemplate</a>',
			'<a target="_blank" href="' . esc_url( WEB_DEVELOPER_REVIEW ) . '" title="' . esc_attr__( 'Rate it', 'web-developer' ) . '">' . esc_html_x( 'rate it', 'If you like this theme, rate it', 'web-developer' ) . '</a>'
		)
		?></p>
	</div>
</div>
<?php
}
