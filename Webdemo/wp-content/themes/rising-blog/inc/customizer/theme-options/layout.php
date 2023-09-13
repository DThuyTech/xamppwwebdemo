<?php 
/**
	 * Global Layout
	 */
	// Global Layout
	$wp_customize->add_section(
		'rising_blog_global_layout',
		array(
			'title' => esc_html__( 'Global Layout', 'rising-blog' ),
			'panel' => 'rising_blog_general_panel',
		)
	);

	// Global site layout setting
	$wp_customize->add_setting(
		'rising_blog_site_layout',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_select',
			'default' => 'wide',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'rising_blog_site_layout',
		array(
			'section'		=> 'rising_blog_global_layout',
			'label'			=> esc_html__( 'Site layout', 'rising-blog' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'boxed' => esc_html__( 'Boxed', 'rising-blog' ), 
				'wide' => esc_html__( 'Wide', 'rising-blog' ), 
			),
		)
	);

	// Global archive layout setting
	$wp_customize->add_setting(
		'rising_blog_archive_sidebar',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'rising_blog_archive_sidebar',
		array(
			'section'		=> 'rising_blog_global_layout',
			'label'			=> esc_html__( 'Archive Sidebar', 'rising-blog' ),
			'description'			=> esc_html__( 'This option works on all archive pages like: 404, search, date, category and so on.', 'rising-blog' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'left' => esc_html__( 'Left', 'rising-blog' ), 
				'right' => esc_html__( 'Right', 'rising-blog' ),
			),
		)
	);

	// Blog layout setting
	$wp_customize->add_setting(
		'rising_blog_blog_sidebar',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'rising_blog_blog_sidebar',
		array(
			'section'		=> 'rising_blog_global_layout',
			'label'			=> esc_html__( 'Blog Sidebar', 'rising-blog' ),
			'description'			=> esc_html__( 'This option works on blog and "Your latest posts"', 'rising-blog' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'left' => esc_html__( 'Left', 'rising-blog' ), 
				'right' => esc_html__( 'Right', 'rising-blog' ),
			),
		)
	);

	// Global page layout setting
	$wp_customize->add_setting(
		'rising_blog_global_page_layout',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'rising_blog_global_page_layout',
		array(
			'section'		=> 'rising_blog_global_layout',
			'label'			=> esc_html__( 'Global page sidebar', 'rising-blog' ),
			'description'			=> esc_html__( 'This option works only on single pages including "Posts page". This setting can be overridden for single page from the metabox too.', 'rising-blog' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'left' => esc_html__( 'Left', 'rising-blog' ),  
				'right' => esc_html__( 'Right', 'rising-blog' ),
			),
		)
	);

	// Global post layout setting
	$wp_customize->add_setting(
		'rising_blog_global_post_layout',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'rising_blog_global_post_layout',
		array(
			'section'		=> 'rising_blog_global_layout',
			'label'			=> esc_html__( 'Global post sidebar', 'rising-blog' ),
			'description'			=> esc_html__( 'This option works only on single posts. This setting can be overridden for single post from the metabox too.', 'rising-blog' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'left' => esc_html__( 'Left', 'rising-blog' ), 
				'right' => esc_html__( 'Right', 'rising-blog' ),
			),
		)
	);
 ?>