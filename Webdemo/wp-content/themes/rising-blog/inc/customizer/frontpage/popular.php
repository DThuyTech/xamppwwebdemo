<?php
/**
	 * Popular section
	 */
	// Popular section
	$wp_customize->add_section(
		'rising_blog_popular',
		array(
			'title' => esc_html__( 'Popular Post', 'rising-blog' ),
			'panel' => 'rising_blog_home_panel',
		)
	);

	// Popular Section enable setting
	$wp_customize->add_setting(
		'rising_blog_popular_section_enable',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => false,
		)
	);

	$wp_customize->add_control(
		'rising_blog_popular_section_enable',
		array(
			'section'		=> 'rising_blog_popular',
			'label'			=> esc_html__( 'Enable Popular Section.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);

	// Popular title setting
	$wp_customize->add_setting(
		'rising_blog_popular_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'rising_blog_popular_title',
		array(
			'section'		=> 'rising_blog_popular',
			'label'			=> esc_html__( 'Title:', 'rising-blog' ),
			'active_callback' => 'rising_blog_is_popular_enable'
		)
	);

	// Popular title setting
	$wp_customize->add_setting(
		'rising_blog_popular_subtitle',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'rising_blog_popular_subtitle',
		array(
			'section'		=> 'rising_blog_popular',
			'label'			=> esc_html__( 'Sub Title:', 'rising-blog' ),
			'active_callback' => 'rising_blog_is_popular_enable'
		)
	);

	// Popular number setting
	$wp_customize->add_setting(
		'rising_blog_popular_num',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_number_range',
			'default' => 6,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'rising_blog_popular_num',
		array(
			'section'		=> 'rising_blog_popular',
			'label'			=> esc_html__( 'Number of popular:', 'rising-blog' ),
			'description'			=> esc_html__( 'Min: 2 | Max:6/60(Pro)', 'rising-blog' ),
			'active_callback' => 'rising_blog_is_popular_enable',
			'type'			=> 'number',
			'input_attrs'	=> array( 'min' => 2,'step' => 2, 'max' => 6 ),
		)
	);

	// Popular category setting
	$wp_customize->add_setting(
		'rising_blog_popular_cat',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'rising_blog_popular_cat',
		array(
			'section'		=> 'rising_blog_popular',
			'label'			=> esc_html__( 'Category:', 'rising-blog' ),
			'active_callback' => 'rising_blog_is_popular_enable',
			'type'			=> 'select',
			'choices'		=> rising_blog_get_post_cat_choices(),
		)
	);
?>