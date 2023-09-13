<?php
/*Blog Page Settings*/

Kirki::add_section( 'post_loop_settings_section', array(
    'title'          => esc_html__( 'Post Loop Settings', 'business-blogging' ),
    'panel'          => 'business_blogging_global_panel',
) );

Kirki::add_field( 'business_blogging_config', [
	'type'        => 'select',
	'settings'    => 'post_column',
	'label'       => esc_html__( 'Post Column', 'business-blogging' ),
	'section'     => 'post_loop_settings_section',
	'default'    => '1',
	'priority'    => 10,
	'choices' => [
			'4' => __( '4 Colmun', 'business-blogging' ),
			'3' => __( '3 Column', 'business-blogging' ),
			'2' => __( '2 Column', 'business-blogging' ),
			'1' => __( 'Grid', 'business-blogging' ),
		],
] );

Kirki::add_field( 'rs_personal_blog_config', array(
    'type'        => 'custom',
    'settings'    => 'sep_after_post_column',
    'label'       => '',
    'section'     => 'post_loop_settings_section',
    'default'     => '<hr>',
) );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'toggle',
    'settings'    => 'show_post_category',
    'label'       => esc_html__( 'Show Post Category', 'business-blogging' ),
    'section'     => 'post_loop_settings_section',
    'default'     => true,
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'toggle',
    'settings'    => 'show_post_title',
    'label'       => esc_html__( 'Show Post Title', 'business-blogging' ),
    'section'     => 'post_loop_settings_section',
    'default'     => true,
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'toggle',
    'settings'    => 'show_post_author',
    'label'       => esc_html__( 'Show Post Author', 'business-blogging' ),
    'section'     => 'post_loop_settings_section',
    'default'     => true,
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'toggle',
    'settings'    => 'show_post_thumbnail',
    'label'       => esc_html__( 'Thumbnail  On//Off', 'business-blogging' ),
    'section'     => 'post_loop_settings_section',
    'default'     => true,
] );
Kirki::add_field( 'business_blogging_config', [
    'type'        => 'toggle',
    'settings'    => 'show_post_excerpt',
    'label'       => esc_html__( 'Show Post Excerpt', 'business-blogging' ),
    'section'     => 'post_loop_settings_section',
    'default'     => true,
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'toggle',
    'settings'    => 'show_post_date',
    'label'       => esc_html__( 'Show Post Date', 'business-blogging' ),
    'section'     => 'post_loop_settings_section',
    'default'     => true,
] );