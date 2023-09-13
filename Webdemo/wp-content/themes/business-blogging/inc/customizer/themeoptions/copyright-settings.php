<?php
Kirki::add_section( 'copyright_section', array(
    'title'          => esc_html__( 'Copyright Section', 'business-blogging' ),
    'panel'          => 'business_blogging_global_panel',
    'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'business_blogging_config', [
	'type'     => 'editor',
	'settings' => 'copyright_text',
	'label'    => esc_html__( 'Edit Copyright Text', 'business-blogging' ),
	'section'  => 'copyright_section',
	'default'  => wp_kses_post( 'Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2023. All rights reserved.', 'business-blogging' ),
	'transport' => 'postMessage',
    'js_vars'   => [
        [
            'element'  => '.site-copyright .site-info .site-copyright-text',
            'function' => 'html',
        ]
    ],

] );