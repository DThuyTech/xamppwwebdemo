<?php 

	// Pagination type setting
	$wp_customize->add_setting(
		'rising_blog_archive_pagination_type',
		array(
			'sanitize_callback' => 'rising_blog_sanitize_select',
			'default' => 'older_newer',
		)
	);

	$archive_pagination_description = '';
	$archive_pagination_choices = array( 
				'disable' => esc_html__( '--Disable--', 'rising-blog' ),
				'older_newer' => esc_html__( 'Older / Newer', 'rising-blog' ),
			);
	
	$wp_customize->add_control(
		'rising_blog_archive_pagination_type',
		array(
			'section'		=> 'rising_blog_archive_settings',
			'label'			=> esc_html__( 'Pagination type:', 'rising-blog' ),
			'description'			=>  $archive_pagination_description,
			'type'			=> 'select',
			'choices'		=> $archive_pagination_choices,
		)
	);
 ?>