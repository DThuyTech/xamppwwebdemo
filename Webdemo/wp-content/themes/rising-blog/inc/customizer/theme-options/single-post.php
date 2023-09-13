<?php 
	/**
	 * Single setting section 
	 */
	// Single setting section 
	$wp_customize->add_section(
		'rising_blog_single_settings',
		array(
			'title' => esc_html__( 'Single Posts', 'rising-blog' ),
			'description' => esc_html__( 'Settings for all single posts.', 'rising-blog' ),
			'panel' => 'rising_blog_general_panel',
		)
	);

	
	// Category enable setting
	$wp_customize->add_setting(
		'rising_blog_enable_single_category',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_enable_single_category',
		array(
			'section'		=> 'rising_blog_single_settings',
			'label'			=> esc_html__( 'Enable categories.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);

	// Date enable setting
	$wp_customize->add_setting(
		'rising_blog_enable_single_date',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_enable_single_date',
		array(
			'section'		=> 'rising_blog_single_settings',
			'label'			=> esc_html__( 'Enable Date.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);


	// Author enable setting
	$wp_customize->add_setting(
		'rising_blog_enable_single_author',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_enable_single_author',
		array(
			'section'		=> 'rising_blog_single_settings',
			'label'			=> esc_html__( 'Enable Author.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);

	// Tag enable setting
	$wp_customize->add_setting(
		'rising_blog_enable_single_tag',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_enable_single_tag',
		array(
			'section'		=> 'rising_blog_single_settings',
			'label'			=> esc_html__( 'Enable tags.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);

?>