<?php 
/**
	 * Reset all settings
	 */
	// Reset settings section
	$wp_customize->add_section(
		'rising_blog_reset_sections',
		array(
			'title' => esc_html__( 'Reset all', 'rising-blog' ),
			'description' => esc_html__( 'Reset all settings to default.', 'rising-blog' ),
			'panel' => 'rising_blog_general_panel',
		)
	);

	// Reset sortable order setting
	$wp_customize->add_setting(
		'rising_blog_reset_settings',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => false,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'rising_blog_reset_settings',
		array(
			'section'		=> 'rising_blog_reset_sections',
			'label'			=> esc_html__( 'Reset all settings?', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);
 ?>