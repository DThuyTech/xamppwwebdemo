<?php 
/**
	 * Blog/Archive section 
	 */
	// Blog/Archive section 
	$wp_customize->add_section(
		'rising_blog_archive_settings',
		array(
			'title' => esc_html__( 'Archive/Blog', 'rising-blog' ),
			'description' => esc_html__( 'Settings for archive pages including blog page too.', 'rising-blog' ),
			'panel' => 'rising_blog_general_panel',
		)
	);

	// Archive excerpt setting
	$wp_customize->add_setting(
		'rising_blog_archive_excerpt',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'View the post', 'rising-blog' ),
		)
	);

	$wp_customize->add_control(
		'rising_blog_archive_excerpt',
		array(
			'section'		=> 'rising_blog_archive_settings',
			'label'			=> esc_html__( 'Excerpt more text:', 'rising-blog' ),
		)
	);

	// number setting
	$wp_customize->add_setting(
		'rising_blog_blog_archive_column',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_number_range',
			'default' => 1,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'rising_blog_archive_excerpt_length',
		array(
			'section'		=> 'rising_blog_archive_settings',
			'label'			=> esc_html__( 'Excerpt more length:', 'rising-blog' ),
			'type'			=> 'number',
			'input_attrs'   => array( 'min' => 5 ),
		)
	);

	// Category enable setting
	$wp_customize->add_setting(
		'rising_blog_enable_archive_category',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_enable_archive_category',
		array(
			'section'		=> 'rising_blog_archive_settings',
			'label'			=> esc_html__( 'Enable Category.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);


	// Tag enable setting
	$wp_customize->add_setting(
		'rising_blog_enable_archive_tag',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_enable_archive_tag',
		array(
			'section'		=> 'rising_blog_archive_settings',
			'label'			=> esc_html__( 'Enable tags.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);


	// Featured image enable setting
	$wp_customize->add_setting(
		'rising_blog_enable_archive_featured_img',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_enable_archive_featured_img',
		array(
			'section'		=> 'rising_blog_archive_settings',
			'label'			=> esc_html__( 'Enable featured image.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);

 ?>