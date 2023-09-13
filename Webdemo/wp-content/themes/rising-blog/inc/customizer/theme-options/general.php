<?php 
	/**
	 * General settings
	 */
	// General settings
	$wp_customize->add_section(
		'rising_blog_general_section',
		array(
			'title' => esc_html__( 'General', 'rising-blog' ),
			'panel' => 'rising_blog_general_panel',
		)
	);
 

	// Breadcrumb enable setting
	$wp_customize->add_setting(
		'rising_blog_breadcrumb_enable',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_breadcrumb_enable',
		array(
			'section'		=> 'rising_blog_general_section',
			'label'			=> esc_html__( 'Enable breadcrumb.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);


?>