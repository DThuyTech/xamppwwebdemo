<?php
/*Blog Page Settings*/

Kirki::add_section( 'sidebar_settings_section', array(
    'title'          => esc_html__( 'Sidebar Settings', 'business-blogging' ),
    'description'          => esc_html__( 'Control Sidebar Of Your Website', 'business-blogging' ),
    'panel'          => 'business_blogging_global_panel',
) );

Kirki::add_field( 'business_blogging_config', [
	'type'        => 'select',
	'settings'    => 'blog_page_sidebar',
	'label'       => esc_html__( 'Blog Page Sidebar', 'business-blogging' ),
	'section'     => 'sidebar_settings_section',
	'default'     => 'right',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'left' => esc_html__( 'left Sidebar', 'business-blogging' ),
		'right' => esc_html__( 'Right Sidebar', 'business-blogging' ),
		'no' => esc_html__( 'No Sidebar', 'business-blogging' ),
	],
] );

Kirki::add_field( 'business_blogging_config', [
	'type'        => 'select',
	'settings'    => 'archive_page_sidebar',
	'label'       => esc_html__( 'Archive Page Sidebar', 'business-blogging' ),
	'section'     => 'sidebar_settings_section',
	'default'     => 'right',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'left' => esc_html__( 'left Sidebar', 'business-blogging' ),
		'right' => esc_html__( 'Right Sidebar', 'business-blogging' ),
		'no' => esc_html__( 'No Sidebar', 'business-blogging' ),
	],
] );

Kirki::add_field( 'business_blogging_config', [
	'type'        => 'select',
	'settings'    => 'page_sidebar',
	'label'       => esc_html__( 'Page Sidebar', 'business-blogging' ),
	'section'     => 'sidebar_settings_section',
	'default'     => 'right',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'left' => esc_html__( 'left Sidebar', 'business-blogging' ),
		'right' => esc_html__( 'Right Sidebar', 'business-blogging' ),
		'no' => esc_html__( 'No Sidebar', 'business-blogging' ),
	],
] );

Kirki::add_field( 'business_blogging_config', [
	'type'        => 'select',
	'settings'    => 'post_sidebar',
	'label'       => esc_html__( 'Post Sidebar', 'business-blogging' ),
	'section'     => 'sidebar_settings_section',
	'default'     => 'right',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'left' => esc_html__( 'left Sidebar', 'business-blogging' ),
		'right' => esc_html__( 'Right Sidebar', 'business-blogging' ),
		'no' => esc_html__( 'No Sidebar', 'business-blogging' ),
	],
] );
