<?php
/**
	 * Slider section
	 */
	// Slider section
	$wp_customize->add_section(
		'rising_blog_slider',
		array(
			'title' => esc_html__( 'Banner Slider', 'rising-blog' ),
			'panel' => 'rising_blog_home_panel',
		)
	);

	// Slider Section enable setting
	$wp_customize->add_setting(
		'rising_blog_featured_slider_section_enable',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => false,
		)
	);

	$wp_customize->add_control(
		'rising_blog_featured_slider_section_enable',
		array(
			'section'		=> 'rising_blog_slider',
			'label'			=> esc_html__( 'Enable Featured Slider Section.', 'rising-blog' ),
			'type'			=> 'checkbox',
		)
	);

	// Slider Dot enable setting
	$wp_customize->add_setting(
		'rising_blog_featured_slider_dot_enable',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_featured_slider_dot_enable',
		array(
			'section'		=> 'rising_blog_slider',
			'label'			=> esc_html__( 'Enable Featured Slider Dot.', 'rising-blog' ),
			'type'			=> 'checkbox',
			'active_callback' => 'rising_blog_is_featured_slider_enable',
		)
	);

	// Slider Autoplay enable setting
	$wp_customize->add_setting(
		'rising_blog_featured_slider_autoplay_enable',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'rising_blog_featured_slider_autoplay_enable',
		array(
			'section'		=> 'rising_blog_slider',
			'label'			=> esc_html__( 'Enable Featured Slider Autoplay.', 'rising-blog' ),
			'type'			=> 'checkbox',
			'active_callback' => 'rising_blog_is_featured_slider_enable',
		)
	);

	$slider_num = get_theme_mod( 'rising_blog_slider_num', 4 );
	for ( $i=1; $i <= $slider_num; $i++ ) { 

		// Slider custom name setting
		$wp_customize->add_setting(
			'rising_blog_slider_custom_subtitle_' . $i,
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default' => $default['rising_blog_slider_custom_subtitle'],
			)
		);

		$wp_customize->add_control(
			'rising_blog_slider_custom_subtitle_' . $i,
			array(
				'section'		=> 'rising_blog_slider',
				'label'			=> esc_html__( 'Sub Title', 'rising-blog' ) . $i,
				'active_callback' => 'rising_blog_is_featured_slider_enable'
			)
		);

	    

		// Slider custom name setting
		$wp_customize->add_setting(
			'rising_blog_slider_custom_btn_' . $i,
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default' => $default['rising_blog_slider_custom_btn'],
			)
		);

		$wp_customize->add_control(
			'rising_blog_slider_custom_btn_' . $i,
			array(
				'section'		=> 'rising_blog_slider',
				'label'			=> esc_html__( 'Button text ', 'rising-blog' ) . $i,
				'active_callback' => 'rising_blog_is_featured_slider_enable'
			)
		);

		// Slider post setting
		$wp_customize->add_setting(
			'rising_blog_slider_post_' . $i,
			array(
				'sanitize_callback' => 'rising_blog_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'rising_blog_slider_post_' . $i,
			array(
				'section'		=> 'rising_blog_slider',
				'label'			=> esc_html__( 'Post ', 'rising-blog' ) . $i,
				'active_callback' => 'rising_blog_is_featured_slider_enable',
				'type'			=> 'select',
				'choices'		=> rising_blog_get_post_choices(),
			)
		);
		
		// Slider custom separator setting
		$wp_customize->add_setting(
			'rising_blog_slider_custom_separator_' . $i,
			array(
				'sanitize_callback' => 'rising_blog_sanitize_html',
			)
		);

		$wp_customize->add_control(
			new rising_blog_Separator_Custom_Control( 
			$wp_customize,
			'rising_blog_slider_custom_separator_' . $i,
				array(
					'section'		=> 'rising_blog_slider',
					'active_callback' => 'rising_blog_is_featured_slider_enable',
					'type'			=> 'rising-blog-separator',
				)
			)
		);
	}
?>