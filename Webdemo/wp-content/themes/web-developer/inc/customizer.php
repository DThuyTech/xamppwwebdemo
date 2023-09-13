<?php
/**
 * Web Developer Theme Customizer
 *
 * @package Web Developer
 */

get_template_part('/inc/select/category-dropdown-custom-control');

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function web_developer_customize_register( $wp_customize ) {

	function web_developer_sanitize_phone_number( $phone ) {
		return preg_replace( '/[^\d+]/', '', $phone );
	}

	function web_developer_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}

	wp_enqueue_style('web-developer-customize-controls', trailingslashit(esc_url(get_template_directory_uri())).'/css/customize-controls.css');

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->add_setting('web_developer_title_enable',array(
		'default' => true,
		'sanitize_callback' => 'web_developer_sanitize_checkbox',
	));
	$wp_customize->add_control( 'web_developer_title_enable', array(
	   'settings' => 'web_developer_title_enable',
	   'section'   => 'title_tagline',
	   'label'     => __('Enable Site Title','web-developer'),
	   'type'      => 'checkbox'
	));

	// sitetitle color
	$wp_customize->add_setting('web_developer_sitetitle_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_sitetitle_color', array(
	   'settings' => 'web_developer_sitetitle_color',
	   'section'   => 'title_tagline',
	   'label' => __('Site Title Color', 'web-developer'),
	   'type'      => 'color'
	));

	$wp_customize->add_setting('web_developer_tagline_enable',array(
		'default' => false,
		'sanitize_callback' => 'web_developer_sanitize_checkbox',
	));
	$wp_customize->add_control( 'web_developer_tagline_enable', array(
	   'settings' => 'web_developer_tagline_enable',
	   'section'   => 'title_tagline',
	   'label'     => __('Enable Site Tagline','web-developer'),
	   'type'      => 'checkbox'
	));

	// sitetagline color
	$wp_customize->add_setting('web_developer_sitetagline_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_sitetagline_color', array(
	   'settings' => 'web_developer_sitetagline_color',
	   'section'   => 'title_tagline',
	   'label' => __('Site Tagline Color', 'web-developer'),
	   'type'      => 'color'
	));


	//Theme Options
	$wp_customize->add_panel( 'web_developer_panel_area', array(
		'priority' => 10,
		'capability' => 'edit_theme_options',
		'title' => __( 'Theme Options Panel', 'web-developer' ),
	) );

	//Site Layout Section
	$wp_customize->add_section('web_developer_site_layoutsec',array(
		'title'	=> __('Manage Site Layout Section ','web-developer'),
		'description' => __('<p class="sec-title">Manage Site Layout Section</p>','web-developer'),
		'priority'	=> 1,
		'panel' => 'web_developer_panel_area',
	));

	$wp_customize->add_setting('web_developer_preloader',array(
		'default' => true,
		'sanitize_callback' => 'web_developer_sanitize_checkbox',
	));
	$wp_customize->add_control( 'web_developer_preloader', array(
	   'section'   => 'web_developer_site_layoutsec',
	   'label'	=> __('Check to show preloader','web-developer'),
	   'type'      => 'checkbox'
 	));

	// Header Section
	$wp_customize->add_section('web_developer_header_section', array(
        'title' => __('Manage Header Section', 'web-developer'),
		'description' => __('<p class="sec-title">Manage Header Section</p>','web-developer'),
        'priority' => null,
		'panel' => 'web_developer_panel_area',
 	));

 	$wp_customize->add_setting('web_developer_stickyheader',array(
		'default' => false,
		'sanitize_callback' => 'web_developer_sanitize_checkbox',
	));

	$wp_customize->add_control( 'web_developer_stickyheader', array(
	   'section'   => 'web_developer_header_section',
	   'label'	=> __('Check To Show Sticky Header','web-developer'),
	   'type'      => 'checkbox'
 	));

	// top bg color
	$wp_customize->add_setting('web_developer_bgtop_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_bgtop_color', array(
	   'settings' => 'web_developer_bgtop_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Top Header BG Color', 'web-developer'),
	   'type'      => 'color'
	));


	$wp_customize->add_setting('web_developer_address_location_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_address_location_text', array(
	   'settings' => 'web_developer_address_location_text',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Add Text', 'web-developer'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('web_developer_address_location',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_address_location', array(
	   'settings' => 'web_developer_address_location',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Add Location Address', 'web-developer'),
	   'type'      => 'text'
	));


 	$wp_customize->add_setting('web_developer_email_address_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_email_address_text', array(
	   'settings' => 'web_developer_email_address_text',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Add Text', 'web-developer'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('web_developer_email_address',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_email',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_email_address', array(
	   'settings' => 'web_developer_email_address',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Add Email Address', 'web-developer'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('web_developer_phone_number_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_phone_number_text', array(
	   'settings' => 'web_developer_phone_number_text',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Add Text', 'web-developer'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('web_developer_phone_number',array(
		'default' => '',
		'sanitize_callback' => 'web_developer_sanitize_phone_number',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_phone_number', array(
	   'settings' => 'web_developer_phone_number',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Add Phone Number', 'web-developer'),
	   'type'      => 'text'
	));


	// addressicon color
	$wp_customize->add_setting('web_developer_addressicon_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_addressicon_color', array(
	   'settings' => 'web_developer_addressicon_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Icon Color', 'web-developer'),
	   'type'      => 'color'
	));

	// titleaddress color
	$wp_customize->add_setting('web_developer_titleaddress_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_titleaddress_color', array(
	   'settings' => 'web_developer_titleaddress_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Title Color', 'web-developer'),
	   'type'      => 'color'
	));

	// addresstext color
	$wp_customize->add_setting('web_developer_addresstext_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_addresstext_color', array(
	   'settings' => 'web_developer_addresstext_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Text Color', 'web-developer'),
	   'type'      => 'color'
	));

	// border color
	$wp_customize->add_setting('web_developer_border_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_border_color', array(
	   'settings' => 'web_developer_border_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Border Color', 'web-developer'),
	   'type'      => 'color'
	));



	// Bottom bg color
	$wp_customize->add_setting('web_developer_bgBottom_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_bgBottom_color', array(
	   'settings' => 'web_developer_bgBottom_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Bottom Header BG Color', 'web-developer'),
	   'type'      => 'color'
	));


	// Menu color
	$wp_customize->add_setting('web_developerMenu_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerMenu_color', array(
	   'settings' => 'web_developerMenu_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Menus Color', 'web-developer'),
	   'type'      => 'color'
	));

	// subMenu color
	$wp_customize->add_setting('web_developersubMenu_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developersubMenu_color', array(
	   'settings' => 'web_developersubMenu_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('SubMenus Color', 'web-developer'),
	   'type'      => 'color'
	));

	// subMenubg color
	$wp_customize->add_setting('web_developersubMenubg_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developersubMenubg_color', array(
	   'settings' => 'web_developersubMenubg_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('SubMenus BG Color', 'web-developer'),
	   'type'      => 'color'
	));

	// subMenuborder color
	$wp_customize->add_setting('web_developersubMenuborder_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developersubMenuborder_color', array(
	   'settings' => 'web_developersubMenuborder_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('SubMenus Border Color', 'web-developer'),
	   'type'      => 'color'
	));



	// searchbg color
	$wp_customize->add_setting('web_developersearchbg_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developersearchbg_color', array(
	   'settings' => 'web_developersearchbg_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('Search BG Color', 'web-developer'),
	   'type'      => 'color'
	));


	// mobileviewmenutext color
	$wp_customize->add_setting('web_developermobileviewmenutext_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developermobileviewmenutext_color', array(
	   'settings' => 'web_developermobileviewmenutext_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('MobileView Menu Toggle Text Color', 'web-developer'),
	   'type'      => 'color'
	));

	// mobileviewmenubg color
	$wp_customize->add_setting('web_developermobileviewmenubg_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developermobileviewmenubg_color', array(
	   'settings' => 'web_developermobileviewmenubg_color',
	   'section'   => 'web_developer_header_section',
	   'label' => __('MobileView Menu Toggle BG Color', 'web-developer'),
	   'type'      => 'color'
	));


	// Home Category Dropdown Section
	$wp_customize->add_section('web_developer_one_cols_section',array(
		'title'	=> __('Manage Slider Section','web-developer'),
		'description'	=> __('<p class="sec-title">Manage Slider Section</p> Select Category from the Dropdowns for slider, Also use the given image dimension (1600 x 850).','web-developer'),
		'priority'	=> null,
		'panel' => 'web_developer_panel_area'
	));

	// Add a category dropdown Slider Coloumn
	$wp_customize->add_setting( 'web_developer_slidersection', array(
		'default'	=> '0',
		'sanitize_callback'	=> 'absint'
	) );
	$wp_customize->add_control( new Web_Developer_Category_Dropdown_Custom_Control( $wp_customize, 'web_developer_slidersection', array(
		'section' => 'web_developer_one_cols_section',
		'settings'   => 'web_developer_slidersection',
	) ) );

	//Hide Section
	$wp_customize->add_setting('web_developer_hide_categorysec',array(
		'default' => false,
		'sanitize_callback' => 'web_developer_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_hide_categorysec', array(
	   'settings' => 'web_developer_hide_categorysec',
	   'section'   => 'web_developer_one_cols_section',
	   'label'     => __('Check To Enable This Section','web-developer'),
	   'type'      => 'checkbox'
	));

	$wp_customize->add_setting( 'web_developer_slider_count', array(
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'web_developer_sanitize_number_absint',
	  'default' => 1,
	) );
	$wp_customize->add_control( 'web_developer_slider_count', array(
	  'settings' => 'web_developer_slider_count',
	  'type' => 'number',
	  'section' => 'web_developer_one_cols_section',
	  'label' => __( 'Number of slide to show','web-developer'),
	) );

	$wp_customize->add_setting('web_developer_button_text',array(
		'default' => 'Start Now',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_button_text', array(
	   'settings' => 'web_developer_button_text',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Add Button Text', 'web-developer'),
	   'type'      => 'text'
	));


	// slidertitle color
	$wp_customize->add_setting('web_developerslidertitle_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerslidertitle_color', array(
	   'settings' => 'web_developerslidertitle_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Title Color', 'web-developer'),
	   'type'      => 'color'
	));

	// sliderdescription color
	$wp_customize->add_setting('web_developersliderdescription_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developersliderdescription_color', array(
	   'settings' => 'web_developersliderdescription_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Description Color', 'web-developer'),
	   'type'      => 'color'
	));

	// sliderbtntext color
	$wp_customize->add_setting('web_developersliderbtntext_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developersliderbtntext_color', array(
	   'settings' => 'web_developersliderbtntext_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Button Text Color', 'web-developer'),
	   'type'      => 'color'
	));

	// sliderbtntexthover color
	$wp_customize->add_setting('web_developersliderbtntexthover_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developersliderbtntexthover_color', array(
	   'settings' => 'web_developersliderbtntexthover_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Button Hover Text Color', 'web-developer'),
	   'type'      => 'color'
	));

	// buttonbg color
	$wp_customize->add_setting('web_developerbuttonbg_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerbuttonbg_color', array(
	   'settings' => 'web_developerbuttonbg_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Button BG Color', 'web-developer'),
	   'type'      => 'color'
	));

	// buttonbghover color
	$wp_customize->add_setting('web_developerbuttonbghover_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerbuttonbghover_color', array(
	   'settings' => 'web_developerbuttonbghover_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Button Hover BG Color', 'web-developer'),
	   'type'      => 'color'
	));

	// boxopacity color
	$wp_customize->add_setting('web_developerboxopacity_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerboxopacity_color', array(
	   'settings' => 'web_developerboxopacity_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Box Opacity Color', 'web-developer'),
	   'type'      => 'color'
	));


	// arrow color
	$wp_customize->add_setting('web_developerarrow_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerarrow_color', array(
	   'settings' => 'web_developerarrow_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Arrows Color', 'web-developer'),
	   'type'      => 'color'
	));

	// arrowborder color
	$wp_customize->add_setting('web_developerarrowborder_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerarrowborder_color', array(
	   'settings' => 'web_developerarrowborder_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Arrows Border Color', 'web-developer'),
	   'type'      => 'color'
	));

	// arrowhover color
	$wp_customize->add_setting('web_developerarrowhover_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerarrowhover_color', array(
	   'settings' => 'web_developerarrowhover_color',
	   'section'   => 'web_developer_one_cols_section',
	   'label' => __('Arrows Hover Color', 'web-developer'),
	   'type'      => 'color'
	));




	// Services Section
	$wp_customize->add_section('web_developer_below_slider_section', array(
		'title'	=> __('Manage Services Section','web-developer'),
		'description'	=> __('<p class="sec-title">Manage Services Section</p> Select Pages from the dropdown for Services.','web-developer'),
		'priority'	=> null,
		'panel' => 'web_developer_panel_area',
	));


	// Add a category dropdown Slider Coloumn
	$wp_customize->add_setting( 'web_developer_services_cat', array(
		'default'	=> '0',
		'sanitize_callback'	=> 'absint'
	) );
	$wp_customize->add_control( new Web_Developer_Category_Dropdown_Custom_Control( $wp_customize, 'web_developer_services_cat', array(
		'section' => 'web_developer_below_slider_section',
		'settings'   => 'web_developer_services_cat',
	) ) );

	$wp_customize->add_setting('web_developer_disabled_pgboxes',array(
		'default' => false,
		'sanitize_callback' => 'web_developer_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developer_disabled_pgboxes', array(
	   'settings' => 'web_developer_disabled_pgboxes',
	   'section'   => 'web_developer_below_slider_section',
	   'label'     => __('Check To Enable This Section','web-developer'),
	   'type'      => 'checkbox'
	));

	$wp_customize->add_setting('web_developer_main_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_main_text', array(
	   'settings' => 'web_developer_main_text',
	   'section'   => 'web_developer_below_slider_section',
	   'label' => __('Add Main Text', 'web-developer'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('web_developer_main_title',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'web_developer_main_title', array(
	   'settings' => 'web_developer_main_title',
	   'section'   => 'web_developer_below_slider_section',
	   'label' => __('Add Main Title', 'web-developer'),
	   'type'      => 'text'
	));


	// servicemaintext color
	$wp_customize->add_setting('web_developerservicemaintext_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerservicemaintext_color', array(
	   'settings' => 'web_developerservicemaintext_color',
	   'section'   => 'web_developer_below_slider_section',
	   'label' => __('Main Text Color', 'web-developer'),
	   'type'      => 'color'
	));

	// servicemaintitle color
	$wp_customize->add_setting('web_developerservicemaintitle_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerservicemaintitle_color', array(
	   'settings' => 'web_developerservicemaintitle_color',
	   'section'   => 'web_developer_below_slider_section',
	   'label' => __('Main Title Color', 'web-developer'),
	   'type'      => 'color'
	));

	// serviceborder color
	$wp_customize->add_setting('web_developerserviceborder_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerserviceborder_color', array(
	   'settings' => 'web_developerserviceborder_color',
	   'section'   => 'web_developer_below_slider_section',
	   'label' => __('Border Color', 'web-developer'),
	   'type'      => 'color'
	));


	// servicetitle color
	$wp_customize->add_setting('web_developerservicetitle_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerservicetitle_color', array(
	   'settings' => 'web_developerservicetitle_color',
	   'section'   => 'web_developer_below_slider_section',
	   'label' => __('Title Color', 'web-developer'),
	   'type'      => 'color'
	));

	// servicedescription color
	$wp_customize->add_setting('web_developerservicedescription_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerservicedescription_color', array(
	   'settings' => 'web_developerservicedescription_color',
	   'section'   => 'web_developer_below_slider_section',
	   'label' => __('Description Color', 'web-developer'),
	   'type'      => 'color'
	));



	// Footer Section
	$wp_customize->add_section('web_developer_footer', array(
		'title'	=> __('Manage Footer Section','web-developer'),
		'description'	=> __('<p class="sec-title">Manage Footer Section</p>','web-developer'),
		'priority'	=> null,
		'panel' => 'web_developer_panel_area',
	));


    // footerbg color
	$wp_customize->add_setting('web_developerfooterbg_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfooterbg_color', array(
	   'settings' => 'web_developerfooterbg_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer BG Color', 'web-developer'),
	   'type'      => 'color'
	));

	$wp_customize->add_setting('web_developer_copyright_line',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control( 'web_developer_copyright_line', array(
	   'section' 	=> 'web_developer_footer',
	   'label'	 	=> __('Copyright Line','web-developer'),
	   'type'    	=> 'text',
	   'priority' 	=> null,
    ));

    $wp_customize->add_setting('web_developer_copyright_link',array(
    	'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control( 'web_developer_copyright_link', array(
	   'section' 	=> 'web_developer_footer',
	   'label'	 	=> __('Link','web-developer'),
	   'type'    	=> 'text',
	   'priority' 	=> null,
    ));

    // footercopytext color
	$wp_customize->add_setting('web_developerfootercopytext_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfootercopytext_color', array(
	   'settings' => 'web_developerfootercopytext_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer Copyright Text Color', 'web-developer'),
	   'type'      => 'color'
	));

	// footercopytexthover color
	$wp_customize->add_setting('web_developerfootercopytexthover_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfootercopytexthover_color', array(
	   'settings' => 'web_developerfootercopytexthover_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer Copyright Text Hover Color', 'web-developer'),
	   'type'      => 'color'
	));

	// footercopybg color
	$wp_customize->add_setting('web_developerfootercopybg_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfootercopybg_color', array(
	   'settings' => 'web_developerfootercopybg_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer Copyright BG Color', 'web-developer'),
	   'type'      => 'color'
	));

	// footerheading color
	$wp_customize->add_setting('web_developerfooterheading_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfooterheading_color', array(
	   'settings' => 'web_developerfooterheading_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer Heading Color', 'web-developer'),
	   'type'      => 'color'
	));

	// footerdesciption color
	$wp_customize->add_setting('web_developerfooterdesciption_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfooterdesciption_color', array(
	   'settings' => 'web_developerfooterdesciption_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer Description Color', 'web-developer'),
	   'type'      => 'color'
	));


	// footerlist color
	$wp_customize->add_setting('web_developerfooterlist_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfooterlist_color', array(
	   'settings' => 'web_developerfooterlist_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer List Color', 'web-developer'),
	   'type'      => 'color'
	));

	// footerlistborder color
	$wp_customize->add_setting('web_developerfooterlistborder_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfooterlistborder_color', array(
	   'settings' => 'web_developerfooterlistborder_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer List Border Color', 'web-developer'),
	   'type'      => 'color'
	));


	// footerlisthover color
	$wp_customize->add_setting('web_developerfooterlisthover_color',array(
		'default' => '',
		'sanitize_callback' => 'esc_html',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'web_developerfooterlisthover_color', array(
	   'settings' => 'web_developerfooterlisthover_color',
	   'section'   => 'web_developer_footer',
	   'label' => __('Footer List Hover Color', 'web-developer'),
	   'type'      => 'color'
	));


	$wp_customize->add_setting('web_developer_scroll_hide', array(
        'default' => false,
        'sanitize_callback' => 'web_developer_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'web_developer_scroll_hide',array(
        'label'          => __( 'Check To Show Scroll To Top', 'web-developer' ),
        'section'        => 'web_developer_footer',
        'settings'       => 'web_developer_scroll_hide',
        'type'           => 'checkbox',
    )));


    $wp_customize->add_setting('web_developer_color_scheme_gradiant1',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));

    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	    $wp_customize,
	    'web_developer_color_scheme_gradiant1',
	    array(
	        'label'      => __( 'Color Scheme', 'web-developer' ),
	        'section'    => 'colors',
	        'settings'   => 'web_developer_color_scheme_gradiant1',
	    ) )
	);

	// Google Fonts
    $wp_customize->add_section( 'web_developer_google_fonts_section', array(
		'title'       => __( 'Google Fonts', 'web-developer' ),
		'priority'    => 24,
	) );

	$font_choices = array(
		'' => 'select',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Abril Fatface' => 'Abril Fatface',
		'Acme' => 'Acme',
		'Anton' => 'Anton',
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Architects Daughter' => 'Architects Daughter',
		'Arsenal' => 'Arsenal',
		'Alegreya' => 'Alegreya',
		'Alfa Slab One' => 'Alfa Slab One',
		'Averia Serif Libre' => 'Averia Serif Libre',
		'Bitter:400,700,400italic' => 'Bitter',
		'Bangers' => 'Bangers',
		'Boogaloo' => 'Boogaloo',
		'Bad Script' => 'Bad Script',
		'Bree Serif' => 'Bree Serif',
		'BenchNine' => 'BenchNine',
		'Cabin:400,700,400italic' => 'Cabin',
		'Cardo' => 'Cardo',
		'Courgette' => 'Courgette',
		'Cherry Swash' => 'Cherry Swash',
		'Cormorant Garamond' => 'Cormorant Garamond',
		'Crimson Text' => 'Crimson Text',
		'Cuprum' => 'Cuprum',
		'Cookie' => 'Cookie',
		'Chewy' => 'Chewy',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'Droid Sans:400,700' => 'Droid Sans',
		'Days One' => 'Days One',
		'Dosis' => 'Dosis',
		'Emilys Candy:' => 'Emilys Candy',
		'Economica' => 'Economica',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Fredoka One' => 'Fredoka One',
		'Frank Ruhl Libre' => 'Frank Ruhl Libre',
		'Gloria Hallelujah' => 'Gloria Hallelujah',
		'Great Vibes' => 'Great Vibes',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Kaushan Script:' => 'Kaushan Script',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Montserrat:400,700' => 'Montserrat',
		'Oxygen:400,300,700' => 'Oxygen',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Oswald:400,700' => 'Oswald',
		'PT Serif:400,700' => 'PT Serif',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'Poppins:0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900' => 'Poppins',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Raleway:400,700' => 'Raleway',
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
	);

	$wp_customize->add_setting( 'web_developer_headings_fonts', array(
		'sanitize_callback' => 'web_developer_sanitize_fonts',
	));
	$wp_customize->add_control( 'web_developer_headings_fonts', array(
		'type' => 'select',
		'description' => __('Select your desired font for the headings.', 'web-developer'),
		'section' => 'web_developer_google_fonts_section',
		'choices' => $font_choices
	));

	$wp_customize->add_setting( 'web_developer_body_fonts', array(
		'sanitize_callback' => 'web_developer_sanitize_fonts'
	));
	$wp_customize->add_control( 'web_developer_body_fonts', array(
		'type' => 'select',
		'description' => __( 'Select your desired font for the body.', 'web-developer' ),
		'section' => 'web_developer_google_fonts_section',
		'choices' => $font_choices
	));
}
add_action( 'customize_register', 'web_developer_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function web_developer_customize_preview_js() {
	wp_enqueue_script( 'web_developer_customizer', esc_url(get_template_directory_uri()) . '/js/customize-preview.js', array( 'customize-preview' ), '20161510', true );
}
add_action( 'customize_preview_init', 'web_developer_customize_preview_js' );
