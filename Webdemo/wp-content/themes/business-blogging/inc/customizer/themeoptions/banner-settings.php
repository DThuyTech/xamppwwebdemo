<?php

Kirki::add_section( 'banner_section', array(
    'title'          => esc_html__( 'Banner Settings', 'business-blogging' ),
    'description'    => esc_html__( 'Customize Banner section', 'business-blogging' ),
    'panel'          => 'business_blogging_global_panel',
    'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'switch',
    'settings'    => 'banner_section_on_off',
    'label'       => esc_html__( 'Show/Hide Banner Section', 'business-blogging' ),
    'section'     => 'banner_section',
    'default'     => 0,
    'choices'     => [
        'on'  => esc_html__( 'Show', 'business-blogging' ),
        'off' => esc_html__( 'Hide', 'business-blogging' ),
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'     => 'textarea',
    'settings' => 'banner_title',
    'label'    => esc_html__( 'Banner Title', 'business-blogging' ),
    'section'  => 'banner_section',
    'default'  => esc_html__( 'Welcome to the Business blogging!', 'business-blogging' ),
    'transport' => 'postMessage',
    'js_vars'   => [
        [
            'element'  => '.hero-content .banner-title',
            'function' => 'html',
        ]
    ],

] );

Kirki::add_field( 'business_blogging_config', [
    'type'     => 'textarea',
    'settings' => 'banner_descriptions',
    'label'    => esc_html__( 'Banner Description', 'business-blogging' ),
    'section'  => 'banner_section',
    'default'  => esc_html__( 'Simply dummy text of the printing and typesetting industry.
has been theindustry\'s standard dummy text ever since the
1500s, when an unknownprinter ', 'business-blogging' ),
    'transport' => 'postMessage',
    'js_vars'   => [
        [
            'element'  => '.hero-content .banner-descriptions',
            'function' => 'html',
        ]
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'     => 'text',
    'settings' => 'banner_button_text',
    'label'    => esc_html__( 'Button Text', 'business-blogging' ),
    'section'  => 'banner_section',
    'default'  => esc_html__( 'Discover', 'business-blogging' ),
    'transport' => 'postMessage',
    'js_vars'   => [
        [
            'element'  => '.discover-me-button a',
            'function' => 'html',
        ]
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'     => 'link',
    'settings' => 'banner_button_link',
    'label'    => esc_html__( 'Button Link', 'business-blogging' ),
    'section'  => 'banner_section',
    'default'  => '#',
] );

Kirki::add_field( 'business_blogging_config', [
    'type'     => 'textarea',
    'settings' => 'banner_title2',
    'label'    => esc_html__( 'Banner Title 2', 'business-blogging' ),
    'section'  => 'banner_section',
    'default'  => esc_html__( 'Share your Business Blogging!', 'business-blogging' ),
    'transport' => 'postMessage',
    'js_vars'   => [
        [
            'element'  => '.hero-content .banner-title',
            'function' => 'html',
        ]
    ],

] );

Kirki::add_field( 'business_blogging_config', [
    'type'     => 'textarea',
    'settings' => 'banner_descriptions2',
    'label'    => esc_html__( 'Banner Description 2', 'business-blogging' ),
    'section'  => 'banner_section',
    'default'  => esc_html__( 'Simply dummy text of the printing and typesetting industry.
has been theindustry\'s standard dummy text ever since the
1500s, when an unknownprinter ', 'business-blogging' ),
    'transport' => 'postMessage',
    'js_vars'   => [
        [
            'element'  => '.hero-content .banner-descriptions',
            'function' => 'html',
        ]
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'     => 'text',
    'settings' => 'banner_button_text2',
    'label'    => esc_html__( 'Button Text 2', 'business-blogging' ),
    'section'  => 'banner_section',
    'default'  => esc_html__( 'Discover', 'business-blogging' ),
    'transport' => 'postMessage',
    'js_vars'   => [
        [
            'element'  => '.discover-me-button a',
            'function' => 'html',
        ]
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'     => 'link',
    'settings' => 'banner_button_link2',
    'label'    => esc_html__( 'Button Link 2', 'business-blogging' ),
    'section'  => 'banner_section',
    'default'  => '#',
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'multicolor',
    'settings'    => 'banner_bg_overlay_settings',
    'label'       => esc_html__( 'Banner Background Overlay', 'business-blogging' ),
    'section'     => 'banner_section',
    'choices'     => [
        'banner_overlay'    => esc_html__( 'Background Color', 'business-blogging' ),
    ],
    'transport' => 'auto',
    'default'     => [
        'banner_overlay'    => '#000000',
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'background',
    'settings'    => 'banner_bg_settings',
    'label'       => esc_html__( 'Banner Background', 'business-blogging' ),
    'description' => esc_html__( 'Define The Background Of Banner Section', 'business-blogging' ),
    'section'     => 'banner_section',
    'default'     => [
        'background-color'      => '#b1c0c8',
        'background-image'      => '',
        'background-repeat'     => 'repeat',
        'background-position'   => 'center center',
        'background-size'       => 'cover',
        'background-attachment' => 'scroll',
    ],
    'transport'   => 'auto',
    'output'      => [
        [
            'element' => 'section.banner-section',
        ],
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'typography',
    'settings'    => 'banner_title_typography',
    'label'       => esc_html__( 'Banner Title Typography', 'business-blogging' ),
    'section'     => 'banner_section',
    'default'     => [
        'font-family'    => 'Roboto',
        'variant'        => 'bold',
        'font-size'      => '3.375rem',
        'line-height'    => '1.6',
        'letter-spacing' => '0px',
        'color'          => '#ffffff',
        'text-transform' => 'none',
        'text-align'     => 'left',
    ],

    'transport'   => 'auto',
    'output'      => [
        [
            'element' => '.banner-title',
        ],
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'typography',
    'settings'    => 'banner_paragraph_typography',
    'label'       => esc_html__( 'Banner Paragraph Typography', 'business-blogging' ),
    'section'     => 'banner_section',
    'default'     => [
        'font-family'    => 'Roboto',
        'variant'        => 'regular',
        'font-size'      => '1rem',
        'line-height'    => '1.6',
        'letter-spacing' => '0px',
        'color'          => '#ffffff',
        'text-transform' => 'none',
        'text-align'     => 'left',
    ],
    'transport'   => 'auto',
    'output'      => [
        [
            'element' => '.banner-descriptions',
        ],
    ],
] );

Kirki::add_field( 'business_blogging_config', [
    'type'        => 'multicolor',
    'settings'    => 'banner_button_colors',
    'label'       => esc_html__( 'Button Color', 'business-blogging' ),
    'section'     => 'banner_section',
    'choices'     => [
        'btn_bg'    => esc_html__( 'Background Color', 'business-blogging' ),
        'btn_text'   => esc_html__( 'Text Color', 'business-blogging' ),
        'btn_hover_bg'   => esc_html__( 'Background Hover Color', 'business-blogging' ),
        'btn_hover_text'   => esc_html__( 'Text Hover Color', 'business-blogging' ),
    ],
    'transport' => 'auto',
    'default'     => [
        'btn_bg'    => '#3080d7',
        'btn_text'   => '#ffffff',
        'btn_hover_bg'   => '#000000',
        'btn_hover_text'   => '#ffffff',
    ],
] );

