<?php 

$web_developer_color_scheme_gradiant1 = get_theme_mod('web_developer_color_scheme_gradiant1');

$web_developer_color_scheme_css = "";

if($web_developer_color_scheme_gradiant1 != false ){

  $web_developer_color_scheme_css .='a,.top_header i,
  .listarticle h2 a:hover, 
  #sidebar ul li a:hover, 
  .ftr-4-box ul li a:hover, 
  .ftr-4-box ul li.current_page_item a,
  p.main_text,
  #sidebar .tagcloud a,
  .ftr-4-box h5 span{';

  $web_developer_color_scheme_css .='color: '.esc_attr($web_developer_color_scheme_gradiant1).'';

 $web_developer_color_scheme_css .='}';

 $web_developer_color_scheme_css .='.toggle-nav button{';

  $web_developer_color_scheme_css .='color: '.esc_attr($web_developer_color_scheme_gradiant1).' !important';

 $web_developer_color_scheme_css .='}';

  $web_developer_color_scheme_css .='.listarticle, 
  aside.widget,
  #sidebar select,
  #sidebar input[type="text"],
  #sidebar input[type="search"], 
  #footer input[type="search"],
  #sidebar .tagcloud a,
  nav.woocommerce-MyAccount-navigation ul li{';

  $web_developer_color_scheme_css .='border-color: '.esc_attr($web_developer_color_scheme_gradiant1).'!important';

  $web_developer_color_scheme_css .='}';

  $web_developer_color_scheme_css .='.header,
  .banner-btn a, 
  .pagemore a, 
  .serv-btn a, 
  .woocommerce ul.products li.product .button, 
  .woocommerce #respond input#submit.alt, 
  .woocommerce a.button.alt, 
  .woocommerce button.button.alt, 
  .woocommerce input.button.alt, 
  .woocommerce a.button, 
  .woocommerce button.button, 
  .woocommerce #respond input#submit,
  #commentform input#submit,
  .main-nav ul ul,
  .copywrap,
  .slide-btn a:hover,
  .catwrapslider .owl-prev:hover, 
  .catwrapslider .owl-next:hover,
  span.onsale,
  #sidebar input.search-submit, 
  #footer input.search-submit, 
  form.woocommerce-product-search button,onsale,
  nav.woocommerce-MyAccount-navigation ul li:hover{';

  $web_developer_color_scheme_css .='background: '.esc_attr($web_developer_color_scheme_gradiant1).' !important';

  $web_developer_color_scheme_css .='}';

   $web_developer_color_scheme_css .='span.search_box input.search-submit{';

  $web_developer_color_scheme_css .='background: url(images/search.png) no-repeat scroll 10px 12px '.esc_attr($web_developer_color_scheme_gradiant1).'';

  $web_developer_color_scheme_css .='}';
}