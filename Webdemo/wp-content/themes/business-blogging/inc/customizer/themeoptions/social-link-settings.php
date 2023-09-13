<?php
Kirki::add_section( 'business_blogging_theme_social_settings', array(
    'title'          => esc_html__( 'Social Media Settings', 'business-blogging' ),
    'panel'          => 'business_blogging_global_panel',
) );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'text',
    'settings'    => 'social_facebook',
    'label'       => esc_html__( 'Facebook Link', 'business-blogging' ),
    'section'     => 'business_blogging_theme_social_settings',
    'default'     => esc_html__( 'https://facebook.com/', 'business-blogging' ),
    'transport'   => 'refresh',
] );
Kirki::add_field( 'business_blogging_config', [
    'type'        => 'text',
    'settings'    => 'social_instagram',
    'label'       => esc_html__( 'Instagram Link', 'business-blogging' ),
    'section'     => 'business_blogging_theme_social_settings',
    'default'     => esc_html__( 'https://instagram.com/', 'business-blogging' ),
    'transport'   => 'refresh',
] );
Kirki::add_field( 'business_blogging_config', [
    'type'        => 'text',
    'settings'    => 'social_linkedin',
    'label'       => esc_html__( 'LinkedIn Link', 'business-blogging' ),
    'section'     => 'business_blogging_theme_social_settings',
    'default'     => esc_html__( 'https://linkedin.com/', 'business-blogging' ),
    'transport'   => 'refresh',
] );
Kirki::add_field( 'business_blogging_config', [
    'type'        => 'text',
    'settings'    => 'social_twitter',
    'label'       => esc_html__( 'Twitter Link', 'business-blogging' ),
    'section'     => 'business_blogging_theme_social_settings',
    'default'     => esc_html__( 'https://twitter.com/', 'business-blogging' ),
    'transport'   => 'refresh',
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'color',
    'settings'    => 'social_link_color',
    'label'       => esc_html__( 'Social Media Link Color', 'business-blogging' ),
    'section'     => 'business_blogging_theme_social_settings',
    'default'     => '#ffffff',
    'transport'   => 'auto',
    'output' => array(
        array(
            'element'  => '.top-social #cssmenu ul.social-links li a',
            'property' => 'color',
        ),
    ),
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'color',
    'settings'    => 'social_link_color_hover',
    'label'       => esc_html__( 'Social Media Link Color Hover', 'business-blogging' ),
    'section'     => 'business_blogging_theme_social_settings',
    'default'     => '#484848',
    'transport'   => 'auto',
    'output' => array(
        array(
            'element'  => '.top-social #cssmenu ul.social-links li a:hover',
            'property' => 'color',
        ),
    ),
] );
?>