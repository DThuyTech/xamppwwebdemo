<?php
/**
 * Upgrade to pro options
 */
function web_developer_upgrade_pro_options( $wp_customize ) {

	$wp_customize->add_section(
		'upgrade_premium',
		array(
			'title'    => __( 'About Web Developer', 'web-developer' ),
			'priority' => 1,
		)
	);

	class web_developer_Pro_Button_Customize_Control extends WP_Customize_Control {
		public $type = 'upgrade_premium';

		function render_content() {
			?>
			<div class="pro_info">
				<ul>

					<li><a class="upgrade-to-pro" href="<?php echo esc_url( WEB_DEVELOPER_THEME_PAGE ); ?>" target="_blank"><i class="dashicons dashicons-admin-appearance"></i><?php esc_html_e( 'Theme Page', 'web-developer' ); ?> </a></li>

					<li><a class="support" href="<?php echo esc_url( WEB_DEVELOPER_SUPPORT ); ?>' ); ?>" target="_blank"><i class="dashicons dashicons-lightbulb"></i><?php esc_html_e( 'Support Forum', 'web-developer' ); ?> </a></li>

					<li><a class="rate-us" href="<?php echo esc_url( WEB_DEVELOPER_REVIEW ); ?>' ); ?>" target="_blank"><i class="dashicons dashicons-star-filled"></i><?php esc_html_e( 'Rate Us', 'web-developer' ); ?> </a></li>

					<li><a class="free-pro" href="<?php echo esc_url( WEB_DEVELOPER_PRO_DEMO ); ?>' ); ?>" target="_blank"><i class="dashicons dashicons-awards"></i><?php esc_html_e( 'Premium Demo', 'web-developer' ); ?> </a></li>

					<li><a class="upgrade-to-pro" href="<?php echo esc_url( WEB_DEVELOPER_PREMIUM_PAGE ); ?>" target="_blank"><i class="dashicons dashicons-cart"></i><?php esc_html_e( 'Upgrade Pro', 'web-developer' ); ?> </a></li>

					<li><a class="free-pro" href="<?php echo esc_url( WEB_DEVELOPER_THEME_DOCUMENTATION ); ?>' ); ?>" target="_blank"><i class="dashicons dashicons-visibility"></i><?php esc_html_e( 'Theme Documentation', 'web-developer' ); ?> </a></li>
					
				</ul>
			</div>
			<?php
		}
	}

	$wp_customize->add_setting(
		'pro_info_buttons',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'web_developer_sanitize_text',
		)
	);

	$wp_customize->add_control(
		new web_developer_Pro_Button_Customize_Control(
			$wp_customize,
			'pro_info_buttons',
			array(
				'section' => 'upgrade_premium',
			)
		)
	);
}
add_action( 'customize_register', 'web_developer_upgrade_pro_options' );
