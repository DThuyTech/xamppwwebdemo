<?php /**
	 * Single pages setting section 
	 */
	// Single pages setting section 
	$wp_customize->add_section(
		'rising_blog_single_page_settings',
		array(
			'title' => esc_html__( 'Single Pages', 'rising-blog' ),
			'description' => esc_html__( 'Settings for all single pages.', 'rising-blog' ),
			'panel' => 'rising_blog_general_panel',
		)
	);

	// Author enable setting
	$wp_customize->add_setting(
		'rising_blog_enable_single_page_author',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => false,
		)
	);

	$wp_customize->add_control(
		'rising_blog_enable_single_page_author',
		array(
			'section'		=> 'rising_blog_single_page_settings',
			'label'			=> esc_html__( 'Enable Page Author.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);

?>