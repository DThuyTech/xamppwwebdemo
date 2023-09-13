<?php /**
	 *
	 *
	 * Footer copyright
	 *
	 *
	 */
	// Footer copyright
	$wp_customize->add_section(
		'rising_blog_footer_section',
		array(
			'title' => esc_html__( 'Footer', 'rising-blog' ),
			'priority' => 106,
			'panel' => 'rising_blog_general_panel',
		)
	);

	// Footer copyright setting
	$wp_customize->add_setting(
		'rising_blog_copyright_txt',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_html',
			'default' => $default['rising_blog_copyright_txt'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'rising_blog_copyright_txt',
		array(
			'section'		=> 'rising_blog_footer_section',
			'label'			=> esc_html__( 'Copyright text:', 'rising-blog' ),
			'type'			=> 'textarea',
			
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'rising_blog_copyright_txt', 
		array(
	        'selector'            => '#colophon .site-info .footer-copyright',
			'render_callback'     => 'rising_blog_copyright_partial',
    	) 
    ); ?>