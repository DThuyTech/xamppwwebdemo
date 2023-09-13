<?php
/**
 * @package Web Developer
 * Setup the WordPress core custom header feature.
 *
 * @uses web_developer_header_style()
 */
function web_developer_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'web_developer_custom_header_args', array(		
		'default-text-color'     => 'fff',
		'width'                  => 2500,
		'height'                 => 280,
		'wp-head-callback'       => 'web_developer_header_style',		
	) ) );
}
add_action( 'after_setup_theme', 'web_developer_custom_header_setup' );

if ( ! function_exists( 'web_developer_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see web_developer_custom_header_setup().
 */
function web_developer_header_style() {
	$header_text_color = get_header_textcolor();
	?>
	<style type="text/css">
	<?php
		//Check if user has defined any header image.
		if ( get_header_image() || get_header_textcolor() ) :
	?>
		.top_header {
			background: url(<?php echo esc_url( get_header_image() ); ?>) no-repeat;
			background-position: center top; background-size:100% 100%;
		}
	<?php endif; ?>	


	h1.site-title a, p.site-title a{
		color: <?php echo esc_attr(get_theme_mod('web_developer_sitetitle_color')); ?>;
	}

	span.site-description {
		color: <?php echo esc_attr(get_theme_mod('web_developer_sitetagline_color')); ?>;
	}

	.top_header {
		background: <?php echo esc_attr(get_theme_mod('web_developer_bgtop_color')); ?>;
	}

	.header, .page-template-template-home-page .header {
		background: <?php echo esc_attr(get_theme_mod('web_developer_bgBottom_color')); ?>;
	}

	.top_header i {
		color: <?php echo esc_attr(get_theme_mod('web_developer_addressicon_color')); ?>;
	}

	.top_header .top-text {
		color: <?php echo esc_attr(get_theme_mod('web_developer_titleaddress_color')); ?>;
	}

	.top_header .top-contact {
		color: <?php echo esc_attr(get_theme_mod('web_developer_addresstext_color')); ?>;
	}

	.top_header .border-right {
		border-color: <?php echo esc_attr(get_theme_mod('web_developer_border_color')); ?> !important;
	}

	.main-nav a {
		color: <?php echo esc_attr(get_theme_mod('web_developerMenu_color')); ?>;
	}
	.main-nav ul ul a {
		color: <?php echo esc_attr(get_theme_mod('web_developersubMenu_color')); ?>;
	}
	.main-nav ul ul {
		background: <?php echo esc_attr(get_theme_mod('web_developersubMenubg_color')); ?>;
	}
	.main-nav ul ul li {
		border-color: <?php echo esc_attr(get_theme_mod('web_developersubMenuborder_color')); ?>;
	}
	span.search_box input.search-submit {
		background-color: <?php echo esc_attr(get_theme_mod('web_developersearchbg_color')); ?>;
	}
	.toggle-nav button {
		color: <?php echo esc_attr(get_theme_mod('web_developermobileviewmenutext_color')); ?>;
	}
	.toggle-nav button {
		background: <?php echo esc_attr(get_theme_mod('web_developermobileviewmenubg_color')); ?>;
	}	






	.slider-box h1 {
		color: <?php echo esc_attr(get_theme_mod('web_developerslidertitle_color')); ?>;
	}

	.slider-box p {
		color: <?php echo esc_attr(get_theme_mod('web_developersliderdescription_color')); ?>;
	}

	.slide-btn a {
		color: <?php echo esc_attr(get_theme_mod('web_developersliderbtntext_color')); ?>;
	}

	.slide-btn a:hover {
		color: <?php echo esc_attr(get_theme_mod('web_developersliderbtntexthover_color')); ?>;
	}

	.slide-btn a {
		background: <?php echo esc_attr(get_theme_mod('web_developerbuttonbg_color')); ?>;
	}

	.slide-btn a:hover {
		background: <?php echo esc_attr(get_theme_mod('web_developerbuttonbghover_color')); ?>;
	}

	.bg-opacity {
		background: <?php echo esc_attr(get_theme_mod('web_developerboxopacity_color')); ?>;
	}

	.catwrapslider .owl-prev, .catwrapslider .owl-next {
		color: <?php echo esc_attr(get_theme_mod('web_developerarrow_color')); ?>;
	}

	.owl-prev, .owl-next {
		border-color: <?php echo esc_attr(get_theme_mod('web_developerarrowborder_color')); ?>;
	}

	.catwrapslider .owl-prev:hover, .catwrapslider .owl-next:hover {
		background: <?php echo esc_attr(get_theme_mod('web_developerarrowhover_color')); ?>;
	}




	#serives_box p.main_text {
		color: <?php echo esc_attr(get_theme_mod('web_developerservicemaintext_color')); ?>;
	}

	#serives_box h2 {
		color: <?php echo esc_attr(get_theme_mod('web_developerservicemaintitle_color')); ?>;
	}

	#serives_box hr, .services_inner_box {
		border-color: <?php echo esc_attr(get_theme_mod('web_developerserviceborder_color')); ?>;
	}

	.services_inner_box h3 a {
		color: <?php echo esc_attr(get_theme_mod('web_developerservicetitle_color')); ?>;
	}

	.services_inner_box p {
		color: <?php echo esc_attr(get_theme_mod('web_developerservicedescription_color')); ?>;
	}



	#footer {
		background-color: <?php echo esc_attr(get_theme_mod('web_developerfooterbg_color')); ?>;
	}

	.copywrap a{
		color: <?php echo esc_attr(get_theme_mod('web_developerfootercopytext_color')); ?>;
	}

	.copywrap a:hover{
		color: <?php echo esc_attr(get_theme_mod('web_developerfootercopytexthover_color')); ?>;
	}

	.copywrap {
		background-color: <?php echo esc_attr(get_theme_mod('web_developerfootercopybg_color')); ?>;
 	}

 	#footer h1,#footer h2,#footer h3,#footer h4,#footer h5,#footer h6 {
		color: <?php echo esc_attr(get_theme_mod('web_developerfooterheading_color')); ?>;
 	}

 	#footer p {
		color: <?php echo esc_attr(get_theme_mod('web_developerfooterdesciption_color')); ?>;
 	}

 	.ftr-4-box ul li a, .ftr-4-box a.readmore span {
		color: <?php echo esc_attr(get_theme_mod('web_developerfooterlist_color')); ?>;
 	}

 	.ftr-4-box ul li{
		border-color: <?php echo esc_attr(get_theme_mod('web_developerfooterlistborder_color')); ?>;
 	}

 	.listarticle h2 a:hover, #sidebar ul li a:hover, .ftr-4-box ul li a:hover, .ftr-4-box ul li.current_page_item a {
		color: <?php echo esc_attr(get_theme_mod('web_developerfooterlisthover_color')); ?>;
 	}





 


	</style>
	<?php 
}
endif;