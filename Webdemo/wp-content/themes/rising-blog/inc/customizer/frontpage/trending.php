<?php
/**
	 * Trending section
	 */
	// Trending section
	$wp_customize->add_section(
		'rising_blog_trending',
		array(
			'title' => esc_html__( 'Trending Section', 'rising-blog' ),
			'panel' => 'rising_blog_home_panel',
		)
	);

	// Trending Section enable setting
	$wp_customize->add_setting(
		'rising_blog_trending_section_enable',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => false,
		)
	);

	$wp_customize->add_control(
		'rising_blog_trending_section_enable',
		array(
			'section'		=> 'rising_blog_trending',
			'label'			=> esc_html__( 'Enable Trending Section.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);
		// Trending custom content setting
	$wp_customize->add_setting(
		'rising_blog_trending_section_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['rising_blog_trending_section_title'],
		)
	);

	$wp_customize->add_control(
		'rising_blog_trending_section_title',
		array(
			'section'		=> 'rising_blog_trending',
			'label'			=> esc_html__( 'Section Title ', 'rising-blog' ),
			'active_callback' => 'rising_blog_is_trending_enable',
			'type'			=> 'text'
		)
	);

	// Trending category setting
	$wp_customize->add_setting(
		'rising_blog_trending_cat',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'rising_blog_trending_cat',
		array(
			'section'		=> 'rising_blog_trending',
			'label'			=> esc_html__( 'Category:', 'rising-blog' ),
			'active_callback' => 'rising_blog_is_trending_enable',
			'type'			=> 'select',
			'choices'		=> rising_blog_get_post_cat_choices(),
		)
	);
?>