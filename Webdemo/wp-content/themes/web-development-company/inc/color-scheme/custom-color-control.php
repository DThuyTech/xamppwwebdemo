<?php 

$web_development_company_custom_icon = get_theme_mod('web_development_company_custom_icon');

$web_developer_color_scheme_css = "";

if($web_development_company_custom_icon != true ){

  $web_developer_color_scheme_css .='.meta-feilds{';

  $web_developer_color_scheme_css .='background: none';

  $web_developer_color_scheme_css .='.services_inner_box h3{';

  $web_developer_color_scheme_css .='padding-top:20px !important';

 $web_developer_color_scheme_css .='}';

 
}